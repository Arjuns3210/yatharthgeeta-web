<?php


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

if (!function_exists('displayStatus')) {
    function displayStatus($displayValue = "")
    {
        $returnArray = array(
            '1' => 'Active',
            '0' => 'In-Active'
        );
        if (!empty($displayValue)) {
            $returnArray = $returnArray[$displayValue];
        }

        return $returnArray;
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
        // Replace spaces and specified symbols with underscores
        $fileName = preg_replace('/[!@#$%^ ]/', '_', $file->getClientOriginalName());
        
        $model->addMedia($file)->usingFileName($fileName)->toMediaCollection($collectionName, config('app.media_disc'));
    }
}

/**
 *   created by : Arjun Singh
 *   Created On : 14-Sept-2023
 *   Uses : To display globally records deleted or not
 *   @param $key
 *   @return Response
 */
if (!function_exists('isRecordDeleted')) {
    function isRecordDeleted($value = NULL)
    {
        if ($value == NULL) {
            $isDeleted = false;
        } else {
            $isDeleted = true;
        }
        return $isDeleted;
    }
}
