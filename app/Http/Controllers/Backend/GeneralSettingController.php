<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data'] = GeneralSetting::pluck('value', 'type')->toArray();
        return view('backend/general_setting/general_settings',$data);
    }

    public function updateSetting(Request $request)
    {
        $param = $_GET['param'];
        $msg_data = array();
        $msg = "Data Saved Successfully";
        if (isset($param) && !empty($param)) {
            try {
                switch ($param) {
                    case 'general':
                        GeneralSetting::where("type", 'system_email')->update(["value" => $request->system_email]);
                        GeneralSetting::where("type", 'system_contact_no')->update(["value" => $request->system_contact_no]);
                        GeneralSetting::where("type", 'meta_title')->update(["value" => $request->meta_title]);
                        GeneralSetting::where("type", 'system_contact_no')->update(["value" => $request->system_contact_no]);
                        GeneralSetting::where("type", 'meta_keywords')->update(["value" => $request->meta_keywords]);
                        GeneralSetting::where("type", 'meta_description')->update(["value" => $request->meta_description]);
                        break;
                    case 'aboutus':
                        GeneralSetting::where("type", 'about_us')->update(["value" => $request->editiorData]);
                        break;
                    case 'tnc':
                        GeneralSetting::where("type", 'terms_and_condition')->update(["value" => $request->editiorData]);
                        break;
                    case 'privacy':
                        GeneralSetting::where("type", 'privacy_policy')->update(["value" => $request->editiorData]);
                        break;
                    case 'social':
                        GeneralSetting::where("type", 'fb_link')->update(["value" => $request->fb_link]);
                        GeneralSetting::where("type", 'insta_link')->update(["value" => $request->insta_link]);
                        GeneralSetting::where("type", 'twitter_link')->update(["value" => $request->twitter_link]);
                        break;
                    case 'appLink':
                        GeneralSetting::where("type", 'android_url')->update(["value" => $request->android_url]);
                        GeneralSetting::where("type", 'ios_url')->update(["value" => $request->ios_url]);
                        break;
                    case 'appVersion':
                        GeneralSetting::where("type", 'android_version')->update(["value" => $request->android_version]);
                        GeneralSetting::where("type", 'ios_version')->update(["value" => $request->ios_version]);
                        break;
                    default:
                        throw new \Exception("Invalid Paramter passed");
                }
                successMessage($msg, $msg_data);
                //return redirect('webadmin/generalSetting');
                ///return redirect()->back()->withErrors(array("msg"=>$msg));
            } catch (\Exception $e) {
                \Log::error("General Setting Submit. Error: " . $e->getMessage());
                errorMessage('Something Went Wrong', $msg_data);
            }
        } else {
            errorMessage('Something Went Wrong', $msg_data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GeneralSetting  $generalSetting
     * @return \Illuminate\Http\Response
     */
    public function show(GeneralSetting $generalSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GeneralSetting  $generalSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(GeneralSetting $generalSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GeneralSetting  $generalSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GeneralSetting $generalSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GeneralSetting  $generalSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(GeneralSetting $generalSetting)
    {
        //
    }
}
