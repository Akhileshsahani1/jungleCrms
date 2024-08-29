<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingCab;
use App\Models\BookingExclusion;
use App\Models\BookingHotel;
use App\Models\BookingInclusion;
use App\Models\BookingItem;
use App\Models\BookingTerm;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\EstimateCabOption;
use App\Models\EstimateExclusion;
use App\Models\EstimateInclusion;
use App\Models\EstimateTerm;
use App\Models\Lead;
use App\Models\LeadComment;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);
        $estimates = Estimate::all();
        foreach ($estimates as $estimate) {
            switch ($estimate->type) {
                case 'cab':
                    $booking                       = new Booking();
                    $booking->type                 = 'cab';
                    $booking->customer_id          = $estimate->customer_id;
                    $booking->lead_id              = isset($estimate->lead_id) ?  $estimate->lead_id : null;
                    $booking->estimate_id          = isset($estimate->id) ?  $estimate->id : null;
                    $booking->assigned_to          = null;
                    $booking->source               = 'custom';
                    $booking->website              = $faker->randomElement(['ranthamboretigerreserve.in', 'jimcorbettnationalparkonline.in', 'girsafaribooking.com', 'jimcorbett.in', 'girlionsafari.com', 'girlion.in', 'bandhavgarh.com', 'travelwalacab.com', 'dailytourandtravel.com']);
                    $booking->date                 = date("Y-m-d");
                    $booking->time                 = date("H:i:s");
                    $booking->save();

                    $cab                            = new BookingCab();
                    $cab->booking_id                = $booking->id;
                    $cab->trip_type                 = $estimate->cab->trip_type;
                    $cab->pickup_medium             = 'any';
                    $cab->vehicle_type              = $estimate->cab->vehicle_type;
                    $cab->start_date                = Carbon::parse($estimate->cab->start_date)->format('Y-m-d');
                    $cab->end_date                  = Carbon::parse($estimate->cab->end_date)->format('Y-m-d');
                    $cab->days                      = $estimate->cab->days;
                    $cab->pick_up                   = $estimate->cab->pick_up;
                    $cab->drop                      = $estimate->cab->drop;
                    $cab->pickup_time               = $estimate->cab->pickup_time;
                    $cab->total_riders              = $estimate->cab->total_riders;
                    $cab->amount                    = EstimateCabOption::where('estimate_id', $estimate->id)->where('accepted', 'yes')->first()->total;
                    $cab->no_of_cab                 = $estimate->cab->no_of_cab;
                    $cab->cab_due_amount            = 0;
                    $cab->vendor_name               = 'Shankar';
                    $cab->vendor_mobile             = '+919910943632';
                    $cab->note                      = $estimate->cab->note;
                    $cab->save();

                    $company_state                  = Company::where('default', 'yes')->value('state');
                    $customr_state                  = Customer::find($estimate->customer_id)->state;



                    $item                  = new BookingItem();
                    $item->booking_id      = $booking->id;
                    $item->particular      = 'Cab booking';
                    $item->amount          =  $cab->amount;
                    $item->rate            = 5;
                    $item->gst             = $company_state == $customr_state ? 'SGST@CGST' : 'IGST';
                    $item->save();

                    $inclusions                         = EstimateInclusion::where('estimate_id', $estimate->id)->get();
                    $exclusions                         = EstimateExclusion::where('estimate_id', $estimate->id)->get();
                    $terms                              = EstimateTerm::where('estimate_id', $estimate->id)->get();

                    foreach ($inclusions as $key => $inclusion_row) {
                        $inclusion                  = new BookingInclusion();
                        $inclusion->booking_id      = $booking->id;
                        $inclusion->content         = $inclusion_row->content;
                        $inclusion->save();
                    }

                    foreach ($exclusions as $key => $exclusion_row) {
                        $exclusion                  = new BookingExclusion();
                        $exclusion->booking_id      = $booking->id;
                        $exclusion->content         = $exclusion_row->content;
                        $exclusion->save();
                    }

                    foreach ($terms as $key => $term_row) {
                        $term                  = new BookingTerm();
                        $term->booking_id      = $booking->id;
                        $term->content         = $term_row->content;
                        $term->save();
                    }


                    if (isset($estimate->lead_id)) {
                        $lead                       = Lead::find($estimate->lead_id);
                        $lead->payment_status       = 'paid';
                        $lead->lead_status          = 4;
                        $lead->timestamps           = false;
                        $lead->save();

                        $comment                = new LeadComment();
                        $comment->lead_id       = $estimate->lead_id;
                        $comment->comment_by    = 2;
                        $comment->type          = "booking generated";
                        $comment->comment       = "Cab Booking has been generated";
                        $comment->save();
                    }

                    $payment_status = Estimate::find($estimate->id)->payment_status;
                    Booking::where('id', $booking->id)->update(['payment_status' => $payment_status]);
                    break;
                    
                case 'hotel':                  
                    # code...
                    break;

                case 'safari':
                    # code...
                    break;

                case 'tour':
                    # code...
                    break;

                case 'package':
                    # code...
                    break;

                default:
                    # code...
                    break;
            }
        }
    }
}
