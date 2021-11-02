<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function addProducts(){
        $categories = Category::All()->pluck('categoryName','categoryName');
        return view('admin.addProducts')->with('categories',$categories);
    }

    public function products(){
        $product = Product::All();
        return view('admin.products')->with('product',$product);
    }

    public function createProduct(Request $request){
        $this->validate($request,['productName'=>'required'
                                , 'productPrice'=>'required'
                                , 'productCategory'=>'required'
                                , 'productImage'=>'image|nullable|max:1999']);
        
        if($request->hasFile('productImage')){
            /* 1:Get file name with exte */
            $fileNameWithExt = $request->file('productImage')->getClientOriginalName();
            // 2: Get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // 3:get just file extension
            $exstension = $request->file('productImage')->getClientOriginalExtension();
            // 4:File name store
            $fileNameToStore = $fileName.'_'.time().'.'.$exstension;

            //upload image
            $path = $request->file('productImage')->storeAs('public/productImages',$fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }

        $product = new Product();

        $product->productName = $request->input('productName');
        $product->productPrice = $request->input('productPrice');
        $product->productCategory = $request->input('productCategory');
        $product->productImage = $fileNameToStore;
        $product->status = 1;

        $product->save();

        return back()->with('status','Product successfully created!');
    }

    public function editProduct($id){
        $product = Product::find($id);
        $categories = Category::All()->pluck('categoryName','categoryName');
        return view('admin.editProduct')->with('product',$product)->with('categories',$categories);
    }

    public function updateProduct(Request $request){

        $this->validate($request,['productName'=>'required'
                                , 'productPrice'=>'required'
                                , 'productCategory'=>'required'
                                , 'productImage'=>'image|nullable|max:1999']);

            
        $product = Product::find($request->input('id'));
        $product->productName = $request->input('productName');
        $product->productPrice = $request->input('productPrice');
        $product->productCategory = $request->input('productCategory');
        if($request->hasFile('productImage')){
         /* 1:Get file name with exte */
        $fileNameWithExt = $request->file('productImage')->getClientOriginalName();
         // 2: Get just file name
         $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);             
         // 3:get just file extension
        $exstension = $request->file('productImage')->getClientOriginalExtension();
         // 4:File name store
         $fileNameToStore = $fileName.'_'.time().'.'.$exstension;
                        
         //upload image
         $path = $request->file('productImage')->storeAs('public/productImages',$fileNameToStore);

         if($product->productImage != 'noimage.jpg'){
            Storage::delete('public/productImages/'.$product->productImage);  
         }

         $product->productImage = $fileNameToStore;
        }

        
        
        

        $product->update();

        return redirect('/products')->with('status','The Product with ID:'.$product->id.' has been successfully updated');
    }

    public function deleteProduct($id){
        $product = Product::find($id);
        if($product->productImage != 'noimage.jpg'){
            Storage::delete('public/productImages/'.$product->productImage);  
         }
        $product->delete();

        return back()->with('status','The product has been successfully deleted');

    }

    public function activateProduct($id){
        $product = Product::find($id);

        
            $product->status = 1;
        

        $product->update();
        return back();
    }

    public function unactivateProduct($id){
        $product = Product::find($id);

        
            $product->status = 0;
        

        $product->update();

        return back();
    }

    public function viewByCat($categoryName){
        $products = Product::All()->where('productCategory', $categoryName)->where('status',1);
        $category = Category::All();
        return view('client.shop')->with('products',$products)->with('category',$category);
    }
}
