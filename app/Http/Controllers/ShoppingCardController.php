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

    public function store(Request $request)
    {
        $result['data'] = array();
        $result['data']['success'] = 0;
        date_default_timezone_set("Asia/Ho_Chi_Minh");


        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity' => 'required',
        ]);
        $failed = $validator->fails();
        $isErr = false;
        $data = $request->all();
        $user = Auth::user();
      
        if ($failed || $isErr) {
            $result['data']['errors'] = $validator->errors();
        } else {
            try {
                $shopping = $this->shopping->create($data, $user);
                $result['data']['data'] = $shopping;
                $result['data']['success'] = 1;
            } catch (\Exception $e) {
                $result['data']['errors'] = $e->getMessage();
            }
        }

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function destroy($id){
        $result['data'] = array();
        $result['data']['success'] = 0;
        $shopping = $this->shopping->delete($id);
        $result['data']['data'] = $shopping;
        $result['data']['success'] = 1;
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function increasing_quantity_shoppingcard($id){
        $result['data'] = array();
        $result['data']['success'] = 0;
        $shopping = $this->shopping->increasing_quantity_shoppingcard($id);
        $result['data']['data'] = $shopping;
        $result['data']['success'] = 1;
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function reduce_quantity_shoppingcard($id){
        $result['data'] = array();
        $result['data']['success'] = 0;
        $shopping = $this->shopping->reduce_quantity_shoppingcard($id);
        $result['data']['data'] = $shopping;
        $result['data']['success'] = 1;
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
  
    
}
