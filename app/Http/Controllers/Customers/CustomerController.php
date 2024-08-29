<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\State;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function searchCustomer(Request $request)
    {
        $query = $request->get('query');
        $results = Customer::where('name', 'LIKE', '%' . $query . '%')->orWhere('mobile', 'LIKE', '%' . $query . '%')->get();
        foreach($results as $result){
            $result->name = $result->name.' ('.$result->mobile.')';
        }
        return response()->json($results);
    }
    public function index(Request $request)
    {
        $customers      = Customer::with('bookings', 'estimates');
        $states         = State::get(['id', 'state']);

        $filter_name    = $request->filter_name;
        $filter_phone   = $request->filter_phone;
        $filter_email   = $request->filter_email;
        $filter_state   = $request->filter_state;
        $filter_date    = $request->filter_date;

        if (isset($filter_name)) {
            $customers = $customers->where('name', 'LIKE', '%' . $filter_name . '%');
        }

        if (isset($filter_phone)) {
            $customers = $customers->where('mobile', 'LIKE', '%' . $filter_phone . '%');
        }

        if (isset($filter_email)) {
            $customers = $customers->where('email', $filter_email);
        }

        if (isset($filter_state)) {
            $customers = $customers->where('state', 'LIKE', '%' . $filter_state . '%');
        }
        if (isset($filter_date)) {
            $customers = $customers->whereDate('created_at', Carbon::parse($request->filter_date)->format('Y-m-d'));
        }

        $customers = $customers->latest()->paginate(20);

        return view('customers.list', compact('customers', 'states', 'filter_name', 'filter_email', 'filter_phone', 'filter_state', 'filter_date'));
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
        $this->validate($request, [
            'name'      =>  'required',
            'email'     =>  'required',
            'phone'     =>  'required|unique:customers,mobile',
            'state'     =>  'required',
            'country'   =>  'required',
            'address'   =>  'required',
        ]);

        $lead_exists       = Lead::where('mobile', $request->phone)->exists();
        $lead             = $lead_exists ? Lead::where('mobile', $request->phone)->first() : [];

        $customer                  = new Customer;
        $customer->name            = $request->name;
        $customer->email           = $request->email;
        $customer->mobile          = $request->phone;
        $customer->address         = $request->address;
        $customer->state           = $request->state;
        $customer->country         = $request->country;
        $customer->company         = $request->company;
        $customer->gstin           = $request->gstin;
        $customer->dob             = $lead_exists ? $lead->dob : Null;
        $customer->anniversary     = $lead_exists ? $lead->anniversary : Null;
        $customer->more_details    = $lead_exists ? $lead->more_details : Null;
        $customer->meal_plan       = $lead_exists ? $lead->meal_plan : Null;
        $customer->total_traveller = $lead_exists ? $lead->total_traveller : Null;
        $customer->travel_date     = $lead_exists ? $lead->travel_date : Null;
        $customer->save();

        if($lead_exists){
            $comment                = new LeadComment();
            $comment->lead_id       = $lead->id;
            $comment->comment_by    = Auth::user()->id;
            $comment->type          = "customer added";
            $comment->comment       = "Customer " .$customer->name." has been added by ". Auth::user()->name;
            $comment->save();
        }
       

        if ($request->type == 'custom') {
            session()->put('mobile', $customer->mobile);
        }

        UserActivity::create([
            'user_id' => Auth::user()->id,
            'type'    => 'customer added',
            'comment' => 'A Customer has been added'
        ]);

        return redirect()->back()->with('success', 'Customer Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        return $customer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        $states   = State::get('state');
        return view('customers.edit', compact('states', 'customer'));
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
            'name'      =>  'required',
            'email'     =>  'required',
            'mobile'     =>  ['required', Rule::unique('customers')->ignore($id),],
            'state'     =>  'required',
            'country'     =>  'required',
            'address'   =>  'required',
        ]);

        $customer                  = Customer::find($id);
        $customer->name            = $request->name;
        $customer->email           = $request->email;
        $customer->mobile          = $request->mobile;
        $customer->address         = $request->address;
        $customer->state           = $request->state;
        $customer->country         = $request->country;
        $customer->company         = $request->company;
        $customer->gstin           = $request->gstin;
        $customer->dob             = $request->dob;
        $customer->anniversary     = $request->anniversary;
        $customer->more_details    = $request->more_details;
        $customer->meal_plan       = $request->meal_plan;
        $customer->total_traveller = $request->total_traveller;
        $customer->travel_date     = $request->travel_date;
        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Customer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::find($id)->delete();
        return redirect()->back()->with('success', 'Customer Deleted Successfully');
    }
}
