<?php

namespace App\Http\Controllers\Defaults\LongWeekend;

use App\Http\Controllers\Controller;
use App\Models\LongWeekend;
use Illuminate\Http\Request;

class LongWeekendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weekends = LongWeekend::get();
        return view('defaults.long-weekend.list', compact('weekends'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('defaults.long-weekend.create');
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
            'start' => 'required',
            'end'   => 'required'
        ]);

        $weekend = new LongWeekend();
        $weekend->start = $request->start;
        $weekend->end = $request->end;
        $weekend->save();

        return redirect()->route('long-weekends.index')->with('success', 'Long weekend added successfully!');
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
        $weekend = LongWeekend::find($id);
        return view('defaults.long-weekend.edit', compact('weekend'));
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
        $this->validate($request, [
            'start' => 'required',
            'end'   => 'required'
        ]);

        $weekend = LongWeekend::find($id);
        $weekend->start = $request->start;
        $weekend->end = $request->end;
        $weekend->save();

        return redirect()->route('long-weekends.index')->with('success', 'Long weekend updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {       

        LongWeekend::find($id)->delete();       

        return redirect()->route('long-weekends.index')->with('success', 'Long weekend deleted successfully!');
    }
}
