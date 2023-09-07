<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ColorRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthUserController;
use Illuminate\Support\Facades\Validator;

class ColorController extends AuthUserController
{
    protected $color;

    public function __construct(ColorRepository $colorRepository)
    {
        $this->color = $colorRepository;
    }
    public function index(Request $request)

    {
        $color = $this->color->getAll();
        $result = array();
        $result['data'] = $color;

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
            'hex_code.required' => 'Mã màu không được để trống',
            'hex_code.unique' => 'Mã màu đã tồn tại',

        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'hex_code' => 'required|unique:colors,hex_code',
        ], $messages);
        $failed = $validator->fails();
        $isErr = false;
        if ($failed || $isErr) {
            $result['data']['errors'] = $validator->errors();
        } else {
            try {
                $color = $this->color->create($data);
                if ($color) {
                    $result['data']['data'] = $color;
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
                $color = $this->color->update($id, $data);
                if ($color) {
                    $result['data']['data'] = $color;
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
            $color = $this->color->delete($id);
            if ($color) {
                $result['data']['data'] = $color;
                $result['data']['success'] = 1;
            }
        } catch (\Exception $e) {
            $result['data']['errors'] = $e->getMessage();
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    
}
