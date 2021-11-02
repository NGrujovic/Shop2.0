<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addCategory(){
        return view('admin.addCategory');
    }

    public function categories(){
        $categories = Category::All();
        return view('admin.category')->with('categories', $categories);
    }

    public function savecategory(Request $request){
        $this->validate($request,['categoryName'=>'required|unique:categories']);


        $category = new Category();
        $category->categoryName = $request->input('categoryName');
        $category->save();

        return back()->with('status','The category  has been successfuly saved!!');
    }

    public function editCategory($id){

        $category = Category::find($id);

        return view('admin.editCategory')->with('category',$category);
        
    }

    public function updateCategory(Request $request){
        $this->validate($request,['categoryName'=>'required']);
        $category = Category::find($request->input('id'));
        $category->categoryName = $request->input('categoryName');

        $category->update();

        return redirect('/categories')->with('status','The category Name has been successfully updated');
    }

    public function deleteCategory($id){
        $category = Category::find($id);
        $category->delete();

        return back()->with('status','The category has been successfully deleted');

    }

    
}
