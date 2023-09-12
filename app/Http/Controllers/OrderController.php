<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthUserController;
use Illuminate\Support\Facades\Validator;

class OrderController extends AuthUserController
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request){
        $orders = $this->orderRepository->getAll();
        $result = array();
        $result['data'] = $orders; 

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request){
        $data = $request->all();
        $result['data'] = array();
        $result['data']['success'] = 0;
        date_default_timezone_set("Asia/Ho_Chi_Minh");

        $messages = [
            'shipping_address.required' => 'Địa chỉ giao hàng không được để trống',
            'payment_method.required' => 'Phương thức thanh toán không được để trống',
        ];
        $validator = Validator::make($request->all(), [
            'shipping_address' => 'required',
            'payment_method' => 'required',
        ], $messages);
        $failed = $validator->fails();
        $isErr = false;
        $user = Auth::user();
        if ($failed || $isErr) {
            $result['data']['errors'] = $validator->errors();
        } else {
            try {
                $orderRepository = $this->orderRepository->create($data, $user);
                if ($orderRepository) {
                    $result['data']['data'] = $orderRepository;
                    $result['data']['success'] = 1;
                }
            } catch (\Exception $e) {
                $result['data']['errors'] = $e->getMessage();
            }
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function processing($id){
        $result['data'] = array();
        $result['data']['success'] = 0;
        $order = $this->orderRepository->processing($id);
        if ($order) {
            $result['data']['data'] = $order;
            $result['data']['success'] = 1;
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function success($id){
        $result['data'] = array();
        $result['data']['success'] = 0;
        $order = $this->orderRepository->success($id);
        if ($order) {
            $result['data']['data'] = $order;
            $result['data']['success'] = 1;
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    
}
