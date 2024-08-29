<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Destination;
use App\Models\DestinationIternary;
use App\Models\Estimate;
use Illuminate\Database\Seeder;
use App\Models\EstimateExclusion;
use App\Models\EstimateHotel;
use App\Models\EstimateHotelOption;
use App\Models\EstimateInclusion;
use App\Models\EstimateIternary;
use App\Models\EstimateTerm;
use App\Models\Exclusion;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\HotelRoomService;
use App\Models\Inclusion;
use App\Models\Iternary;
use App\Models\Lead;
use App\Models\LongWeekend;
use App\Models\Term;
use Carbon\Carbon;
use Faker\Generator;

class HotelEstimateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private function generateDateRange($start_date, $end_date)
    {
        $dates = [];

        for ($date = $start_date->copy(); $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }
    public function run()
    {
        $faker = app(Generator::class);

        $hotel_customers = Customer::get(['id', 'mobile']);


        foreach ($hotel_customers as $customer) {
            $iternary_state                     = Destination::inRandomOrder()->first();
            $destination_iternary               = DestinationIternary::where('destination_id', $iternary_state->id)->inRandomOrder()->first();
            $iternaries                         = Iternary::where('destination_iternarie_id', $destination_iternary->id)->get();

            $estimate                       = new Estimate();
            $estimate->type                 = 'hotel';
            $estimate->customer_id          = $customer->id;
            $estimate->lead_id              = Lead::where('mobile', $customer->mobile)->first()->id;
            $estimate->assigned_to          = null;
            $estimate->source               = 'custom';
            $estimate->estimate_status      = 'accepted';
            $estimate->date                 = date("Y-m-d");
            $estimate->time                 = date("H:i:s");
            $estimate->gst_filed            = $faker->randomElement([5, 18, 0]);
            $estimate->pg_charges_filed     = $faker->randomElement([5, 6, 3, 4, 7, 8]);
            $estimate->payment_modes        = ["1", "2", "3"];
            $estimate->iternary_state       = $iternary_state->id;
            $estimate->iternary             = $destination_iternary->id;
            $estimate->website              = $faker->randomElement(['ranthamboretigerreserve.in', 'jimcorbettnationalparkonline.in', 'girsafaribooking.com', 'jimcorbett.in', 'girlionsafari.com', 'girlion.in', 'bandhavgarh.com', 'travelwalacab.com', 'dailytourandtravel.com']);
            $estimate->save();

            $inclusion_filter                     = "normal";
            $term_filter                          = "normal";
            $destination                          = $faker->randomElement(['Corbett National Park', 'Ranthambore National Park']);

            $hotel_estimate                                = new EstimateHotel();
            $hotel_estimate->estimate_id                   = $estimate->id;
            $hotel_estimate->adult                         = 3;
            $hotel_estimate->child                         = 0;
            $hotel_estimate->room                          = 1;
            $hotel_estimate->bed                           = 1;
            $hotel_estimate->check_in                      = Carbon::now()->addMonth()->format('Y-m-d');
            $hotel_estimate->check_out                     = Carbon::now()->addMonth()->addDays(2)->format('Y-m-d');
            $hotel_estimate->destination                   = $destination;
            $hotel_estimate->note                          = $faker->realText($maxNbChars = 200, $indexSize = 2);
            $hotel_estimate->inclusion_filter              = $inclusion_filter;
            $hotel_estimate->term_filter                   = $term_filter;
            $hotel_estimate->save();

            $dates                                          = $this->generateDateRange(Carbon::parse($hotel_estimate->check_in), Carbon::parse($hotel_estimate->check_out));
            $bed                                            = $hotel_estimate->bed;
            $child                                          = $hotel_estimate->child;

            if ($destination == "Corbett National Park") {
                for ($i = 0; $i < 2; $i++) {
                    $hotel                                  = Hotel::where('city', 'Corbett National Park')->inRandomOrder()->first();
                    $room                                   = HotelRoom::where('hotel_id', $hotel->id)->inRandomOrder()->first();
                    $service                                = HotelRoomService::where('hotel_id', $hotel->id)->where('room_id', $room->id)->inRandomOrder()->first();
                    $total                                  = 0;
                    $room_charge                            = 0;
                    foreach ($dates as $date) {

                        $long_weekend_exists = LongWeekend::whereDate('start', '<=', $date)
                            ->whereDate('end', '>=', $date)
                            ->exists();

                        if ($long_weekend_exists) {
                            if ($bed == 0) {
                                $room_charge    += $hotel_estimate->room * $service->weekend_price;
                            } else {
                                $room_charge    += $hotel_estimate->room * $service->weekend_price;
                                if ($bed == $child) {
                                    $room_charge     +=  $service->extra_child_weekend_price * $child;
                                } elseif ($bed > $child) {
                                    $extra_adults     = $bed - $child;
                                    $room_charge     +=  ($service->extra_child_weekend_price * $child) + ($service->extra_adult_weekend_price * $extra_adults);
                                } elseif ($bed < $child) {
                                    $room_charge     +=  $service->extra_child_weekend_price * $bed;
                                }
                            }
                        } else {
                            if ($bed == 0) {
                                $room_charge    += $hotel_estimate->room * $service->price;
                            } else {
                                $room_charge    += $hotel_estimate->room * $service->price;
                                if ($bed == $child) {
                                    $room_charge     +=  $service->extra_child_price * $child;
                                } elseif ($bed > $child) {
                                    $extra_adults = $bed - $child;
                                    $room_charge     +=  ($service->extra_child_price * $child) + ($service->extra_adult_price * $extra_adults);
                                } elseif ($bed < $child) {
                                    $room_charge     +=  $service->extra_child_price * $bed;
                                }
                            }
                        }
                    }

                    $total                                  = $room_charge;
                    $discount                               = $faker->randomElement([100,  200, 300, 400, 500, 600, 700]);
                    $total_without_gst                      = $total - $discount;
                    $gst                                    = round(($estimate->gst_filed / 100) * $total_without_gst);
                    $total_with_gst                         = $total_without_gst + $gst;
                    $pg_charges                             = round(($estimate->pg_charges_filed / 100) * $total_with_gst);
                    $hotel_total                            = $total_with_gst + $pg_charges;

                    $option                                 = new EstimateHotelOption;
                    $option->estimate_id                    = $estimate->id;
                    $option->estimate_hotel_id              = $hotel_estimate->id;
                    $option->hotel_id                       = $hotel->id;
                    $option->room_id                        = $room->id;
                    $option->service_id                     = $service->id;
                    $option->amount                         = $total;
                    $option->discount                       = $discount;
                    $option->accepted                       = $i == 0 ? 'yes' : 'no';
                    $option->total                          = $hotel_total;
                    $option->save();
                }
            }

            if ($destination == "Ranthambore National Park") {
                for ($i = 0; $i < 2; $i++) {
                    $hotel                                  = Hotel::where('city', 'Ranthambore National Park')->inRandomOrder()->first();
                    $room                                   = HotelRoom::where('hotel_id', $hotel->id)->inRandomOrder()->first();
                    $service                                = HotelRoomService::where('hotel_id', $hotel->id)->where('room_id', $room->id)->inRandomOrder()->first();
                    $total                                  = 0;
                    $room_charge                            = 0;
                    foreach ($dates as $date) {

                        $long_weekend_exists = LongWeekend::whereDate('start', '<=', $date)
                            ->whereDate('end', '>=', $date)
                            ->exists();

                        if ($long_weekend_exists) {
                            if ($bed == 0) {
                                $room_charge    += $hotel_estimate->room * $service->weekend_price;
                            } else {
                                $room_charge    += $hotel_estimate->room * $service->weekend_price;
                                if ($bed == $child) {
                                    $room_charge     +=  $service->extra_child_weekend_price * $child;
                                } elseif ($bed > $child) {
                                    $extra_adults     = $bed - $child;
                                    $room_charge     +=  ($service->extra_child_weekend_price * $child) + ($service->extra_adult_weekend_price * $extra_adults);
                                } elseif ($bed < $child) {
                                    $room_charge     +=  $service->extra_child_weekend_price * $bed;
                                }
                            }
                        } else {
                            if ($bed == 0) {
                                $room_charge    += $hotel_estimate->room * $service->price;
                            } else {
                                $room_charge    += $hotel_estimate->room * $service->price;
                                if ($bed == $child) {
                                    $room_charge     +=  $service->extra_child_price * $child;
                                } elseif ($bed > $child) {
                                    $extra_adults = $bed - $child;
                                    $room_charge     +=  ($service->extra_child_price * $child) + ($service->extra_adult_price * $extra_adults);
                                } elseif ($bed < $child) {
                                    $room_charge     +=  $service->extra_child_price * $bed;
                                }
                            }
                        }
                    }

                    $total                                  = $room_charge;
                    $discount                               = $faker->randomElement([100,  200, 300, 400, 500, 600, 700]);
                    $total_without_gst                      = $total - $discount;
                    $gst                                    = round(($estimate->gst_filed / 100) * $total_without_gst);
                    $total_with_gst                         = $total_without_gst + $gst;
                    $pg_charges                             = round(($estimate->pg_charges_filed / 100) * $total_with_gst);
                    $hotel_total                            = $total_with_gst + $pg_charges;

                    $option                                 = new EstimateHotelOption;
                    $option->estimate_id                    = $estimate->id;
                    $option->estimate_hotel_id              = $hotel_estimate->id;
                    $option->hotel_id                       = $hotel->id;
                    $option->room_id                        = $room->id;
                    $option->service_id                     = $service->id;
                    $option->amount                         = $total;
                    $option->discount                       = $discount;
                    $option->accepted                       = $i == 0 ? 'yes' : 'no';
                    $option->total                          = $hotel_total;
                    $option->save();
                }
            }

            $inclusions = Inclusion::where('type', 'hotel')->where('filter', 'normal')->get();

            if (!empty($inclusions)) {
                foreach ($inclusions as $inc) {
                    $inclusion                  = new EstimateInclusion;
                    $inclusion->estimate_id     = $estimate->id;
                    $inclusion->content         = $inc->content;
                    $inclusion->filter          = $inclusion_filter;
                    $inclusion->save();
                }
            }

            $exclusions = Exclusion::where('type', 'hotel')->where('filter', 'normal')->get();

            if (!empty($exclusions)) {
                foreach ($exclusions as $exc) {
                    $exclusion                  = new EstimateExclusion();
                    $exclusion->estimate_id     = $estimate->id;
                    $exclusion->content         = $exc->content;
                    $exclusion->filter          = 'normal';
                    $exclusion->save();
                }
            }


            $terms = Term::where('mode', 'estimate')->where('type', 'hotel')->where('filter', 'normal')->get();

            if (!empty($terms)) {
                foreach ($terms as $ter) {
                    $term                  = new EstimateTerm();
                    $term->estimate_id     = $estimate->id;
                    $term->content         = $ter->content;
                    $term->filter          = 'normal';
                    $term->save();
                }
            }
        }
    }
}
