<?php

namespace Database\Seeders;

use App\Models\PermitRate;
use Illuminate\Database\Seeder;

class PermitRateSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermitRate::create([
            'id' => 1,
            'sanctuary' => 'gir',
            'type' => 'normal',
            'nationality' => 'indian',
            'price' => '1000',
            'created_at' => '2022-05-04 09:20:26',
            'updated_at' => '2022-05-04 09:20:26'
        ]);



        PermitRate::create([
            'id' => 2,
            'sanctuary' => 'gir',
            'type' => 'weekend',
            'nationality' => 'indian',
            'price' => '1200',
            'created_at' => '2022-05-04 09:20:45',
            'updated_at' => '2022-05-04 09:20:45'
        ]);



        PermitRate::create([
            'id' => 3,
            'sanctuary' => 'gir',
            'type' => 'normal',
            'nationality' => 'foreigner',
            'price' => '1200',
            'created_at' => '2022-05-04 09:21:18',
            'updated_at' => '2022-05-04 09:21:18'
        ]);



        PermitRate::create([
            'id' => 4,
            'sanctuary' => 'gir',
            'type' => 'weekend',
            'nationality' => 'foreigner',
            'price' => '1500',
            'created_at' => '2022-05-04 09:21:32',
            'updated_at' => '2022-05-04 09:21:32'
        ]);



        PermitRate::create([
            'id' => 5,
            'sanctuary' => 'jim',
            'type' => 'normal',
            'nationality' => 'indian',
            'price' => '1000',
            'created_at' => '2022-05-04 09:20:26',
            'updated_at' => '2022-05-04 09:20:26'
        ]);



        PermitRate::create([
            'id' => 6,
            'sanctuary' => 'jim',
            'type' => 'weekend',
            'nationality' => 'indian',
            'price' => '1200',
            'created_at' => '2022-05-04 09:20:45',
            'updated_at' => '2022-05-04 09:20:45'
        ]);



        PermitRate::create([
            'id' => 7,
            'sanctuary' => 'jim',
            'type' => 'normal',
            'nationality' => 'foreigner',
            'price' => '1200',
            'created_at' => '2022-05-04 09:21:18',
            'updated_at' => '2022-05-04 09:21:18'
        ]);



        PermitRate::create([
            'id' => 8,
            'sanctuary' => 'jim',
            'type' => 'weekend',
            'nationality' => 'foreigner',
            'price' => '1500',
            'created_at' => '2022-05-04 09:21:32',
            'updated_at' => '2022-05-04 09:21:32'
        ]);



        PermitRate::create([
            'id' => 9,
            'sanctuary' => 'ranthambore',
            'type' => 'normal',
            'nationality' => 'indian',
            'price' => '1000',
            'created_at' => '2022-05-04 09:20:26',
            'updated_at' => '2022-05-04 09:20:26'
        ]);



        PermitRate::create([
            'id' => 10,
            'sanctuary' => 'ranthambore',
            'type' => 'weekend',
            'nationality' => 'indian',
            'price' => '1200',
            'created_at' => '2022-05-04 09:20:45',
            'updated_at' => '2022-05-04 09:20:45'
        ]);



        PermitRate::create([
            'id' => 11,
            'sanctuary' => 'ranthambore',
            'type' => 'normal',
            'nationality' => 'foreigner',
            'price' => '1200',
            'created_at' => '2022-05-04 09:21:18',
            'updated_at' => '2022-05-04 09:21:18'
        ]);



        PermitRate::create([
            'id' => 12,
            'sanctuary' => 'ranthambore',
            'type' => 'weekend',
            'nationality' => 'foreigner',
            'price' => '1500',
            'created_at' => '2022-05-04 09:21:32',
            'updated_at' => '2022-05-04 09:21:32'
        ]);
    }
}
