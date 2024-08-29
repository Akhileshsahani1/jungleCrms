<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('settings.my-account', compact('user'));
    }

    public function update(Request $request){
        $id = Auth::user()->id;

        $user = User::find($id);

        $this->validate($request,[
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if(isset($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->leads_per_day = $request->leads_per_day;
        $user->save();
        return redirect()->route('my-account')->with('success', 'Your account is updated Successfully');
    }
}
