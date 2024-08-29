<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\LeadFollowUp;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Seeder;

class LeadFollowUpSeeder extends Seeder
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
        $leads = Lead::get();
        foreach($leads as $lead){
            for ($i = 1; $i < 3; $i++) {
                LeadFollowUp::create( [
                    'user_id' => 2,
                    'lead_id' => $lead->id,
                    'datetime' => $date,
                    'comment' => 'This note no '.$i.' is for Lead no.'.$lead->id,
                ]);
            }
        }
       
    }
}
