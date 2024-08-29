<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CountryState;

class CountryStateSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CountryState::truncate();
        $open = fopen(base_path("public/states.csv"), "r");
         $firstline = true;
        while (($data = fgetcsv($open, 6000, ",")) !== FALSE) 
        {
             if (!$firstline) {
               CountryState::create( [
                'id'=>$data[0],
                'state'=>$data[1],
                'country'=>$data[4]
                ] );
              }
           $firstline = false;
        }
        fclose($open);
    }
}
