<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vendor::create([
            'id' => 1,
            'sanctuary' => 'gir',
            'default' => 'yes',
            'name' => 'Sultan',
            'email' => 'sultan@gmail.com',
            'phone' => '+91 9998142109',
            'alternate' => '+91 6356523001',
            'created_at' => '2022-05-04 08:14:35',
            'updated_at' => '2022-05-04 08:17:58'
        ]);

        Vendor::create([
            'id' => 2,
            'sanctuary' => 'gir',
            'default' => 'no',
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'phone' => '+91 9998142785',
            'alternate' => '+91 9656965844',
            'created_at' => '2022-05-04 08:14:35',
            'updated_at' => '2022-05-04 08:17:58'
        ]);

        Vendor::create([
            'id' => 3,
            'sanctuary' => 'jim',
            'default' => 'yes',
            'name' => 'Ajay',
            'email' => 'ajay@gmail.com',
            'phone' => '+91 9998198745',
            'alternate' => '+91 7856552147',
            'created_at' => '2022-05-04 08:14:35',
            'updated_at' => '2022-05-04 08:17:58'
        ]);

        Vendor::create([
            'id' => 4,
            'sanctuary' => 'jim',
            'default' => 'no',
            'name' => 'Mahesh',
            'email' => 'mahesh@gmail.com',
            'phone' => '+91 9985478968',
            'alternate' => '+91 8574589654',
            'created_at' => '2022-05-04 08:14:35',
            'updated_at' => '2022-05-04 08:17:58'
        ]);

        Vendor::create([
            'id' => 5,
            'sanctuary' => 'ranthambore',
            'default' => 'yes',
            'name' => 'Mithlesh',
            'email' => 'mithlesh@gmail.com',
            'phone' => '+91 9954785625',
            'alternate' => '+91 7485214587',
            'created_at' => '2022-05-04 08:14:35',
            'updated_at' => '2022-05-04 08:35:15'
        ]);

        Vendor::create([
            'id' => 6,
            'sanctuary' => 'ranthambore',
            'default' => 'no',
            'name' => 'Hitesh Rajput',
            'email' => 'hitesh@gmail.com',
            'phone' => '+91 9984785415',
            'alternate' => '+91 9999588745',
            'created_at' => '2022-05-04 08:14:35',
            'updated_at' => '2022-05-04 08:17:58'
        ]);

        Vendor::create([
            'id' => 7,
            'sanctuary' => 'ranthambore',
            'default' => 'no',
            'name' => 'Ravi',
            'email' => 'hitesh@gmail.com',
            'phone' => '+91 7014304817',
            'alternate' => '+91 8107600315',
            'created_at' => '2022-05-04 08:14:35',
            'updated_at' => '2022-05-04 08:17:58'
        ]);

        Vendor::create([
            'id' => 8,
            'sanctuary' => 'cab',
            'default' => 'yes',
            'name' => 'Sultan',
            'email' => 'sultan@gmail.com',
            'phone' => '+91 9998142109',
            'alternate' => '+91 6356523001',
            'created_at' => '2022-05-04 08:14:35',
            'updated_at' => '2022-05-04 08:17:58'
        ]);

        Vendor::create([
            'id' => 9,
            'sanctuary' => 'cab',
            'default' => 'no',
            'name' => 'Ravi',
            'email' => 'hitesh@gmail.com',
            'phone' => '+91 7014304817',
            'alternate' => '+91 8107600315',
            'created_at' => '2022-05-04 08:14:35',
            'updated_at' => '2022-05-04 08:17:58'
        ]);

        Vendor::create([
            'id' => 10,
            'sanctuary' => 'cab',
            'default' => 'no',
            'name' => 'Shankar',
            'email' => 'hitesh@gmail.com',
            'phone' => '+91 9910943632',
            'alternate' => '+91 6375495386',
            'created_at' => '2022-05-04 08:14:35',
            'updated_at' => '2022-05-04 08:17:58'
        ]);
    }
}
