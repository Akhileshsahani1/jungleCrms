<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PeopleController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:customer')->except('logout');
    }

    public function viewLogin(){
        return view('front.auth.login');
    }
    public function sendOtp(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|numeric|digits:10',
        ]);

        $account_exists = Customer::where('mobile', $request->phone)->exists();
        if ($account_exists) {
            $user       = Customer::where('mobile', $request->phone)->first();


            Session::put('otp', mt_rand(1111, 9999));
            $otp = Session::get('otp');
            Http::get('http://login.pacttown.com/api/mt/SendSMS?user=N2RTECHNOLOGIES&password=994843&senderid=JUNGSI&channel=Trans&DCS=0&flashsms=0&number='.$request->phone.'&text=Your one time password to activate your account is ' . $otp . '. Jungle Safari India');


            return view('front.auth.verify-otp', compact('user', 'otp'));
        } else {
            return redirect()->back()->withInput()->with('error', 'No account found associated with this Phone Number.');
        }
    }

    public function verifyOtp(Request $request)
    {
        $this->validate($request, [
            'otp' => 'required|numeric|digits:4',
        ]);
        $otp = Session::get('otp');
        if ($otp == $request->otp) {
            $customer  = Customer::where('mobile', $request->phone)->first();
            Auth::guard('customer')->login($customer);
            $authuser = Customer::find(Auth::guard('customer')->user()->id);
            // $authuser->is_active = 1;
            $authuser->save();
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->withInput()->with('error', 'You have Entered wrong OTP. Please try again.');
        }
        return $otp;
    }

    public function logout(Request $request)
    {

        if (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
            return redirect()->route('dashboard.login');
        }
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
        ]);


        $customer  = Customer::where('email', $request->email)->first();
        Auth::guard('customer')->login($customer);

        return redirect()->intended(route('dashboard'));
    }
}
