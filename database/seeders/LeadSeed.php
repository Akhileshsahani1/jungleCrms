<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Support\Str;
class LeadSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = app(Generator::class);
        $date = Carbon::now();
        for ($i = 1; $i < 21; $i++) {
            Lead::create([
                'name'              =>  $faker->firstname() . ' ' . $faker->lastname(),
                'email'             => $faker->unique()->safeEmail(),
                'mobile'            => $i == 1 ? '9999577620' : $faker->numerify('9#########'),
                'website'           => $faker->randomElement(['jimcorbett.in']),               
                'meta'              => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'date'              => $date->format('Y-m-d'),
                'time'              => $date->format('h:i'),
                'lead_status'       => 0,
                'payment_status'    => "waiting",
                'assigned_to'       => 2,
                'date_assigned'     => null,
                'source'            => $faker->randomElement(['crm', 'website']),
                'dob'               => Carbon::now()->subYears(35)->format('Y-m-d'),
                'anniversary'       => Carbon::now()->subYears(10)->format('Y-m-d'),
                'more_details'      => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'address'           => $faker->address,
                'meal_plan'         => $faker->randomElement(['Should Include Breakfast, Lunch & Dinner', 'Should Include Lunch & Dinner', 'Should Include Breakfast & Dinner', 'Should Include Breakfast& Lunch']),
                'total_traveller'   => $faker->randomElement([1, 2, 3, 4, 5, 6, 7]),
                'travel_date'       => Carbon::now()->addMonth()->format('Y-m-d')
            ]);
        }

        $leads = Lead::get();
        foreach($leads as $lead){
            Customer::create([
                'name'              => $lead->name,
                'email'             => $lead->email,
                'mobile'            => $lead->mobile,
                'address'           => $lead->address,
                'state'             => $faker->randomElement(['Delhi', 'Punjab', 'Bihar', 'Assam', 'Goa', 'Meghalya']),
                'country'           => "India",
                'company'           => $faker->company,
                'gstin'             => Str::upper(Str::random(15)),
                'dob'               => $lead->dob,            
                'anniversary'       => $lead->anniversary,
                'more_details'      => $lead->more_details,
                'meal_plan'         => $lead->meal_plan,
                'total_traveller'   => $lead->total_traveller,
                'travel_date'       => $lead->travel_date,
            ]);
        }
    }
}
