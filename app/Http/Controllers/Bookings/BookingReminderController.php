<?php

namespace App\Http\Controllers\Bookings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingReminder;
use App\Models\Booking;

class BookingReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter_booking_status=$request->filter_booking_status;
        $booking = Booking::find($request->booking_id);
        $reminders = BookingReminder::where('booking_id', $booking->id)->latest()->get();
        return view('bookings.reminders', compact('reminders', 'booking','filter_booking_status'));
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
        $reminder                    = isset($request->id) ? BookingReminder::find($request->id)  : new BookingReminder;
        $reminder->booking_id        = $request->booking_id;
        $reminder->date              = $request->date;
        $reminder->amount            = $request->amount;
        $reminder->save();

        return redirect()->back()->with('success', 'Reminder saved successfully.');

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
         $reminder = BookingReminder::find($id)->delete();
        return redirect()->back()->with('success', 'Reminder delete successfully.');
    }
}
