<?php
/*
    *   Developed by : Ankita - Mypcot Infotech
    *   Created On : 03-07-2023
    *   https://www.mypcot.com/
*/

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Role;

class LoginController extends Controller
{
    /**
     * Login screen will be displayed
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session()->has('data')) {
            return redirect('webadmin/dashboard');
        }
        return view('backend/auth/login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        \Log::info("Backend: Login started at: ".Carbon::now()->format('H:i:s:u'));
        try {
            $validationErrors = $this->validateLogin($request);
            if (count($validationErrors)) {
                \Log::error("Auth Exception: " . implode(", ", $validationErrors->all()));
                return redirect()->back()->withErrors(array("msg"=>implode("\n", $validationErrors->all())));
            }

            $email = strtolower($request->email);

            $response = Admin::with('role')->where([['email', $email],['password', md5($email.$request->password)]])->get();

            if(!count($response)) {
                \Log::error("Backend: User not found - "."email: ".$email.", password: ".$request->password);
                return redirect()->back()->withErrors(array("msg"=>"Invalid login credentials"));
            }

            if($response[0]['status'] != 1 ) {
                \Log::error("Backend: Account Suspended - "."email: ".$email.", password: ".$request->password);
                return redirect()->back()->withErrors(array("msg"=>"Your account is deactivated."));
            }

            \Log::info("Backend: Login Successful!");
            $data=array(
                "id"=>$response[0]['id'],
                "name"=>$response[0]['admin_name'],
                "email"=>$request->email,
                "role_id"=>$response[0]['role_id'],
                "permissions"=>$response[0]['role']['permission']
            );
            $request->session()->put('data',$data);
            return redirect('webadmin/dashboard');

        } catch (\Exception $e) {
            \Log::error("Backend: Login failed: " . $e->getMessage());
            return redirect()->back()->withErrors(array("msg"=>"Something went wrong"));
        }
    }

    /**
     * Validates input login
     *
     * @param Request $request
     * @return Response
     */
    public function validateLogin(Request $request)
    {
        return \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ])->errors();
    }
}
