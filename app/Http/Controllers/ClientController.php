<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use Session;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use App\Cart;


class ClientController extends Controller
{
    public function home(){
        $sliders = Slider::All()->where('status','1');

        $products = Product::All()->where('status','1');
        return view('client.home')->with('sliders',$sliders)->with('products',$products);
    }

    public function shop(){
        $category = Category::All();
        $products = Product::All()->where('status','1');
        return view('client.shop')->with('products',$products)->with('category',$category);
    }

    public function cart(){
        if(!Session::has('cart')){
            return view('client.cart');
        }

        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);
         
        Session::put('cart', $cart);

        return view('client.cart', ['products'=> $cart->items]);
    }

    public function checkout(){
        if(!Session::has('client')){
            return view('client.login');
        }

        if(!Session::has('cart')){
            return redirect('/cart')->with('status','You cant checkout with an empty cart!');
        }
        return view('client.checkout');
    }

    public function login(){
        return view('client.login');
    }
    public function logout(){
        Session::forget('client');

        return redirect('/shop');
    }

    public function register(){
        return view('client.register');
    }

    public function addToCart($id){
        $product = Product::find($id);

        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        Session::put('cart', $cart);

        /* dd(Session::get('cart')); */ //This line helps you see what session contains in browser
        return back(); 
    }

    public function updateQty(Request $request,$id){
        //print('the product id is '.$request->id.' And the product qty is '.$request->quantity);
        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->updateQty($request->id, $request->quantity);
        Session::put('cart', $cart);

        //dd(Session::get('cart'));
        return redirect('/cart');
    }

    public function deleteCart($product_id){
        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->deleteCart($product_id);
       
        if(count($cart->items) > 0){
            Session::put('cart', $cart);
        }
        else{
            Session::forget('cart');
        }

        //dd(Session::get('cart'));
        if(count($cart->items) > 0){
            return redirect('/cart');
        }
        else{
            return redirect('/shop');
        }
        
    }
    
    public function signup(Request $request){
        $this->validate($request, ['firstName'=>'required|max:30|alpha',
                                    'lastName'=>'required|max:30|alpha',
                                    'username'=>'required|max:30|alpha_dash|unique:clients',
                                    'email'=>'required|unique:clients',
                                    'email2'=>'required|same:email',
                                    'pass'=>'required|min:4',
                                    'confirmPass' => 'required|same:pass']);

        $client = new Client();

        $client->email = $request->input('email');
        $client->clientName = $request->input('firstName');
        $client->clientLastName = $request->input('lastName');
        $client->username = $request->input('username');
        $client->password = bcrypt($request->input('password'));

        $client->save();

        return back()->with('status','Your account has been successfuly created!');

    }

    public function signIn(Request $request){
        $this->validate($request,['username'=>'required',
        'pass'=>'required']);

        $client = Client::where('username', $request->input('username'))->first();

        if($client){

            if(Hash::check($request->input('password'),$client->password)){
                
                if($client->role == 1){
                    Session::put('admin',$client);
                    return redirect('/admin');
                }else{
                    Session::put('client',$client);
                    return redirect('/shop');
                }
            }else{  
                return back()->with('status','Incorrect Username or Password');    
            }
        }else{
            return back()->with('status','Username not correct');
        }
        
    }

    public function order(Request $request){
        $this->validate($request, ['firstName'=>'required|alpha',
                                    'lastName'=>'required|alpha',
                                    'adress'=>'required',
                                    'city'=>'required|alpha',
                                    'phone'=>'required|alpha_num',
                                    'postal'=>'required|alpha_num'
                                    
                                    ]);

        $order = new Order();
        $payer_Id = time();
        $order->firstName = $request->input('firstName');
        $order->lastName = $request->input('lastName');
        $order->Adress	 = $request->input('adress');
        $order->City = $request->input('city');
        $order->postalCode = $request->input('postal');
        $order->phone = $request->input('phone');
        $order->payerId = $payer_Id;
        
        $oldCart = Session::has('cart')? Session::get('cart'):null;
        $cart = new Cart($oldCart);

        $order->cart = serialize($cart);
        $order->save();
        
        





        Session::forget('cart');

        $orders = Order::where('payerId', $payer_Id)->get();

        $orders->transform(function($order,$key){
            $order->cart = unserialize($order->cart);

            return $order;


        });
        $email = Session::get('client')->email;

        Mail::to($email)->send(new SendMail($orders));

        return redirect('/cart')->with('status','You successfuly placed an order!');
    }
    
}
