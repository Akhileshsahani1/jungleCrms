<?php

namespace App\Queue\Jobs;

use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\BookingSafari;
use App\Models\BookingSafariCustomer;
use App\Models\Company;
use App\Models\Customer;
use App\Models\LeadBooking;
use App\Models\PermitRate;
use App\Models\Transaction;
use App\Models\Vendor;

use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob as BaseJob;

class RabbitMQJob extends BaseJob
{
   /**
     * Get the decoded body of the job.
     *
     * @return array
     */
    public function payload()
    {
        $data = json_decode($this->getRawBody(), true);        

        if (isset($data['method']) && !empty($data['method'])) {
            $data = $data;
        }else{
            $dataUn = (array)(unserialize($data['data']['command']));
            $daraa = array_values($dataUn);
            $data = $daraa[0];
        }

        if ($data['method'] == 'save-lead') 
        {
            $lead_exists = Lead::where('date', date('Y-m-d'))->where('mobile', $data['mobile'])->exists();

            if(!$lead_exists){

                $input                  = [];
                $input['name']          = $data['name'];
                $input['email']         = @$data['email'];
                $input['mobile']        = str_replace(' ', '', $data['mobile']);
                $input['website']       = $data['website'];
                $input['meta']          = @$data['meta'];
                $input['date']          = date('Y-m-d');
                $input['time']          = date("H:i:s");
                $input['source']        = 'website';

                if (isset($data['payment_status']) && !empty($data['payment_status'])) {
                    $input['payment_status'] = $data['payment_status'];
                }
                if (isset($data['lead_status']) && !empty($data['lead_status'])) {
                    $input['lead_status'] = $data->lead_status;
                }

                $user = Lead::create($input);
            }

        }else if ($data['method'] == 'save-address') {

            $id = Lead::where('date', date('Y-m-d'))->where('mobile', $data['mobile'])->value('id');

            $input                          = [];
            $input['lead_id']               = $id;
            $input['address']               = $data['address'];
            $input['state']                 = $data['state'];
            $input['taxable_amount']        = isset($data['taxable_amount']) ? $data['taxable_amount'] : 0;
            $input['non_taxable_amount']    = isset($data['non_taxable_amount']) ? $data['non_taxable_amount'] : 0;
            $input['booking_type']          = isset($data['booking_type']) ? $data['booking_type'] : null;

            $booking = LeadBooking::create($input);
            $lead    = Lead::find($id);

            $customer_exists = Customer::where('mobile', $data['mobile'])->doesntExist();

            if($customer_exists){
                $customer           = new Customer;
                $customer->name     = $lead->name;
                $customer->email    = $lead->email;
                $customer->mobile   = $lead->mobile;
                $customer->address  = $booking->address;
                $customer->state    = $booking->state;
                $customer->save();
            }

        }else if ($data['method'] == 'update-lead-status') {

            $id = Lead::where('date', date('Y-m-d'))->where('mobile', $data['mobile'])->value('id');

            $lead = Lead::find($id);
            $lead->payment_status   = $data['payment_status'];
            $lead->lead_status      = ($data['payment_status'] == 'paid') ? 4 : 0 ;
            $lead->save();

        }else if ($data['method'] == 'direct-booking') {

            $booked_customers = json_decode($data['booked_customers']);

            $customer = Customer::where('mobile', $data['mobile'])->first();
            $vendor = Vendor::where('sanctuary', $data['sanctuary'])->where('default', 'yes')->first();

            $bookings_count = Booking::where(['customer_id' => $customer->id, 'type' => 'safari', 'source' => 'direct', 'payment_status' => 'paid', 'website' => $data['website']])->count();

            if ($bookings_count === 0) {
                $booking = new Booking();
                $booking->customer_id     = $customer->id;
                $booking->type            = 'safari';
                $booking->source          = 'direct';
                $booking->payment_status  = 'paid';
                $booking->website         = $data['website'];
                $booking->date            = date('Y-m-d');
                $booking->time            = date("H:i:s");
                $booking->save();

                $safari_booking                 = new BookingSafari;
                $safari_booking->booking_id     = $booking->id;
                $safari_booking->date           = $data['date'];
                $safari_booking->mode           = (isset($data['mode']) && !empty($data['mode'])) ? $data['mode'] : null;
                $safari_booking->zone           = (isset($data['zone']) && !empty($data['zone'])) ? $data['zone'] : null;
                $safari_booking->time           = (isset($data['time']) && !empty($data['time'])) ? $data['time'] : '' ;
                $safari_booking->adult          = $data['adult'];
                $safari_booking->child          = $data['child'];
                $total_person                   = $data['adult'] + $data['child'];
                $safari_booking->total_person   = $total_person;
                $safari_booking->sanctuary      = $data['sanctuary'];
                $safari_booking->amount         = $data['amount'];
                $safari_booking->vendor         = $vendor->id;
                $safari_booking->save();

                $company_state  = Company::whereIn('websites', [$booking->website])->where('default', 'yes')->value('state');

                $permit_rate = PermitRate::where('sanctuary', $data['sanctuary'])->where('type', 'normal')->where('nationality', 'indian')->value('price');

                $taxable_amount = $data['amount'] - $permit_rate;

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
                $transaction->amount            = $data['amount'];
                $transaction->mode              = 'razorpay';
                $transaction->transaction_id    = $data['transaction_id'];
                $transaction->save();            

                foreach ($booked_customers as $value) {

                    if (isset($value->id_number) && !empty($value->id_number)) {
                        $idproof_no = $value->id_number;
                    }else{
                        $idproof_no = $value->idnumber;
                    }

                    $safari_customer = new BookingSafariCustomer;
                    $safari_customer->booking_id    = $booking->id;
                    $safari_customer->name          = $value->name;
                    $safari_customer->age           = ($data['sanctuary'] == 'ranthambore') ? null : $value->age;
                    $safari_customer->gender        = $value->gender;
                    $safari_customer->nationality   = $value->nationality;
                    $safari_customer->state         = ($data['sanctuary'] == 'ranthambore') ? null : @$value->state;
                    $safari_customer->idproof       = $value->id_proof;
                    $safari_customer->idproof_no    = $idproof_no;
                    $safari_customer->save();
                }
            }

        }else if ($data['method'] == 'update-lead-data') {

            $id = Lead::where('date', date('Y-m-d'))->where('mobile', $data['mobile'])->value('id');
            $lead = Lead::find($id);
            if(isset($data['email']) && !empty($data['email'])){
                $lead->email = $data['email'];
            }
            if(isset($data['name']) && !empty($data['name'])){
                $lead->name = $data['name'];
            }
            $lead->save();
        }
        return true;
    }
}