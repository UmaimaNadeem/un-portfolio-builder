<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController as BaseController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Traits\AuthTrait;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Validator;

class AuthController extends BaseController
{
    use AuthTrait;

    public function register()
    {
        return view('pages.auth.register');
    }

    public function registerPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'mobile_number' => 'required|string|max:15',
            'city' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($validator->passes()) {
            if($request->mobile_number) {
                $mobileExits = User::where('mobile_number', $request->mobile_number)->first();
                if ($mobileExits) {
                    return back()->withErrors('Mobile is already used')->withInput();
                }
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile_number = $request->mobile_number;
            $user->city = $request->city;
            $user->password = Hash::make($request->password);
            $user->save();

            $response = $this->sendVerificationEmail($user);
            if(isset($response['response']) && $response['response'] == 'success'){
                return redirect()->route('auth.email.verification.message');
            }
            else{
                return redirect("register")->with('error', 'Email is not sent. Contact with support!');
            }
        }
    }

    public function login()
    {
        $currentUser = Auth::user();
        if ($currentUser) {
            if ($currentUser->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($currentUser->role == 'member') {
                return redirect()->route('member.dashboard');
            } else {
                return redirect()->route('auth.login');
            }
        }

        return view('pages.auth.login');
    }


    public function loginProcess(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'required' => 'The :attribute is required',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }

        if ($validator->passes()) {

            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $currentUser = Auth::user();

                if ($currentUser->status === 0) {
                    Auth::logout();
                    return redirect()->route('auth.login')->withErrors('Your account is deactivated. Please contact support.');
                }

                if($currentUser->role == 'admin' || $currentUser->role == 'superAdmin'){
                    return redirect()->route("admin.dashboard");
                }

                if($currentUser->role == 'member'){
                    return redirect()->route("member.dashboard");
                }

            }

            return redirect()->route('auth.login')->withErrors('Credentials are wrong.');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('auth.login');
    }
}
