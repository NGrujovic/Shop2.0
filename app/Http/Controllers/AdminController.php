<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin(){
        return view('admin.indexPanel');
    }

    public function logout(){
        Session::forget('admin');

        return redirect('/login');
    }
}
