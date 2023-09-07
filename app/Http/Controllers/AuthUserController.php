<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUserController extends Controller
{
    public function index(Request $request)
    {
        $accessToken = null;
        $currentUser = null;
        if (Auth::check()) {
            $user = Auth::user();
            
            // Kiểm tra nếu user đã có accessToken
            if ($user->accessToken) {
                $accessToken = $user->accessToken;
            } else {
                $accessToken = $user->createToken('authToken')->accessToken;
            }
            
            $currentUser = $user;
        }
    
       
        view()->share('accessToken', $accessToken);
        view()->share('currentUser', $currentUser);
        
        return view('welcome');
    }
    public function category()
    {
        $accessToken = null;
        $currentUser = null;
        
        if (Auth::check()) {
            $user = Auth::user();
            
            // Kiểm tra nếu user đã có accessToken
            if ($user->accessToken) {
                $accessToken = $user->accessToken;
            } else {
                $accessToken = $user->createToken('authToken')->accessToken;
            }
            
            $currentUser = $user;
        }
    
        
        view()->share('accessToken', $accessToken);
        view()->share('currentUser', $currentUser);
        
        return view('category');
    }
    public function brand()
    {
        $accessToken = null;
        $currentUser = null;
        
        if (Auth::check()) {
            $user = Auth::user();
            
            // Kiểm tra nếu user đã có accessToken
            if ($user->accessToken) {
                $accessToken = $user->accessToken;
            } else {
                $accessToken = $user->createToken('authToken')->accessToken;
            }
            
            $currentUser = $user;
        }
    
        
        view()->share('accessToken', $accessToken);
        view()->share('currentUser', $currentUser);
        return view('brand');
       
    }
    public function color()
    {
        $accessToken = null;
        $currentUser = null;
        
        if (Auth::check()) {
            $user = Auth::user();
            
            // Kiểm tra nếu user đã có accessToken
            if ($user->accessToken) {
                $accessToken = $user->accessToken;
            } else {
                $accessToken = $user->createToken('authToken')->accessToken;
            }
            
            $currentUser = $user;
        }
    
        
        view()->share('accessToken', $accessToken);
        view()->share('currentUser', $currentUser);
        return view('color');
       
    }
    public function product()
    {
        $accessToken = null;
        $currentUser = null;
        
        if (Auth::check()) {
            $user = Auth::user();
            
            // Kiểm tra nếu user đã có accessToken
            if ($user->accessToken) {
                $accessToken = $user->accessToken;
            } else {
                $accessToken = $user->createToken('authToken')->accessToken;
            }
            
            $currentUser = $user;
        }
    
        
        view()->share('accessToken', $accessToken);
        view()->share('currentUser', $currentUser);
        return view('product');
       
    }
    public function product_detail($id)
    {
        $accessToken = null;
        $currentUser = null;
        
        if (Auth::check()) {
            $user = Auth::user();
            
            // Kiểm tra nếu user đã có accessToken
            if ($user->accessToken) {
                $accessToken = $user->accessToken;
            } else {
                $accessToken = $user->createToken('authToken')->accessToken;
            }
            
            $currentUser = $user;
        }
    
        
        view()->share('accessToken', $accessToken);
        view()->share('currentUser', $currentUser);
        return view('product_detail', compact('id'));
       
    }
}
