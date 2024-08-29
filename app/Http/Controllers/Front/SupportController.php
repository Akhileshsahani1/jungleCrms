<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Support;
use App\Models\SupportChat;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Support::where('customer_id', Auth::guard('customer')->user()->id)->paginate(20);
        return view('front.supports.list', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $bookings = Booking::where('customer_id', Auth::guard('customer')->user()->id)->get();
        $booking_id = '';
        if(isset($request->booking_id)){
          $booking_id = $request->booking_id;
        }
        return view('front.supports.create',compact('bookings','booking_id'));
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
            'subject' => 'required',
            'description' => 'required',
            'priority' => 'required'
        ]);

        $ticket                 = new Support();
        $ticket->customer_id    = Auth::guard('customer')->user()->id;
        $ticket->subject        = $request->subject;
        $ticket->description    = $request->description;
        $ticket->priority       = $request->priority;
        $ticket->subject        = $request->subject;
        $ticket->booking_id     = $request->booking_id;
        if ($request->hasfile('attachment')) {
            $attachment         = $request->file('attachment');
            $name               = $attachment->getClientOriginalName();
            $attachment->storeAs('uploads/customers/tickets/'.Auth::guard('customer')->user()->id, $name, 'public');

            $ticket->attachment        = $name;
        }
        $ticket->save();

        return redirect()->route('dashboard.supports.index')->with('success', 'Ticket generated successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Support::with('chats')->find($id);
        SupportChat::where('support_id', $id)->where('sender', 'admin')->where('seen', 0)->update(['seen' => true]);
        return view('front.supports.chat', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Support::find($id);
        $bookings = Booking::where('customer_id', Auth::guard('customer')->user()->id)->get();
        return view('front.supports.edit', compact('ticket','bookings'));
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
            'subject' => 'required',
            'description' => 'required',
            'priority' => 'required'
        ]);

        $ticket                 = Support::find($id);
        $ticket->customer_id    = Auth::guard('customer')->user()->id;
        $ticket->subject        = $request->subject;
        $ticket->description    = $request->description;
        $ticket->priority       = $request->priority;
        $ticket->subject        = $request->subject;
        $ticket->booking_id     = $request->booking_id;
        if ($request->hasfile('attachment')) {
            $attachment         = $request->file('attachment');
            $name               = $attachment->getClientOriginalName();
            $attachment->storeAs('uploads/customers/tickets/'.Auth::guard('customer')->user()->id, $name, 'public');

            $ticket->attachment        = $name;
        }
        $ticket->save();

        return redirect()->route('dashboard.supports.index')->with('success', 'Ticket updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Support::find($id)->delete();
        return redirect()->route('dashboard.supports.index')->with('success', 'Ticket deleted successfully !');
    }

    public function sendMessage(Request $request, $id){

        $this->validate($request, [
            'message' => 'required',
        ]);
        SupportChat::create([
            'customer_id' => Auth::guard('customer')->user()->id,
            'support_id' => $id,
            'sender' => 'customer',
            'message' => $request->message,
        ]);

        return redirect()->route('dashboard.supports.show', $id)->with('success', 'Message sent successfully !');
    }
}
