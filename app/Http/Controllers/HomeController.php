<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthUserController;

class HomeController extends AuthUserController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }

    public function admin()
    {
        return view('sell_color');
    }
    public function category()
    {
        
        return view('category');
    }
    public function brand()
    {
        
        return view('brand');
    }

  
}
