<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $activities      = UserActivity::with('user');
        $users           = User::get(['id', 'name', 'is_active']);       
        $filter_date     = $request->filter_date;
        $filter_user     = $request->filter_user;
        $filter_type     = $request->filter_type;
        if (isset($filter_user)) {
            $activities = $activities->where('user_id', $filter_user);
        }

        if (isset($filter_type)) {
            $activities = $activities->where('type', $filter_type);
        }
       
        if (isset($filter_date)) {
            $activities = $activities->whereDate('created_at', Carbon::parse($request->filter_date)->format('Y-m-d'));
        }

        if (Auth::user()->hasRole('administrator')){
            $activities = $activities->latest()->paginate(20);

            return view('activities.list', compact('activities', 'users', 'filter_date', 'filter_user', 'filter_type'));
        }else{
            $activities = $activities->where('user_id', Auth::user()->id);
            $activities = $activities->latest()->paginate(20);

            return view('activities.list', compact('activities', 'users', 'filter_date', 'filter_user', 'filter_type'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserActivity::find($id)->delete();

        return redirect()->back()->with('success','Activities deleted successfully');
    }
}
