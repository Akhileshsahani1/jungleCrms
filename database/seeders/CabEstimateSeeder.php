<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Destination;
use App\Models\DestinationIternary;
use App\Models\Estimate;
use App\Models\EstimateCab;
use App\Models\EstimateCabOption;
use App\Models\EstimateExclusion;
use App\Models\EstimateInclusion;
use App\Models\EstimateIternary;
use App\Models\EstimateTerm;
use App\Models\Exclusion;
use App\Models\Inclusion;
use App\Models\Iternary;
use App\Models\Lead;
use App\Models\Term;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator;

class CabEstimateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);
        $cab_customers = Customer::get(['id', 'mobile']);


        foreach ($cab_customers as $customer) {

            $iternary_state                     = Destination::inRandomOrder()->first();
            $destination_iternary               = DestinationIternary::where('destination_id', $iternary_state->id)->inRandomOrder()->first();
            $iternaries                         = Iternary::where('destination_iternarie_id', $destination_iternary->id)->get();

            //Cab Estimate 
            $cab_estimate                       = new Estimate();
            $cab_estimate->type                 = 'cab';
            $cab_estimate->customer_id          = $customer->id;
            $cab_estimate->lead_id              = Lead::where('mobile', $customer->mobile)->first()->id;
            $cab_estimate->assigned_to          = null;
            $cab_estimate->source               = 'custom';
            $cab_estimate->date                 = date("Y-m-d");
            $cab_estimate->time                 = date("H:i:s");
            $cab_estimate->gst_filed            = $faker->randomElement([5, 18, 0, 00]);
            $cab_estimate->pg_charges_filed     = $faker->randomElement([5, 6, 3, 4, 7, 8, 0, 00]);
            $cab_estimate->payment_modes        = ["1", "2", "3"];
            $cab_estimate->iternary_state       = $iternary_state->id;
            $cab_estimate->iternary             = $destination_iternary->id;
            $cab_estimate->duration             = $destination_iternary->duration;
            $cab_estimate->estimate_status      = 'accepted';
            $cab_estimate->website              = $faker->randomElement(['ranthamboretigerreserve.in', 'jimcorbettnationalparkonline.in', 'girsafaribooking.com', 'jimcorbett.in', 'girlionsafari.com', 'girlion.in', 'bandhavgarh.com', 'travelwalacab.com', 'dailytourandtravel.com']);
            $cab_estimate->save();

            $vehicle_type                       = $faker->randomElement(["Innova", 'Jeep', 'Swift Dezire', 'Toyota Etios', 'Mini Bus']);

            $cab                                = new EstimateCab();
            $cab->estimate_id                   = $cab_estimate->id;
            $cab->trip_type                     = $faker->randomElement(["Round Trip", 'One Side']);
            $cab->pickup_medium                 = 'any';
            $cab->vehicle_type                  = $vehicle_type;
            $cab->start_date                    = Carbon::now()->addMonth()->format('Y-m-d');
            $cab->end_date                      = Carbon::now()->addMonth()->addDays(2)->format('Y-m-d');
            $cab->days                          = $faker->randomElement([1,  2, 3, 4, 5, 6, 7]);
            $cab->pick_up                       = "Noida";
            $cab->drop                          = "Kalagarh";
            $cab->pickup_time                   = $faker->randomElement(['10:44', '05:00', '06:00']);
            $cab->total_riders                  = 4;
            $cab->no_of_cab                     = 1;
            $cab->note                          = $faker->realText($maxNbChars = 200, $indexSize = 2);
            $cab->save();

            $cab_amount                         = $faker->randomElement([10000,  20000, 30000, 4000, 5000, 6000, 7000]);
            $cab_discount                       = $faker->randomElement([1000,  2000, 3000, 400, 500, 600, 700]);
            $total_without_gst                  = $cab_amount - $cab_discount;
            $gst                                = round(($cab_estimate->gst_filed / 100) * $total_without_gst);
            $total_with_gst                     = $total_without_gst + $gst;
            $pg_charges                         = round(($cab_estimate->pg_charges_filed / 100) * $total_with_gst);
            $cab_total                          = $total_with_gst + $pg_charges;

            $cab_option                         = new EstimateCabOption();
            $cab_option->estimate_id            = $cab_estimate->id;
            $cab_option->estimate_cab_id        = $cab->id;
            $cab_option->content                = $vehicle_type . 'Booking';
            $cab_option->amount                 = $cab_amount;
            $cab_option->discount               = $cab_discount;
            $cab_option->total                  = $cab_total;
            $cab_option->accepted               = 'yes';
            $cab_option->save();

            $inclusions                         = Inclusion::where('type', 'cab')->get();
            $exclusions                         = Exclusion::where('type', 'cab')->get();
            $terms                              = Term::where('mode', 'estimate')->where('type', 'cab')->get();

            if (!empty($inclusions)) {
                foreach ($inclusions as $inclu) {
                    $inclusion                  = new EstimateInclusion();
                    $inclusion->estimate_id     = $cab_estimate->id;
                    $inclusion->content         = $inclu->content;
                    $inclusion->save();
                }
            }

            if (!empty($terms)) {
                foreach ($terms as $ter) {
                    $term                  = new EstimateTerm();
                    $term->estimate_id     = $cab_estimate->id;
                    $term->content         = $ter->content;
                    $term->save();
                }
            }

            if (!empty($exclusions)) {
                foreach ($exclusions as $exclu) {
                    $exclusion                  = new EstimateExclusion();
                    $exclusion->estimate_id     = $cab_estimate->id;
                    $exclusion->content         = $exclu->content;
                    $exclusion->save();
                }
            }
            if (!empty($iternaries)) {
                foreach ($iternaries as $iter) {
                    $iternary               = new EstimateIternary();
                    $iternary->estimate_id  = $cab_estimate->id;
                    $iternary->title        = $iter->title;
                    $iternary->text         = $iter->text;
                    $iternary->save();
                }
            }
        }
    }
}
