<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Destination;
use App\Models\DestinationIternary;
use App\Models\Estimate;
use App\Models\EstimateCab;
use App\Models\EstimateCabOption;
use App\Models\EstimateExclusion;
use App\Models\EstimateHotel;
use App\Models\EstimateHotelDestinationOption;
use App\Models\EstimateInclusion;
use App\Models\EstimateIternary;
use App\Models\EstimateSafari;
use App\Models\EstimateSafariOption;
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
use Illuminate\Database\Seeder;

class PackageEstimateSeed extends Seeder
{
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

        $customers = Customer::get(['id', 'mobile']);

        foreach ($customers as $customer) {
            $iternary_state                     = Destination::inRandomOrder()->first();
            $destination_iternary               = DestinationIternary::where('destination_id', $iternary_state->id)->inRandomOrder()->first();
            $iternaries                         = Iternary::where('destination_iternarie_id', $destination_iternary->id)->get();

            $estimate                       = new Estimate();
            $estimate->type                 = 'package';
            $estimate->customer_id          = $customer->id;
            $estimate->lead_id              = Lead::where('mobile', $customer->mobile)->first()->id;
            $estimate->assigned_to          = null;
            $estimate->source               = 'custom';
            $estimate->estimate_status      = 'accepted';
            $estimate->date                 = date("Y-m-d");
            $estimate->gst_filed            = $faker->randomElement([5, 18, 0]);
            $estimate->pg_charges_filed     = $faker->randomElement([5, 6, 3, 4, 7, 8]);
            $estimate->time                 = date("H:i:s");
            $estimate->payment_modes        = ["1", "2", "3"];
            $estimate->iternary_state       = $iternary_state->id;
            $estimate->duration             = $destination_iternary->duration;
            $estimate->iternary             = $destination_iternary->id;
            $estimate->website              = $faker->randomElement(['ranthamboretigerreserve.in', 'jimcorbettnationalparkonline.in', 'girsafaribooking.com', 'jimcorbett.in', 'girlionsafari.com', 'girlion.in', 'bandhavgarh.com', 'travelwalacab.com', 'dailytourandtravel.com']);
            $estimate->save();

            for ($i = 0; $i < 2; $i++) {
                //Cab

                $vehicle_type                       = $faker->randomElement(["Innova", 'Jeep', 'Swift Dezire', 'Toyota Etios', 'Mini Bus']);

                $cab                                = new EstimateCab();
                $cab->estimate_id                   = $estimate->id;
                $cab->trip_type                     = $faker->randomElement(["Round Trip", 'One Side']);
                $cab->pickup_medium                 = 'any';
                $cab->vehicle_type                  = $vehicle_type;
                $cab->start_date                    = Carbon::now()->addMonth()->format('Y-m-d');
                $cab->end_date                      = Carbon::now()->addMonth()->addDays(2)->format('Y-m-d');
                $cab->days                          = $faker->randomElement([1,  2, 3, 4, 5, 6, 7]);
                $cab->pick_up                       = $faker->randomElement(["Noida",  "Delhi", "Ghaziabad", "Gurgaon", "Rohtak"]);
                $cab->drop                          = $faker->randomElement(["Kalagarh",  "Kotdwar", "Kedarnath", "Amarnath", "Rajasthan"]);
                $cab->pickup_time                   = $faker->randomElement(['10:44', '05:00', '06:00']);
                $cab->total_riders                  = 4;
                $cab->no_of_cab                     = 1;
                $cab->note                          = $faker->realText($maxNbChars = 200, $indexSize = 2);
                $cab->save();

                $cab_amount                         = $faker->randomElement([10000,  20000, 30000, 4000, 5000, 6000, 7000]);
                $cab_discount                       = $faker->randomElement([1000,  2000, 3000, 400, 500, 600, 700]);
                $cab_total                          = $cab_amount - $cab_discount;
            }

            $cab_option                         = new EstimateCabOption();
            $cab_option->estimate_id            = $estimate->id;
            $cab_option->estimate_cab_id        = $cab->id;
            $cab_option->content                = $vehicle_type . 'Booking';
            $cab_option->amount                 = $cab_amount;
            $cab_option->discount               = $cab_discount;
            $cab_option->total                  = $cab_total;
            $cab_option->save();


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
                for ($j = 0; $j < 2; $j++) {
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

                    $total  = $room_charge;

                    $option                                 = new EstimateHotelDestinationOption();
                    $option->estimate_id                    = $estimate->id;
                    $option->estimate_hotel_id              = $hotel_estimate->id;
                    $option->hotel_id                       = $hotel->id;
                    $option->room_id                        = $room->id;
                    $option->service_id                     = $service->id;
                    $option->amount                         = $total;
                    $option->discount                       = 100;
                    $option->total                          = $total - 100;
                    $option->save();
                }
            }

            if ($destination == "Ranthambore National Park") {
                for ($k = 0; $k < 2; $k++) {
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

                    $total  = $room_charge;

                    $hotell_option                                 = new EstimateHotelDestinationOption();
                    $hotell_option->estimate_id                    = $estimate->id;
                    $hotell_option->estimate_hotel_id              = $hotel_estimate->id;
                    $hotell_option->hotel_id                       = $hotel->id;
                    $hotell_option->room_id                        = $room->id;
                    $hotell_option->service_id                     = $service->id;
                    $hotell_option->amount                         = $total;
                    $hotell_option->discount                       = 100;
                    $hotell_option->total                          = $total - 100;
                    $hotell_option->save();
                }
            }

            if($destination == "Corbett National Park"){
                $sanctuary = "jim";
            }else{
                $sanctuary = "ranthambore";
            }           

            if ($sanctuary == "gir") {
                for ($i = 0; $i < 2; $i++) {
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
                }
            }

            if ($sanctuary == "jim") {
                for ($i = 0; $i < 2; $i++) {
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
                }
            }

            if ($sanctuary == "ranthambore") {
                for ($i = 0; $i < 2; $i++) {
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
                }
            }

            $safari_amount                         = $faker->randomElement([10000,  20000, 30000, 4000, 5000, 6000, 7000]);
            $safari_discount                       = $faker->randomElement([1000,  2000, 3000, 400, 500, 600, 700]);
            $safari_total                          = $safari_amount - $safari_discount;

            $option                         = new EstimateSafariOption();
            $option->estimate_id            = $estimate->id;
            $option->estimate_safari_id     = $safari->id;
            $option->content                = ucfirst($sanctuary) . 'Booking';
            $option->amount                 = $safari_amount;
            $option->discount               = $safari_discount;
            $option->total                  = $safari_total;
            $option->save();

            $inclusions                         = Inclusion::where('type', 'package')->get();
            $exclusions                         = Exclusion::where('type', 'package')->get();
            $terms                              = Term::where('mode', 'estimate')->where('type', 'package')->where('filter', $sanctuary)->get();

            if (!empty($inclusions)) {
                foreach ($inclusions as $inclu) {
                    $inclusion                  = new EstimateInclusion();
                    $inclusion->estimate_id     = $estimate->id;
                    $inclusion->content         = $inclu->content;
                    $inclusion->save();
                }
            }

            if (!empty($terms)) {
                foreach ($terms as $ter) {
                    $term                  = new EstimateTerm();
                    $term->estimate_id     = $estimate->id;
                    $term->content         = $ter->content;
                    $term->save();
                }
            }

            if (!empty($exclusions)) {
                foreach ($exclusions as $exclu) {
                    $exclusion                  = new EstimateExclusion();
                    $exclusion->estimate_id     = $estimate->id;
                    $exclusion->content         = $exclu->content;
                    $exclusion->save();
                }
            }
            if (!empty($iternaries)) {
                foreach ($iternaries as $iter) {
                    $iternary               = new EstimateIternary();
                    $iternary->estimate_id  = $estimate->id;
                    $iternary->title        = $iter->title;
                    $iternary->text         = $iter->text;
                    $iternary->save();
                }
            }
        }
    }
}
