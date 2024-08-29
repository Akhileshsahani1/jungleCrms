<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:customer')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $user = User::find(Auth::user()->id);
        // $user->is_active = 1;
        $user->save();
    }

    public function sendOtp(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|numeric|digits:10',
        ]);

        $account_exists = User::where('phone', $request->phone)->exists();
        if ($account_exists) {
            $user       = User::where('phone', $request->phone)->first();


            Session::put('otp', mt_rand(1111, 9999));
            // User::where('phone', $request->phone)->update(['otp' => \Session::get('otp')]);
            $otp = Session::get('otp');
            if ($user->hasRole('administrator')) {
                Http::get('http://login.pacttown.com/api/mt/SendSMS?user=N2RTECHNOLOGIES&password=994843&senderid=JUNGSI&channel=Trans&DCS=0&flashsms=0&number=9718717115&text=Your one time password to activate your account is admin_' . $otp . '. Jungle Safari India');
            } else {
                Http::get('http://login.pacttown.com/api/mt/SendSMS?user=N2RTECHNOLOGIES&password=994843&senderid=JUNGSI&channel=Trans&DCS=0&flashsms=0&number=9718717115&text=Your one time password to activate your account is user_' . $otp .'. Jungle Safari India');
            }


            return view('auth.verify-otp', compact('user', 'otp'));
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
            $user  = User::where('phone', $request->phone)->first();
            Auth::login($user);
            $authuser = User::find(Auth::user()->id);
            // $authuser->is_active = 1;
            $authuser->save();

            UserActivity::create([
                'user_id' => Auth::user()->id,
                'type'  => 'login',
                'comment' => 'User logged in successfully'
            ]);

            return redirect()->route('home');
        } else {
            return redirect()->back()->withInput()->with('error', 'You have Entered wrong OTP. Please try again.');
        }
        return $otp;
    }

    public function logout(Request $request)
    {        
        $user = User::find($request->user()->id);
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'  => 'logout',
            'comment' => 'User logged out successfully'
        ]);
        Cache::forget('user-is-online-' . $request->user()->id);       

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/login');
    }
}
