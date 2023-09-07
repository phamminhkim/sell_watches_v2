<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ShoppingCardRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthUserController;
use Illuminate\Support\Facades\Validator;

class ShoppingCardController extends AuthUserController
{
    protected $shopping;

    public function __construct(ShoppingCardRepository $ShoppingCardRepository)
    {
        $this->shopping = $ShoppingCardRepository;
    }
    public function index(Request $request)

    {
        $shopping = $this->shopping->getAll();
        $result = array();
        $result['data'] = $shopping;

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
