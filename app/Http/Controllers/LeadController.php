<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Estimate;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\LeadFollowUp;
use App\Models\LeadReminder;
use App\Models\LeadStatus;
use App\Models\User;
use App\Models\UserActivity;
use App\Imports\LeadsImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Ladumor\OneSignal\OneSignal;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statuses               = LeadStatus::get(['id', 'name']);
        $users                  = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'administrator');
        })->get(['id', 'name', 'is_active']);

        $filter_status          = $request->input('filter_status');
        $filter_name            = $request->input('filter_name');
        $filter_website         = $request->input('filter_website');
        $filter_user            = $request->input('filter_user');
        $filter_mobile          = $request->input('filter_mobile');
        $filter_date_assigned   = $request->input('filter_date_assigned');
        $filter_date_from       = $request->input('filter_date_from');
        $filter_date_to         = $request->input('filter_date_to');
        $filter_user_assigned   = $request->input('filter_user_assigned');

        $leads = Lead::with('user', 'estimate', 'booking');


        if ($request->filter_status) {
            $leads->where('lead_status', '=', $request->input('filter_status'));
        }

        if ($request->filter_name) {
            $leads->where('name', 'LIKE', '%' . $request->input('filter_name') . '%');
        }

        if ($request->filter_mobile) {
            $leads->where('mobile', 'LIKE', '%' . $request->input('filter_mobile') . '%')->groupBy('mobile');
        }

        if ($request->filter_email) {
            $leads->where('email', 'LIKE', '%' . $request->input('filter_email') . '%')->groupBy('email');
        }

        if ($request->filter_website) {
            $leads->where('website', 'LIKE', '%' . $request->input('filter_website') . '%');
        }

        if ($request->filter_user) {
            $leads->where('assigned_to', $request->input('filter_user'));
        }

        if ($request->filter_user_assigned) {
            $leads->where('assigned_to', $request->input('filter_user_assigned'));
        }

        if ($request->filter_date_assigned) {
            $assigned   = date("Y-m-d", strtotime($request->input('filter_date_assigned')));
            $leads->whereDate('date_assigned', $assigned);
        }

        if ($request->filter_date_from && $request->filter_date_to) {

            $from   = date("Y-m-d", strtotime($request->input('filter_date_from')));
            $to     = date('Y-m-d', strtotime($request->input('filter_date_to')));
            $leads->whereBetween('date', [$from, $to]);
        }

        if ($request->filter_date_from) {
            $from   = date("Y-m-d", strtotime($request->input('filter_date_from')));
            $leads->whereDate('date', '>=', $from);
        }

        if ($request->filter_date_to) {
            $to     = date('Y-m-d', strtotime($request->input('filter_date_to')));
            $leads->whereDate('date', '<=', $to);
        }        

        if (Auth::user()->hasAnyRole('administrator|team lead|agent')) {

            $leads = $leads->orderBy('updated_at', 'desc')->latest()->paginate(20);

        } elseif (Auth::user()->hasRole('fresher')) {

            $leads = $leads->whereIn('assigned_to', [Auth::User()->id, 2])->groupBy('mobile')->orderBy('updated_at', 'desc')->latest()->paginate(20);
        
        } elseif (Auth::user()->hasRole('team-lead')) {

            $roles = Auth::user()->roles->pluck('name')->toArray();

            $leads = $leads->whereIn('website', $roles)->whereIn('assigned_to', [Auth::User()->id, 2])->groupBy('mobile')->orderBy('updated_at', 'desc')->latest()->paginate(20);
        
        } else {

            $roles = Auth::user()->roles->pluck('name')->toArray();
            if(Auth::user()->assign_lead == 0){
                $leads = $leads->whereIn('website', $roles)->whereIn('assigned_to', [Auth::User()->id, 2])->groupBy('mobile')->orderBy('updated_at', 'desc')->latest()->paginate(20);
            }else{
                $leads = $leads->whereIn('website', $roles)->whereIn('assigned_to', [Auth::User()->id])->groupBy('mobile')->orderBy('updated_at', 'desc')->latest()->paginate(20);
            }
           
            return view('leads.user-list', compact('leads', 'filter_status', 'filter_name', 'filter_user', 'filter_website', 'filter_date_from', 'filter_date_to', 'statuses', 'users', 'filter_date_assigned', 'filter_user_assigned'));
        
        }

        return view('leads.list', compact('leads', 'filter_status', 'filter_name', 'filter_user', 'filter_website', 'filter_date_from', 'filter_date_to', 'statuses', 'users', 'filter_date_assigned', 'filter_mobile', 'filter_user_assigned'));
    }


    public function leadHistory(Request $request, $id)
    {
        $response = Http::get(env('NODE_MONGO_URL') . '/getleadDetails/' . $id);
        $data = json_decode($response->body(), true);
        $statuses = LeadStatus::get(['id', 'name']);
        $leads = $data['result'];

        $mobile = $id;
        $lead_crm = Lead::with('user', 'estimate', 'booking');
        $lead_crm = Lead::where('mobile', $mobile)->latest()->paginate(20)->toArray();
        $c_id = $lead_crm['data'][0]['id'];
        $lead_crm = Lead::where('leads.mobile', $id)
            ->leftJoin('lead_comments', 'lead_comments.lead_id', '=', 'leads.id')
            ->leftJoin('users', 'users.id', '=', 'lead_comments.comment_by')
            ->select('lead_comments.comment', 'users.name as userName', 'leads.*')->latest()->paginate(20)->toArray();

        // Assign to user
        $lead       = Lead::find($c_id)->load('user', 'comments', 'reminders');
        $statuses   = LeadStatus::get(['id', 'name']);
        $users      = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'administrator');
        })->get(['id', 'name']);

        $today_leads_count  = Lead::where('assigned_to', Auth::user()->id)->whereDate('date_assigned', Carbon::today())->count();
        $user_leads_per_day = Auth::user()->leads_per_day;


        if (!Auth::user()->hasAnyRole('administrator|team lead|agent|fresher')) {
            if ($lead->assigned_to == '' || $lead->assigned_to == Auth::user()->id || $lead->assigned_to == 2) {
                if ($lead->assigned_to == 2 || $lead->assigned_to == '') {

                    if ($user_leads_per_day > 0) {
                        if ($today_leads_count >= $user_leads_per_day) {
                            return redirect()->back()->with(['success' => 'Your leads assign count is exceeded than per day leads count.']);
                        }
                    }
                    $lead->assigned_to      = Auth::user()->id;
                    $lead->date_assigned    = Carbon::today()->toDateString();
                    $lead->timestamps       = false;
                    $lead->save();
                }
            } else {
                abort(404);
            }
        }


        return view('leads.history', compact('leads', 'lead_crm'));
    }

    public function searchLead(Request $request)
    {

        if (!is_null($request->inp)) {

            $lead = Lead::where('name', 'LIKE', '%' . $request->inp . '%')->orWhere('mobile', 'LIKE', '%' . $request->inp . '%')->get()->toArray();


            if (!empty($lead)) {

                foreach ($lead as $k => $_lead) {

                    $_lead['lead_status'] == 0 ? $status = 'Generated' : $status = LeadStatus::find($_lead['lead_status'])->name;
                    $lead[$k]['leadstatus_name'] = $status;

                    $_lead['assigned_to'] == 2 ? $assign = 'N/A' : $assign = User::find($_lead['assigned_to'])->name;
                    $lead[$k]['assign_name'] = $assign;

                    $time = Carbon::parse($_lead['created_at'])->diffForHumans();
                    $lead[$k]['lead_time_now'] = $time;
                }

                return response([
                    'data'    => $lead
                ], 200);
            } else {

                return response([
                    'data'    => 404,
                ], 200);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users          = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'administrator');
        });
        $users          = $users->get(['id', 'name']);
        $statuses       = LeadStatus::get(['id', 'name']);
        return view('leads.create', compact('statuses', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'name'          => 'required|string|max:255',
            'mobile'        => 'required|min:10',
            'website'       => 'required',
            'assigned_to'   => 'required',
            'lead_status'   => 'required',
        ]);

        $lead_exists                = Lead::where('mobile', 'LIKE', '%' . $request->mobile . '%')->exists();

        if ($lead_exists) {
            return redirect()->back()->withInput()->with('error', 'Lead with this mobile number already exists! Duplicate lead.');
        }

        $input                      = $request->all();
        $input['name']              = $request->name;
        $input['email']             = $request->email;
        $input['mobile']            = str_replace(' ', '', $request->mobile);
        $input['website']           = $request->website;
        $input['meta']              = $request->meta;
        $input['assigned_to']       = isset($request->assigned_to) ? $request->assigned_to : null;
        $input['date_assigned']     = isset($request->assigned_to) ? Carbon::today()->toDateString() : null;
        $input['date']              = date('Y-m-d');
        $input['time']              = date("H:i:s");
        $input['source']            = 'crm';
        $input['dob']               = $request->dob;
        $input['anniversary']       = $request->anniversary;
        $input['more_details']      = $request->more_details;
        $input['address']           = $request->address;
        $input['meal_plan']         = $request->meal_plan;
        $input['total_traveller']   = $request->total_traveller;
        $input['travel_date']       = $request->travel_date;
        $input['destination']       = $request->destination ?? NULL;

        if (isset($request->payment_status) && !empty($request->payment_status)) {
            $input['payment_status'] = $request->payment_status;
        }
        if (isset($request->lead_status) && !empty($request->lead_status)) {
            $input['lead_status'] = $request->lead_status;
        }

        $user = Lead::create($input);

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'lead generated',
            'comment' => '<a href="'.route('leads.show', $user->id).'">Lead No. '.$user->id.'</a> generated successfully'
        ]);

        return redirect()->route('leads.index')->with('success', 'Lead added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $lead       = Lead::find($id)->load('user', 'comments', 'reminders');
        $statuses   = LeadStatus::get(['id', 'name']);
        $users      = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'administrator');
        })->get(['id', 'name']);

        $today_leads_count  = Lead::where('assigned_to', Auth::user()->id)->whereDate('date_assigned', Carbon::today())->count();
        $user_leads_per_day = Auth::user()->leads_per_day;

        if (!Auth::user()->hasAnyRole('administrator|team lead|agent|fresher')) {
            if ($lead->assigned_to == '' || $lead->assigned_to == Auth::user()->id || $lead->assigned_to == 2) {
                if ($lead->assigned_to == 2 || $lead->assigned_to == '') {

                    if ($user_leads_per_day > 0) {
                        if ($today_leads_count >= $user_leads_per_day) {
                            return redirect()->back()->with(['success' => 'Your leads assign count is exceeded than per day leads count.']);
                        }
                    }

                    if (!Auth::user()->assign_lead) {
                        $lead->assigned_by      = Auth::user()->id;
                        $lead->assigned_to      = Auth::user()->id;
                        $lead->view             = true;
                        $lead->date_assigned    = Carbon::today()->toDateString();
                        $lead->timestamps       = false;
                        $lead->save();

                        $comment                = new LeadComment();
                        $comment->lead_id       = $lead->id;
                        $comment->comment_by    = Auth::user()->id;
                        $comment->type          = "lead assigned";
                        $comment->comment       = "Lead  has been assigned by " . Auth::user()->name;
                        $comment->save();
                    }

                   
                }
                $lead->view             = true;                   
                $lead->timestamps       = false;
                $lead->save();
            } else {
                abort(404);
            }
        }

        LeadReminder::where('id', $request->reminder_id)->update(['seen' => 1]);

        return view('leads.show', compact('lead', 'statuses', 'users'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users              = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'administrator');
        });
        $users              = $users->get(['id', 'name']);
        $statuses           = LeadStatus::get(['id', 'name']);
        $lead               = Lead::find($id);
        return view('leads.edit', compact('lead', 'users', 'statuses'));
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
            'name'               => 'required|string|max:255',
            'mobile'             => 'required|min:10',
            'website'            => 'required',
            'assigned_to'        => 'required',
            'lead_status'        => 'required',
        ]);

        $lead                    = Lead::find($id);
        $lead->name              = $request->name;
        $lead->email             = $request->email;
        $lead->mobile            = str_replace(' ', '', $request->mobile);
        $lead->website           = $request->website;
        $lead->meta              = $request->meta;
        $lead->assigned_to       = isset($request->assigned_to) ? $request->assigned_to : null;
        $lead->date_assigned     = isset($request->assigned_to) ? Carbon::today()->toDateString() : null;
        $lead->dob               = $request->dob;
        $lead->anniversary       = $request->anniversary;
        $lead->more_details      = $request->more_details;
        $lead->address           = $request->address;
        $lead->meal_plan         = $request->meal_plan;
        $lead->total_traveller   = $request->total_traveller;
        $lead->travel_date       = $request->travel_date;
        $lead->destination       = $request->destination ?? NULL;
        $lead->timestamps        = false;


        if (isset($request->lead_status) && !empty($request->lead_status)) {
            $lead->lead_status   = $request->lead_status;
        }

        $lead->save();

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'lead updated',
            'comment' => '<a href="'.route('leads.show', $lead->id).'">Lead No. '.$lead->id.'</a> updated successfully'
        ]);


        return redirect()->route('leads.index')->with('success', 'Lead update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $lead = Lead::find($id);
        $lead->reason = $request->reason;
        $lead->deleted_by = Auth::user()->id;
        $lead->save();

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'lead updated',
            'comment' => 'Lead No. '.$lead->id.' deleted successfully'
        ]);

        $lead->delete();

        return redirect()->back()->with('success', 'Lead deleted successfully!');
    }

    public function massAssign(Request $request)
    {
        $lead_id                        = $request->arr;
        $userid                         = $request->user_id;

        $user                           = User::find($userid);

        foreach ($lead_id as $row) {
            if ($row != NULL) {
                $lead                   = Lead::find($row);
                $lead->assigned_by      = Auth::user()->id;
                $lead->assigned_to      = (int)$userid;
                $lead->date_assigned    = Carbon::today()->toDateString();
                $lead->timestamps       = false;
                $lead->save();

                if($request->assign_estimate == 'yes'){
                    Estimate::where('lead_id', $row)->update(['assigned_to' => (int)$userid]);
                }

                if($request->assign_booking == 'yes'){
                    Booking::where('lead_id', $row)->update(['assigned_to' => (int)$userid]);
                }

                if($request->assign_booking == true){
                    
                }

                $comment                = new LeadComment();
                $comment->lead_id       =  $lead->id;
                $comment->comment_by    = Auth::user()->id;
                $comment->type          = "lead assigned";
                $comment->comment       = "Lead has been assigned by " . Auth::user()->name;
                $comment->save();
            }
        }
        return Response()->json('Lead Assigned Successfully');
    }

    public function massDelete(Request $request)
    {
        $lead_ids = $request->arr;
        $reason = $request->reason;

        foreach ($lead_ids as $lead_id) {
            $lead = Lead::find($lead_id);
            $lead->reason =$reason;
            $lead->deleted_by = Auth::user()->id;
            $lead->save();
            UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'lead updated',
            'comment' => 'Lead No. '.$lead->id.' deleted successfully'
            ]);
            $lead->delete();
        }
        return Response()->json('Lead Deleted Successfully');
    }

    public function assignComment(Request $request, Lead $lead)
    {
        $this->validate($request, [
            'comment'       => 'required',
            'comment_type'  => 'required',
        ]);

        $input                      = $request->all();
        $input['lead_id']           = $lead->id;
        $input['comment_by']        = Auth::user()->id;
        $input['type']              = $request->comment_type;
        $input['comment']           = $request->comment;
        $comment                    = LeadComment::create($input);

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'comment added',
            'comment' => 'A Comment has been added for <a href="'.route('leads.show', $lead->id).'">Lead No. '.$lead->id.'</a>'
        ]);

        return redirect()->back()->with('success', 'Comment Added successfully!');
    }

    public function setFollowUp(Request $request, Lead $lead)
    {
       
        $this->validate($request, [
            'datetime' => 'required',
        ]);

        $reminder               = new LeadFollowUp();
        $reminder->lead_id      = $lead->id;
        $reminder->user_id       = Auth::user()->id;       
        $reminder->datetime     = Carbon::parse($request->datetime)->format('Y-m-d H:i:s');
        $reminder->comment      = $request->about;
        $reminder->save();

        $user_id = Auth::user()->id;

        $fields['include_external_user_ids'] = ['user_'.$user_id];
        $fields['send_after'] = Carbon::parse($request->datetime)->format('M d Y H:i:s')." GMT+0530";
        $notificationMsg = "You have a follow up at ".Carbon::parse($request->datetime)->format('d-m-Y h:i A');
        OneSignal::sendPush($fields, $notificationMsg);

        $comment                = new LeadComment();
        $comment->lead_id       = $lead->id;
        $comment->comment_by    = Auth::user()->id;
        $comment->type          = "reminder set";
        $comment->comment       = "A Follow up reminder has been set by ".User::where('id', Auth::user()->id)->first()->name;
       
        $comment->save();

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'follow up added',
            'comment' => 'A Follow up reminder has been set for <a href="'.route('leads.show', $lead->id).'">Lead No. '.$lead->id.'</a>'
        ]);

        return redirect()->back()->with('success', 'Follow Up added successfully!');
    }

    public function followUpHistory($id){
        $follow_ups = LeadFollowUp::where('lead_id', $id)->orderBy('id', 'desc')->paginate(20);
        $lead                       = Lead::find($id);
        return view('leads.follow-up', compact('follow_ups', 'lead'));
    }

    public function changeLeadStatus(Request $request)
    {
        $lead                       = Lead::find($request->lead_id);
        $lead->lead_status          = $request->status;
        if ($request->status == 4) {
            $lead->payment_status   = 'paid';
            $lead->updated_at       = now();
        }
        $lead->timestamps           = false;
        $lead->save();

        $comment                = new LeadComment();
        $comment->lead_id       = $request->lead_id;
        $comment->comment_by    = Auth::user()->id;
        $comment->type          = "lead status updated";
        $comment->comment       = "Lead status has been changed to " . LeadStatus::find($request->status)->name . " by ". Auth::user()->name;
        $comment->save();

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'lead status changed',
            'comment' => '<a href="'.route('leads.show', $lead->id).'">Lead No. '.$lead->id.'</a> status updated to '. LeadStatus::find($request->status)->name
        ]);

        return response()->json(['success' => 'Lead status changed successfully.']);
    }

    public function updateMoreDetails(Request $request, $id)
    {
        $lead                    = Lead::find($id);
        $lead->dob               = $request->dob;
        $lead->anniversary       = $request->anniversary;
        $lead->more_details      = $request->more_details;
        $lead->address           = $request->address;
        $lead->meal_plan         = $request->meal_plan;
        $lead->total_traveller   = $request->total_traveller;
        $lead->travel_date       = $request->travel_date;
        $lead->save();

        return redirect()->route('leads.index')->with('success', 'Lead update Successfully');
    }

    public function editMoreDetails($id)
    {
        $users      = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'administrator');
        });

        $users      = $users->get(['id', 'name']);
        $statuses   = LeadStatus::get(['id', 'name']);
        $lead       = Lead::find($id);

        return view('leads.more-details-edit', compact('lead', 'users', 'statuses'));
    }

    public function followUpSave(Request $request){
        $follow_up = LeadFollowUp::where('id', $request->follow_up_id)->first();
        LeadFollowUp::where('id', $request->follow_up_id)->update(['done' => true]);
        $input['lead_id']           = $follow_up->lead_id;
        $input['comment_by']        = Auth::user()->id;
        $input['type']              = $request->comment_type;
        $input['comment']           = $request->comment;
        $comment                    = LeadComment::create($input);

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'follow up done',
            'comment' => 'A Follow up has been done for <a href="'.route('leads.show', $follow_up->lead_id).'">Lead No. '.$follow_up->lead_id.'</a>'
        ]);

        return redirect()->route('home')->with('success', 'Follow up done successfully');
    }
    public function importLead(Request $request){
        if ($request->hasFile('fileToUpload')) {
            Excel::import(new LeadsImport, $request->fileToUpload);
        }
        // return redirect()->route('leads.index')->with('success', 'Lead Imported Successfully');
        return json_encode(['status'=>'success', 'message'=>'Lead Imported Successfully']);
    }
}
