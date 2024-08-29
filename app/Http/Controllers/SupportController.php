<?php

namespace App\Http\Controllers;

use App\Models\Support;
use App\Models\SupportChat;
use App\Models\Customer;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter_date_from       = $request->input('filter_date_from');
        $filter_date_to         = $request->input('filter_date_to');
        $filter_status          = $request->input('filter_status');

        $tickets = Support::with('chats');

        if (isset($filter_date_from)) {
            $tickets = $tickets->whereDate('created_at','>=', Carbon::parse($filter_date_from)->format('Y-m-d'));
        }
        if (isset($filter_date_to)) {
            $tickets = $tickets->whereDate('created_at','<=', Carbon::parse($filter_date_to)->format('Y-m-d'));
        }
        if (isset($filter_status)) {
            $tickets = $tickets->where('status',$filter_status);
        }

        $tickets = $tickets->latest()->paginate(20);

        $open_ticket_count = $tickets->where('status','0')->count();
        $closed_ticket_count = $tickets->where('status','1')->count();

        return view('supports.list', compact('tickets','open_ticket_count','closed_ticket_count','filter_date_from','filter_date_to','filter_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $customers = Customer::get(['id','name']);

         return view('supports.create', compact('customers'));
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
            'subject'       => 'required',
            'description'   => 'required',
            'customer_name' => 'required',
            'priority'      => 'required'
        ]);

        $ticket                 = new Support();
        $ticket->customer_id    = $request->customer_id;
        $ticket->subject        = $request->subject;
        $ticket->description    = $request->description;
        $ticket->priority       = $request->priority;
        $ticket->subject        = $request->subject;
        $ticket->booking_id     = $request->booking_id;
        $ticket->user_id        = Auth::user()->id;

        if ($request->hasfile('attachment')) {
            $attachment         = $request->file('attachment');
            $name               = $attachment->getClientOriginalName();
            $attachment->storeAs('uploads/customers/tickets/'.$request->customer_id, $name, 'public');

            $ticket->attachment        = $name;
        }
        $ticket->save();
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'ticket added',
            'comment' => 'A Support Ticket has been generated for <a href="'.route('support.show', $ticket->id).'">Ticket No. '.$ticket->id.'</a>'
        ]);

       return redirect()->route('support.index')->with('success', 'Ticket generated successfully !');
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
        SupportChat::where('support_id', $id)->where('sender', 'customer')->where('seen', 0)->update(['seen' => true]);
        return view('supports.chat', compact('ticket'));
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
        return view('supports.edit', compact('ticket'));
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
            'status' => 'required'
        ]);

        $ticket                 = Support::find($id);        
        $ticket->status         = $request->status;
        $ticket->save();
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'ticket updated',
            'comment' => 'A Support Ticket has been updated for <a href="'.route('support.show', $id).'">Ticket No. '.$id.'</a>'
        ]);

        return redirect()->route('support.index')->with('success', 'Ticket updated successfully !');
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
        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'ticket updated',
            'comment' => 'A Support Ticket has been deleted.'
        ]);
        return redirect()->route('support.index')->with('success', 'Ticket deleted successfully !');
    }

    public function sendMessage(Request $request, $id){

        $this->validate($request, [
            'message' => 'required',
        ]);
        SupportChat::create([
            'customer_id' => Support::where('id', $id)->first()->customer_id,
            'support_id' => $id,
            'sender' => 'admin',
            'message' => $request->message,
        ]);

        return redirect()->route('support.show', $id)->with('success', 'Message sent successfully !');
    }
}
