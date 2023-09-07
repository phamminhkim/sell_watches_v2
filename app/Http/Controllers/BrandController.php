<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BrandRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthUserController;
use Illuminate\Support\Facades\Validator;

class BrandController extends AuthUserController
{
    protected $brand;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brand = $brandRepository;
    }
    public function index(Request $request)

    {
        $brand = $this->brand->getAll();
        $result = array();
        $result['data'] = $brand;

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $result['data'] = array();
        $result['data']['success'] = 0;
        date_default_timezone_set("Asia/Ho_Chi_Minh");

        $messages = [
            'name.required' => 'Tên thương hiệu không được để trống',
            'code.required' => 'Mã thương hiệu không được để trống',
            'code.unique' => 'Mã thương hiệu đã tồn tại đã tồn tại',

        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required|unique:categories,code',
        ], $messages);
        $failed = $validator->fails();
        $isErr = false;
        if ($failed || $isErr) {
            $result['data']['errors'] = $validator->errors();
        } else {
            try {
                $product = $this->brand->create($data);
                if ($product) {
                    $result['data']['data'] = $product;
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
                $product = $this->brand->update($id, $data);
                if ($product) {
                    $result['data']['data'] = $product;
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
            $product = $this->brand->delete($id);
            if ($product) {
                $result['data']['data'] = $product;
                $result['data']['success'] = 1;
            }
        } catch (\Exception $e) {
            $result['data']['errors'] = $e->getMessage();
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
