<?php

namespace App\Http\Controllers\Defaults\Marquee;

use App\Http\Controllers\Controller;
use App\Models\Marquee;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class MarqueeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $marquees = Marquee::get();
        // dd($marquees);

        return view('defaults.marquee.list', compact('marquees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get(['id', 'name']);
        return view('defaults.marquee.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "content" => "required",
            "text_color" => "required",
            "background_color" => "required",
            "status" => "required",
            "roles" => "required"
        ]);
        $roles = implode(",", $request->roles);
        $input = [
            "content" =>$request->content,
            "text_color" =>$request->text_color,
            "background_color" =>$request->background_color,
            "roles" =>$roles,
            "status" =>$request->status,
        ];
        // echo "<pre/>";print_r($input);die;
        Marquee::insert($input);

        return redirect()->route("marquees.index")->with("success", "Marquee added successfully");
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
        $marquee = Marquee::find($id);
        $roles = Role::get(['id', 'name']);
        return view('defaults.marquee.edit', compact('marquee','roles'));
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
        // dd($request);
        $this->validate($request, [
            "content" => "required",
            "text_color" => "required",
            "background_color" => "required",
            "status" => "required"
        ]);

        // $input = $request->except(["_token", "_method"]);
        $roles = implode(",", $request->roles);
        $input = [
            "content" =>$request->content,
            "text_color" =>$request->text_color,
            "background_color" =>$request->background_color,
            "roles" =>$roles,
            "status" =>$request->status,
        ];
        // echo "<pre/>";print_r($input);die;

        Marquee::where("id", $id)->update($input);

        return redirect()->route("marquees.index")->with("success", "Marquee updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Marquee::find($id)->delete();
        return redirect()->route("marquees.index")->with("success", "Marquee deleted successfully");
    }
}
