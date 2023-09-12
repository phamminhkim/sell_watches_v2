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
    if ($currentUser) {
      if ($currentUser->role !== 'admin') {
        return redirect('/');
      }
    }
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
    if ($currentUser) {
      if ($currentUser->role !== 'admin') {
        return redirect('/');
      }
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
    if ($currentUser) {
      if ($currentUser->role !== 'admin') {
        return redirect('/');
      }
    }

    view()->share('accessToken', $accessToken);
    view()->share('currentUser', $currentUser);
    return view('color');

  }

  public function orderList()
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

    if ($currentUser) {
      if ($currentUser->role !== 'admin') {
        return redirect('/');
      }
    }
    return view('orders');

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

    if ($currentUser) {
      if ($currentUser->role !== 'admin') {
        return redirect('/');
      }
    }
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

  public function card()
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
    return view('card');

  }
  public function buy_selected(Request $request)
  {
    $accessToken = null;
    $currentUser = null;
    $fields = $request->all();
    $buy_selecteds = $fields['selecteds'];
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
    return view('buy_selected', compact('buy_selecteds'));

  }
  public function order(Request $request)
  {
    $accessToken = null;
    $currentUser = null;
    $fields = $request->all();
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
    return view('order');

  }
}