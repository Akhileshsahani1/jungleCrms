<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingExclusion;
use App\Models\BookingInclusion;
use App\Models\BookingItem;
use App\Models\BookingSafari;
use App\Models\BookingSafariCustomer;
use App\Models\BookingTerm;
use App\Models\Company;
use App\Models\Customer;
use App\Models\EstimateTerm;
use App\Models\Exclusion;
use App\Models\Inclusion;
use App\Models\Lead;
use App\Models\LeadBooking;
use App\Models\LeadComment;
use App\Models\LeadStatus;
use App\Models\PermitRate;
use App\Models\Term;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $input                  = $request->all();
        $input['name']          = $request->name;
        $input['email']         = $request->email;
        $input['mobile']        = $request->mobile;
        $input['website']       = $request->website;
        $input['meta']          = $request->custom_data;
        $input['date']          = date("Y-m-d");
        $input['time']          = date("H:i:s");
        $input['source']        = "website";
        $input['assigned_to']   = 2;

        if (isset($request->payment_status) && !empty($request->payment_status)) {
            $input['payment_status'] = $request->payment_status;
        }

        if (isset($request->lead_status) && !empty($request->lead_status)) {
            $input['lead_status'] = $request->lead_status;
        }

        // $lead_exists = Lead::where('date', date('Y-m-d'))->where('mobile', $request->mobile)->exists();
        $lead_exists = Lead::where('mobile', $request->mobile)->exists();

        if ($lead_exists) {
                $id                = Lead::where('mobile', $request->mobile)->value('id');
                $lead              = Lead::find($id);
                $lead->time        = date("H:i:s");
                $lead->counter  = 1;
                $lead->save();
                return response([
                    'message' => 'Data updated successfully!',
                    'data'    => $lead
                ], 200);
        }

        $lead = Lead::create($input);
        
        $comment                = new LeadComment();
        $comment->lead_id       = $lead->id;
        $comment->comment_by    = 2;
        $comment->type          = "lead generated";
        $comment->comment       = "Lead has been generated from website: " . $request->website;
        $comment->save();
        

        return response([
            'message' => 'Data inserted successfully!',
            'data'    => $lead
        ], 200);
    }


    public function updateLeadStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $id                     = Lead::where('mobile', $request->mobile)->value('id');

        if(!$id){
            return response([
                'message' => 'Data not exists!',
                'data'    => ''
            ], 200);

        } else {

            $lead                   = Lead::find($id);
            $lead->payment_status   = $request->payment_status;
            $lead->lead_status      = $request->payment_status == 'paid' ? 4 : 0 ;
            $lead->save(); 

            if($request->payment_status == 'paid'){
                $comment                = new LeadComment();
                $comment->lead_id       = $id;
                $comment->comment_by    = 2;
                $comment->type          = "lead status updated";
                $comment->comment       = "Lead status has been changed to " . LeadStatus::find(4)->name . " through website ";
                $comment->save();
            }      

            return response([
                'message' => 'Data updated successfully!',
                'data'    => $lead
            ], 200);
        }
    }

    public function updateLeadData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $id = Lead::where('mobile', $request->mobile)->value('id');
        if(!$id){
            return response([
                'message' => 'Data not exists!',
                'data'    => ''
            ], 200);

        } else {
            $lead                   = Lead::find($id);
            $lead->email            = $request->email;
            if($request->has('name')){
                $lead->name             = $request->name;
            }
            if($request->has('custom_data')){
                $lead->meta             = $request->custom_data;
            }
            $lead->save();
    
            return response([
                'message' => 'Data updated successfully!',
                'data'    => $lead
            ], 200);
        }

       
    }

    public function saveAddress(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'mobile'  => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $id = Lead::where('mobile', $request->mobile)->value('id');

        $input                          = $request->all();
        $input['lead_id']               = $id;
        $input['address']               = $request->address;
        $input['state']                 = $request->state;
        $input['taxable_amount']        = $request->has('taxable_amount') ? $request->taxable_amount : 0;
        $input['non_taxable_amount']    = $request->has('non_taxable_amount') ? $request->non_taxable_amount : 0;
        $input['booking_type']          = $request->has('booking_type') ? $request->booking_type : null;

        $booking = LeadBooking::create($input);
        $lead    = Lead::find($id);

        $customer_exists = Customer::where('mobile', $request->mobile)->exists();
        if(!$customer_exists){
            $customer           = new Customer;
            $customer->name     = $lead->name;
            $customer->email    = $lead->email;
            $customer->mobile   = $lead->mobile;
            $customer->address  = $booking->address;
            $customer->state    = $booking->state;
            $customer->save();
        }else{
            $customer = Customer::where('mobile', $request->mobile)->first();
            $customer->email    = $lead->email;
            $customer->address  = $booking->address;
            $customer->state    = $booking->state;
            $customer->save();
           
        }

        $comment                = new LeadComment();
        $comment->lead_id       = $lead->id;
        $comment->comment_by    = 2;
        $comment->type          = "customer added";
        $comment->comment       = "Customer has been added from website: " . $lead->website;
        $comment->save();

        return response([
            'message' => 'Booking is done successfully!',
            'data'    => $booking
        ], 200);
    }


    public function directBooking(Request $request)
    {

        $booked_customers = json_decode($request->booked_customers);
        $lead_exists = Lead::where('mobile', $request->mobile)->exists();
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $customer = Customer::where('mobile', $request->mobile)->first();
        if(isset($request->due_amount) && $request->due_amount>0){
            $paid_amount = $request->amount-$request->due_amount;
            $payment_status = 'partially paid';
       }else{
           $paid_amount = $request->amount;
           $payment_status = 'paid';
       }
        $vendor   = Vendor::where('sanctuary', $request->sanctuary)->where('default', 'yes')->first();
        $booking = new Booking();
        $booking->lead_id = $lead_exists ? Lead::where('mobile', $request->mobile)->latest()->first()->id : null;
        $booking->customer_id     = $customer->id;
        $booking->type            = $request->has('type') ? $request->type : 'safari';
        $booking->source          = 'direct';
        $booking->payment_status  = $payment_status;
        $booking->website         = $request->website;
        $booking->date            = date('Y-m-d');
        $booking->time            = date("H:i:s");
        $booking->save();

        $safari_booking                 = new BookingSafari;
        $safari_booking->booking_id     = $booking->id;
        $safari_booking->date           = $request->date;
        $safari_booking->mode           = $request->has('mode') ? ucfirst($request->mode) : null;
        $safari_booking->time           = $request->time;
        $safari_booking->adult          = $request->adult;
        $safari_booking->child          = $request->child;
        $total_person                   = $request->adult + $request->child;
        $safari_booking->total_person   = $total_person;
        $safari_booking->sanctuary      = $request->sanctuary;
        $safari_booking->package_name   = $request->has('package_name') ? $request->package_name : null;
        $safari_booking->package_type   = $request->has('package_type') ? $request->package_type : null;
        $safari_booking->no_of_room   = $request->has('no_of_room') ? $request->no_of_room : null;
        $safari_booking->extra_beds   = $request->has('extra_beds') ? $request->extra_beds : null;
        $safari_booking->amount         = $request->amount;
        $safari_booking->safari_due_amount  = $request->has('due_amount') ? $request->due_amount : null;
        $safari_booking->nationality  = $request->has('nationality') ? $request->nationality : null;
        $safari_booking->vendor         = $vendor ? $vendor->id : null;
        $safari_booking->save();

        $company_state  = Company::whereIn('websites', [$booking->website])->where('default', 'yes')->value('state');

        $permit_rate    = PermitRate::where('sanctuary', $request->sanctuary)->where('type', 'normal')->where('nationality', 'indian')->value('price');

        $taxable_amount = $request->amount - $permit_rate;

        $taxable                = new BookingItem;
        $taxable->booking_id    = $booking->id;
        $taxable->particular    = 'Taxable amount';
        $taxable->amount        = $taxable_amount;
        $taxable->rate          = 5;

        if ($company_state == $customer->state) {

            $taxable->gst  = 'SGST@CGST';

        } else {

            $taxable->gst  = 'IGST';

        }

        $taxable->save();

        $non_taxable                = new BookingItem;
        $non_taxable->booking_id    = $booking->id;
        $non_taxable->particular    = 'Non Taxable amount';
        $non_taxable->amount        = $permit_rate;
        $non_taxable->rate          = 0;

        if ($company_state == $customer->state) {

            $non_taxable->gst  = 'SGST@CGST';

        } else {

            $non_taxable->gst  = 'IGST';

        }

        $non_taxable->save();
        
        $transaction                    = new Transaction;
        $transaction->booking_id        = $booking->id;
        $transaction->customer_id       = $customer->id;
        $transaction->date              = date('Y-m-d');
        $transaction->amount            = $paid_amount;
        $transaction->mode              = 'razorpay';
        $transaction->transaction_id    = $request->transaction_id;
        $transaction->save();

        foreach ($booked_customers as $value) {
            $safari_customer = new BookingSafariCustomer;
            $safari_customer->booking_id    = $booking->id;
            $safari_customer->name          = $value->name;
            $safari_customer->age           = $request->sanctuary == 'ranthambore' ? null : $value->age;
            $safari_customer->gender        = $value->gender;
            $safari_customer->nationality   = $value->nationality;
            $safari_customer->state         = $request->sanctuary == 'ranthambore' ? null : $value->state;
            $safari_customer->idproof       = $value->id_proof;
            $safari_customer->idproof_no    = $value->idnumber;
            $safari_customer->save();
        }

        

        if($lead_exists){
            $lead = Lead::where('mobile', $request->mobile)->latest()->first();
            $comment                = new LeadComment();
            $comment->lead_id       = $lead->id;
            $comment->comment_by    = 2;
            $comment->type          = "booking generated";
            $comment->comment       = "Safari Booking has been generated by website: " . $lead->website;
            $comment->save();
        }

        $inclusions = Inclusion::where('type', 'safari')->where('filter', $request->sanctuary)->get();

        if (!empty($inclusions)) {
            foreach ($inclusions as $inc) {
                $inclusion                  = new BookingInclusion();
                $inclusion->booking_id      = $booking->id;
                $inclusion->content         = $inc->content;
                $inclusion->filter          = $request->sanctuary;
                $inclusion->save();
            }
        }

        $exclusions = Exclusion::where('type', 'safari')->where('filter', $request->sanctuary)->get();

        if (!empty($exclusions)) {
            foreach ($exclusions as $exc) {
                $exclusion                  = new BookingExclusion();
                $exclusion->booking_id      = $booking->id;
                $exclusion->content         = $exc->content;
                $exclusion->filter          = $request->sanctuary;
                $exclusion->save();
            }
        }


        $terms = Term::where('mode', 'voucher')->where('type', 'safari')->where('filter', $request->sanctuary)->get();

        if (!empty($terms)) {
            foreach ($terms as $ter) {
                $term                  = new BookingTerm();
                $term->booking_id      = $booking->id;
                $term->content         = $ter->content;
                $term->filter          = $request->sanctuary;
                $term->save();
            }
        }
       


        return $response = ['message' => "Data inserted successfully!"];
    }

    public function ranthamboreBooking(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:10',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()->all()
            ], 422);
        }


            $lead_id                = Lead::where('mobile', $request->mobile)->latest()->first()->id;
            $lead                   = Lead::find($lead_id);
            $lead->payment_status   = $request->payment_status;
            $lead->lead_status      = $request->payment_status == 'paid' ? 4 : 0 ;
            $lead->website          = "ranthamboretigerreserve.in";
            $lead->email            = $request->email;
            $lead->save();

            if($request->payment_status == 'paid' && isset($lead_id)){
                $comment                = new LeadComment();
                $comment->lead_id       = $lead_id;
                $comment->comment_by    = 2;
                $comment->type          = "lead status updated";
                $comment->comment       = "Lead status has been changed to " . LeadStatus::find(4)->name . " through website ";
                $comment->save();
            }      

            $input                          = $request->all();
            $input['lead_id']               = $lead_id;
            $input['address']               = $request->address;
            $input['state']                 = $request->state;
            $input['taxable_amount']        = $request->has('taxable_amount') ? $request->taxable_amount : 0;
            $input['non_taxable_amount']    = $request->has('non_taxable_amount') ? $request->non_taxable_amount : 0;
            $input['booking_type']          = $request->has('booking_type') ? $request->booking_type : null;

            $booking = LeadBooking::create($input);

            $customer_not_exists = Customer::where('mobile', $request->mobile)->doesntExist();
            if($customer_not_exists){

                $customer           = new Customer;
                $customer->name     = $lead->name;
                $customer->email    = $lead->email;
                $customer->mobile   = $lead->mobile;
                $customer->address  = $booking->address;
                $customer->state    = $booking->state;
                $customer->save();

            } else {

                $customer = Customer::where('mobile', $request->mobile)->first();

            }

            $comment                = new LeadComment();
            $comment->lead_id       = $lead->id;
            $comment->comment_by    = 2;
            $comment->type          = "customer added";
            $comment->comment       = "Customer has been added from website: " . $lead->website;
            $comment->save();

                $vendor             = Vendor::where('sanctuary', $request->sanctuary)->where('default', 'yes')->first();

                $booking = new Booking();
                $booking->customer_id     = $customer->id;
                $booking->lead_id     =     isset($lead_id) ? $lead_id : null;
                $booking->type            = $request->has('type') ? $request->type : 'safari';
                $booking->source          = 'direct';
                $booking->payment_status  = 'paid';
                $booking->website         = 'ranthamboretigerreserve.in';
                $booking->date            = date('Y-m-d');
                $booking->time            = date("H:i:s");
                $booking->save();

                $safari_booking                 = new BookingSafari;
                $safari_booking->booking_id     = $booking->id;
                $safari_booking->date           = $request->date;
                $safari_booking->mode           = $request->has('mode') ? $request->mode : null;
                $safari_booking->time           = $request->time;
                $safari_booking->adult          = $request->adult;
                $safari_booking->child          = $request->child;
                $total_person                   = $request->adult + $request->child;
                $safari_booking->total_person   = $total_person;
                $safari_booking->sanctuary      = $request->sanctuary;
                $safari_booking->mode           = $request->mode;
                $safari_booking->zone           = $request->zone;
                $safari_booking->amount         = $request->amount;
                $safari_booking->vendor         = $vendor->id;
                $safari_booking->save();

                $company_state  = Company::whereIn('websites', [$booking->website])->where('default', 'yes')->value('state');

                $permit_rate    = PermitRate::where('sanctuary', $request->sanctuary)->where('type', 'normal')->where('nationality', 'indian')->value('price');

                $taxable_amount = $request->amount - $permit_rate;

                $taxable                = new BookingItem;
                $taxable->booking_id    = $booking->id;
                $taxable->particular    = 'Taxable amount';
                $taxable->amount        = $taxable_amount;
                $taxable->rate          = 5;

                if ($company_state == $customer->state) {

                    $taxable->gst  = 'SGST@CGST';

                } else {

                    $taxable->gst  = 'IGST';

                }

                $taxable->save();

                $non_taxable                = new BookingItem;
                $non_taxable->booking_id    = $booking->id;
                $non_taxable->particular    = 'Non Taxable amount';
                $non_taxable->amount        = $permit_rate;
                $non_taxable->rate          = 0;

                if ($company_state == $customer->state) {

                    $non_taxable->gst  = 'SGST@CGST';

                } else {

                    $non_taxable->gst  = 'IGST';

                }

                $non_taxable->save();

                $transaction                    = new Transaction;
                $transaction->booking_id        = $booking->id;
                $transaction->customer_id       = $customer->id;
                $transaction->date              = date('Y-m-d');
                $transaction->amount            = $request->amount;
                $transaction->mode              = 'razorpay';
                $transaction->transaction_id    = $request->transaction_id;
                $transaction->save();

                $booked_customers               = json_decode($request->booked_customers);

                foreach ($booked_customers as $value) {
                    $safari_customer                = new BookingSafariCustomer;
                    $safari_customer->booking_id    = $booking->id;
                    $safari_customer->name          = $value->name;
                    $safari_customer->age           = $request->sanctuary == 'ranthambore' ? null : $value->age;
                    $safari_customer->gender        = $value->gender;
                    $safari_customer->nationality   = $value->nationality;
                    $safari_customer->state         = $request->sanctuary == 'ranthambore' ? null : $value->state;
                    $safari_customer->idproof       = $value->id_proof;
                    $safari_customer->idproof_no    = $value->idnumber;
                    $safari_customer->save();
                }

               
                    $comment                = new LeadComment();
                    $comment->lead_id       = $lead->id;
                    $comment->comment_by    = 2;
                    $comment->type          = "booking generated";
                    $comment->comment       = "Safari Booking has been generated by website: " . $lead->website;
                    $comment->save();

                    $inclusions = Inclusion::where('type', 'safari')->where('filter', $request->sanctuary)->get();

        if (!empty($inclusions)) {
            foreach ($inclusions as $inc) {
                $inclusion                  = new BookingInclusion();
                $inclusion->booking_id      = $booking->id;
                $inclusion->content         = $inc->content;
                $inclusion->filter          = $request->sanctuary;
                $inclusion->save();
            }
        }

        $exclusions = Exclusion::where('type', 'safari')->where('filter', $request->sanctuary)->get();

        if (!empty($exclusions)) {
            foreach ($exclusions as $exc) {
                $exclusion                  = new BookingExclusion();
                $exclusion->booking_id      = $booking->id;
                $exclusion->content         = $exc->content;
                $exclusion->filter          = $request->sanctuary;
                $exclusion->save();
            }
        }


        $terms = Term::where('mode', 'voucher')->where('type', 'safari')->where('filter', $request->sanctuary)->get();

        if (!empty($terms)) {
            foreach ($terms as $ter) {
                $term                  = new BookingTerm();
                $term->booking_id      = $booking->id;
                $term->content         = $ter->content;
                $term->filter          = $request->sanctuary;
                $term->save();
            }
        }


        return $response = ['message' => "Data inserted successfully!"];

    }

}
