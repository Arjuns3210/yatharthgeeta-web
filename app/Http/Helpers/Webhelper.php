<?php

use App\Models\DisplayMsg;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorDevice;
use App\Models\CustomerDevice;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Storage;
use Image as thumbimage;

if(!function_exists('formatName')){
    function formatName($unformatted_name = '',$reverse_format = false)
    {
        $formatted_name = '';

        if (!empty($unformatted_name)) {
            if($reverse_format){
                $formatted_name = str_replace('-', '_', $unformatted_name);
            }else{
                $formatted_name = str_replace('-', ' ', $unformatted_name);
            }
        }

        return $formatted_name;
    }
}
if (!function_exists('errorMessage')) {
    function errorMessage($msg = '', $data = array(), $expireSessionCode = "")
    {
        $return_array = array();
        $return_array['success'] = '0';
        if ($expireSessionCode != "") {
            $return_array['success'] = $expireSessionCode;
        }
        $return_array['message'] = $msg;
        if (isset($data) && count($data) > 0)
            $return_array['data'] = $data;
        if (isset($other_data) && !empty($other_data)) {
            foreach ($other_data as $key => $val)
                $return_array[$key] = $val;
        }
        echo json_encode($return_array);
        exit();
    }
}

if (!function_exists('successMessage')) {
    function successMessage($msg = '', $data = array())
    {
        $return_array = array();
        $return_array['success'] = '1';
        $return_array['message'] = $msg;
        if (isset($data) && count($data) > 0)
            $return_array['data'] = $data;
        if (isset($other_data) && !empty($other_data)) {
            foreach ($other_data as $key => $val)
                $return_array[$key] = $val;
        }
        echo json_encode($return_array);
        exit();
    }
}

if (!function_exists('generateRandomOTP')) {
    function generateRandomOTP()
    {
        // return (rand(1000,9999));
        return (1234);
    }
}

if (!function_exists('checkPermission')) {
    function checkPermission($name)
    {
        if (session('data')['role_id'] == 1) {
            return true;
        }
        $permissions = Session::get('permissions');
        $permission_array = array();
        for ($i = 0; $i < count($permissions); $i++) {
            $permission_array[$i] = $permissions[$i]->codename;
        }
        if (in_array($name, $permission_array)) {
            return true;
        } else {
            return false;
        }
    }
}

if (! function_exists('storeMedia')) {

    function storeMedia($model, $file, $collectionName)
    {
        $model->addMedia($file)->toMediaCollection($collectionName,
            config('app.media_disc'));
    }
}
