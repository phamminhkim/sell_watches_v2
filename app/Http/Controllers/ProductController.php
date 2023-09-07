<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthUserController;
use Illuminate\Support\Facades\Validator;


class ProductController extends AuthUserController
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->getAll();
        $result = array();
        $result['data'] = $products; 

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $result['data'] = array();
        $result['data']['success'] = 0;
        date_default_timezone_set("Asia/Ho_Chi_Minh");

        $messages = [
            'name.required' => 'Tên màu sắc không được để trống',
           
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            
        ], $messages);
        $failed = $validator->fails();
        $isErr = false;
        if ($failed || $isErr) {
            $result['data']['errors'] = $validator->errors();
        } else {
            try {
                $productRepository = $this->productRepository->create($data);
                if ($productRepository) {
                    $result['data']['data'] = $productRepository;
                    $result['data']['success'] = 1;
                }
            } catch (\Exception $e) {
                $result['data']['errors'] = $e->getMessage();
            }
        }


        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $result['data'] = array();
        $result['data']['success'] = 0;
        date_default_timezone_set("Asia/Ho_Chi_Minh");

        $messages = [
            // 'name.required' => 'Tên khách hàng không được để trống',
            // 'code.required' => 'Mã khách hàng không được để trống',
            // 'code.unique' => 'Mã danh mục đã tồn tại đã tồn tại',

        ];
        $validator = Validator::make($request->all(), [
            // 'name' => 'required',
            // 'code' => 'required|unique:categories,code ' . $id,
        ], $messages);
        $failed = $validator->fails();
        $isErr = false;
        if ($failed || $isErr) {
            $result['data']['errors'] = $validator->errors();
        } else {
            try {
                $productRepository = $this->productRepository->update($id, $data);
                if ($productRepository) {
                    $result['data']['data'] = $productRepository;
                    $result['data']['success'] = 1;
                }
            } catch (\Exception $e) {
                $result['data']['errors'] = $e->getMessage();
            }
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function destroy($id)
    {
        $result['data'] = array();
        $result['data']['success'] = 0;
        try {
            $productRepository = $this->productRepository->delete($id);
            if ($productRepository) {
                $result['data']['data'] = $productRepository;
                $result['data']['success'] = 1;
            }
        } catch (\Exception $e) {
            $result['data']['errors'] = $e->getMessage();
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    public function edit($id){
        $products = $this->productRepository->getById($id);
        $result = array();
        $result['data'] = $products; 

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

  
}
