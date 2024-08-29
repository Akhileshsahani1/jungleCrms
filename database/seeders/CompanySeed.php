<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create( [
            'id'=>1,
            'name'=>'Jungle safari India',
            'email'=>'junglesafari360@gmail.com',
            'phone'=>'01135600224',
            'address_1'=>'A-2 Second Floor, Ganesh Nagar,',
            'address_2'=>'Pandav Nagar Complex, near Aggarwal Sweets',
            'state'=>'Delhi',
            'pincode'=>110092,
            'gstin'=>'07EIUPS0998K1Z2',
            'websites'=> ["ranthamboretigerreserve.in", "jimcorbettnationalparkonline.in", "girsafaribooking.com", "jimcorbett.in", "girlionsafari.com", "girlion.in", "bandhavgarh.com", "travelwalacab.com", "dailytourandtravel.com"],
            'default'=>'yes',
            'logo' => 'invoice-logo.png',
            'created_at'=>'2022-05-09 05:24:55',
            'updated_at'=>'2022-05-09 05:39:36'
            ] );
    }
}
