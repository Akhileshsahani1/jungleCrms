<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Destination;
use App\Models\DestinationIternary;
use App\Models\Estimate;
use App\Models\EstimateExclusion;
use App\Models\EstimateInclusion;
use App\Models\EstimateSafari;
use App\Models\EstimateSafariOption;
use App\Models\EstimateTerm;
use App\Models\Exclusion;
use App\Models\Inclusion;
use App\Models\Iternary;
use App\Models\Lead;
use App\Models\Term;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Seeder;

class SafariEstimateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);

        $safari_customers = Customer::get(['id', 'mobile']);

        foreach ($safari_customers as $customer) {
            $iternary_state                     = Destination::inRandomOrder()->first();
            $destination_iternary               = DestinationIternary::where('destination_id', $iternary_state->id)->inRandomOrder()->first();
            $iternaries                         = Iternary::where('destination_iternarie_id', $destination_iternary->id)->get();

            $estimate                       = new Estimate();
            $estimate->type                 = 'safari';
            $estimate->customer_id          = $customer->id;
            $estimate->lead_id              = Lead::where('mobile', $customer->mobile)->first()->id;;
            $estimate->assigned_to          = null;
            $estimate->source               = 'custom';
            $estimate->estimate_status      = 'accepted';
            $estimate->date                 = date("Y-m-d");
            $estimate->gst_filed            = $faker->randomElement([5, 18, 0]);
            $estimate->pg_charges_filed     = $faker->randomElement([5, 6, 3, 4, 7, 8]);
            $estimate->time                 = date("H:i:s");
            $estimate->payment_modes        = ["1", "2", "3"];
            $estimate->iternary_state       = $iternary_state->id;
            $estimate->iternary             = $destination_iternary->id;
            $estimate->website              = $faker->randomElement(['ranthamboretigerreserve.in', 'jimcorbettnationalparkonline.in', 'girsafaribooking.com', 'jimcorbett.in', 'girlionsafari.com', 'girlion.in', 'bandhavgarh.com', 'travelwalacab.com', 'dailytourandtravel.com']);
            $estimate->save();

            $sanctuary = $faker->randomElement(["gir", "jim", "ranthambore"]);

            if ($sanctuary == "gir") {
                $safari                            = new EstimateSafari();
                $safari->estimate_id               = $estimate->id;
                $safari->sanctuary                 = $sanctuary;
                $safari->mode                      = "Jeep";
                $safari->zone                      = "Gir Jungle Trail";
                $safari->adult                     = 6;
                $safari->child                     = 2;
                $safari->total_person              = 8;
                $safari->vehicle_type              = null;
                $safari->date                      = Carbon::now()->addMonth()->addDays(2)->format('Y-m-d');
                $safari->time                      = $faker->randomElement(['6:45 AM - 9:45 AM', '6:00 AM - 9:00 AM']);
                $safari->nationality               = "Indian";
                $safari->note                      = $faker->realText($maxNbChars = 200, $indexSize = 2);
                $safari->jeeps                     = $faker->randomElement([1, 2]);
                $safari->type                      = null;
                $safari->save();

                $inclusions = Inclusion::where('type', 'safari')->where('filter', 'gir')->get();

                if (!empty($inclusions)) {
                    foreach ($inclusions as $inc) {
                        $inclusion                  = new EstimateInclusion();
                        $inclusion->estimate_id     = $estimate->id;
                        $inclusion->content         = $inc->content;
                        $inclusion->filter          = "gir";
                        $inclusion->save();
                    }
                }

                $exclusions = Exclusion::where('type', 'safari')->where('filter', 'gir')->get();

                if (!empty($exclusions)) {
                    foreach ($exclusions as $exc) {
                        $exclusion                  = new EstimateExclusion();
                        $exclusion->estimate_id     = $estimate->id;
                        $exclusion->content         = $exc->content;
                        $exclusion->filter          = 'gir';
                        $exclusion->save();
                    }
                }


                $terms = Term::where('mode', 'estimate')->where('type', 'safari')->where('filter', 'gir')->get();

                if (!empty($terms)) {
                    foreach ($terms as $ter) {
                        $term                  = new EstimateTerm();
                        $term->estimate_id     = $estimate->id;
                        $term->content         = $ter->content;
                        $term->filter          = 'gir';
                        $term->save();
                    }
                }
            }

            if ($sanctuary == "jim") {
                $safari                            = new EstimateSafari();
                $safari->estimate_id               = $estimate->id;
                $safari->sanctuary                 = $sanctuary;
                $safari->mode                      = "Jeep";
                $safari->area                      = "Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato";
                $safari->adult                     = 6;
                $safari->child                     = 2;
                $safari->total_person              = 8;
                $safari->vehicle_type              = null;
                $safari->date                      = Carbon::now()->addMonth()->addDays(2)->format('Y-m-d');
                $safari->time                      = $faker->randomElement(['Morning', 'Evening']);
                $safari->nationality               = "Indian";
                $safari->note                      = $faker->realText($maxNbChars = 200, $indexSize = 2);
                $safari->jeeps                     = $faker->randomElement([1, 2]);
                $safari->type                      = null;
                $safari->save();

                $inclusions = Inclusion::where('type', 'safari')->where('filter', 'jim')->get();

                if (!empty($inclusions)) {
                    foreach ($inclusions as $inc) {
                        $inclusion                  = new EstimateInclusion();
                        $inclusion->estimate_id     = $estimate->id;
                        $inclusion->content         = $inc->content;
                        $inclusion->filter          = "jim";
                        $inclusion->save();
                    }
                }

                $exclusions = Exclusion::where('type', 'safari')->where('filter', 'jim')->get();

                if (!empty($exclusions)) {
                    foreach ($exclusions as $exc) {
                        $exclusion                  = new EstimateExclusion();
                        $exclusion->estimate_id     = $estimate->id;
                        $exclusion->content         = $exc->content;
                        $exclusion->filter          = 'jim';
                        $exclusion->save();
                    }
                }


                $terms = Term::where('type', 'safari')->where('filter', 'jim')->get();

                if (!empty($terms)) {
                    foreach ($terms as $ter) {
                        $term                  = new EstimateTerm();
                        $term->estimate_id     = $estimate->id;
                        $term->content         = $ter->content;
                        $term->filter          = 'jim';
                        $term->save();
                    }
                }
            }

            if ($sanctuary == "ranthambore") {
                $safari                            = new EstimateSafari();
                $safari->estimate_id               = $estimate->id;
                $safari->sanctuary                 = $sanctuary;
                $safari->mode                      = "Canter";
                $safari->zone                      =  $faker->randomElement(['1/2/3/4/5/6/7', 'All Zone', '1/2/3/4/5/6/7/8/9/10']);
                $safari->area                      = "Ranthambore National Park";
                $safari->adult                     = 6;
                $safari->child                     = 2;
                $safari->total_person              = 8;
                $safari->vehicle_type              = $faker->randomElement(['Private', 'Sharing']);
                $safari->date                      = Carbon::now()->addMonth()->addDays(2)->format('Y-m-d');
                $safari->time                      = $faker->randomElement(['Morning', 'Evening']);
                $safari->nationality               = "Indian";
                $safari->note                      = $faker->realText($maxNbChars = 200, $indexSize = 2);
                $safari->jeeps                     = $faker->randomElement([1, 2]);
                $safari->type                      = $faker->randomElement(['Advance Booking', 'Current Booking']);
                $safari->save();

                $inclusions = Inclusion::where('type', 'safari')->where('filter', 'ranthambore')->get();

                if (!empty($inclusions)) {
                    foreach ($inclusions as $inc) {
                        $inclusion                  = new EstimateInclusion();
                        $inclusion->estimate_id     = $estimate->id;
                        $inclusion->content         = $inc->content;
                        $inclusion->filter          = "ranthambore";
                        $inclusion->save();
                    }
                }

                $exclusions = Exclusion::where('type', 'safari')->where('filter', 'ranthambore')->get();

                if (!empty($exclusions)) {
                    foreach ($exclusions as $exc) {
                        $exclusion                  = new EstimateExclusion();
                        $exclusion->estimate_id     = $estimate->id;
                        $exclusion->content         = $exc->content;
                        $exclusion->filter          = 'ranthambore';
                        $exclusion->save();
                    }
                }


                $terms = Term::where('type', 'safari')->where('filter', 'ranthambore')->get();

                if (!empty($terms)) {
                    foreach ($terms as $ter) {
                        $term                  = new EstimateTerm();
                        $term->estimate_id     = $estimate->id;
                        $term->content         = $ter->content;
                        $term->filter          = 'ranthambore';
                        $term->save();
                    }
                }
            }

            $safari_amount                          = $faker->randomElement([10000,  20000, 30000, 4000, 5000, 6000, 7000]);
            $safari_discount                        = $faker->randomElement([1000,  2000, 3000, 400, 500, 600, 700]);
            $total_without_gst                      = $safari_amount - $safari_discount;
            $gst                                    = round(($estimate->gst_filed / 100) * $total_without_gst);
            $total_with_gst                         = $total_without_gst + $gst;
            $pg_charges                             = round(($estimate->pg_charges_filed / 100) * $total_with_gst);
            $safari_total                           = $total_with_gst + $pg_charges;

            $option                         = new EstimateSafariOption();
            $option->estimate_id            = $estimate->id;
            $option->estimate_safari_id     = $safari->id;
            $option->content                = ucfirst($sanctuary) . 'Booking';
            $option->amount                 = $safari_amount;
            $option->discount               = $safari_discount;
            $option->accepted               = 'yes';
            $option->total                  = $safari_total;
            $option->save();
        }
    }
}
