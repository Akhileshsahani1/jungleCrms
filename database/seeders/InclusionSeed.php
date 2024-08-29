<?php

namespace Database\Seeders;

use App\Models\Inclusion;
use Illuminate\Database\Seeder;

class InclusionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Inclusion::create([
            'id' => 1,
            'type' => 'cab',
            'filter' => NULL,
            'content' => 'Driver Allowance',
            'created_at' => '2022-04-24 04:32:14',
            'updated_at' => '2022-05-14 18:53:51'
        ]);

        Inclusion::create([
            'id' => 2,
            'type' => 'cab',
            'filter' => NULL,
            'content' => '24x7 Customer Care',
            'created_at' => '2022-04-24 04:32:27',
            'updated_at' => '2022-05-14 18:55:52'
        ]);

        Inclusion::create([
            'id' => 3,
            'type' => 'cab',
            'filter' => NULL,
            'content' => 'State Tax',
            'created_at' => '2022-04-24 04:32:34',
            'updated_at' => '2022-05-14 18:56:02'
        ]);

        Inclusion::create([
            'id' => 4,
            'type' => 'hotel',
            'filter' => 'normal',
            'content' => 'Welcome drink on arrival.',
            'created_at' => '2022-04-24 04:32:49',
            'updated_at' => '2022-04-24 04:32:49'
        ]);

        Inclusion::create([
            'id' => 5,
            'type' => 'hotel',
            'filter' => 'normal',
            'content' => 'Room On Double/Triple/Quad Sharing Basis.',
            'created_at' => '2022-04-24 04:33:06',
            'updated_at' => '2022-04-24 04:33:06'
        ]);

        Inclusion::create([
            'id' => 6,
            'type' => 'hotel',
            'filter' => 'normal',
            'content' => 'Complimentary use of recreational activities in resort premises.',
            'created_at' => '2022-04-24 04:33:19',
            'updated_at' => '2022-05-15 00:52:00'
        ]);

        Inclusion::create([
            'id' => 7,
            'type' => 'hotel',
            'filter' => 'normal',
            'content' => 'Adventure activities in Kosi river on extra payment (river crossing, bridge falling & rappelling).',
            'created_at' => '2022-04-24 04:33:29',
            'updated_at' => '2022-04-24 04:33:29'
        ]);

        Inclusion::create([
            'id' => 8,
            'type' => 'hotel',
            'filter' => 'normal',
            'content' => 'Complimentary use of swimming pool',
            'created_at' => '2022-04-24 04:33:43',
            'updated_at' => '2022-05-15 00:51:18'
        ]);

        Inclusion::create([
            'id' => 9,
            'type' => 'hotel',
            'filter' => 'weekend',
            'content' => 'Welcome drink on arrival.',
            'created_at' => '2022-04-24 04:32:49',
            'updated_at' => '2022-04-24 04:32:49'
        ]);

        Inclusion::create([
            'id' => 10,
            'type' => 'hotel',
            'filter' => 'weekend',
            'content' => 'Room On Double/Triple/Quad Sharing Basis.',
            'created_at' => '2022-04-24 04:33:06',
            'updated_at' => '2022-04-24 04:33:06'
        ]);

        Inclusion::create([
            'id' => 11,
            'type' => 'hotel',
            'filter' => 'weekend',
            'content' => 'Recreational activities in resort premises',
            'created_at' => '2022-04-24 04:33:19',
            'updated_at' => '2022-04-24 04:33:19'
        ]);

        Inclusion::create([
            'id' => 12,
            'type' => 'hotel',
            'filter' => 'weekend',
            'content' => 'Adventure activities in Kosi river on extra payment (river crossing, bridge falling & rappelling).',
            'created_at' => '2022-04-24 04:33:29',
            'updated_at' => '2022-04-24 04:33:29'
        ]);

        Inclusion::create([
            'id' => 13,
            'type' => 'hotel',
            'filter' => 'weekend',
            'content' => 'Above mentioned package will be applicable only on Indian nationals.',
            'created_at' => '2022-04-24 04:33:43',
            'updated_at' => '2022-04-24 04:33:43'
        ]);

        Inclusion::create([
            'id' => 14,
            'type' => 'hotel',
            'filter' => 'festival',
            'content' => 'Welcome drink on arrival.',
            'created_at' => '2022-04-24 04:32:49',
            'updated_at' => '2022-04-24 04:32:49'
        ]);

        Inclusion::create([
            'id' => 15,
            'type' => 'hotel',
            'filter' => 'festival',
            'content' => 'Room On Double/Triple/Quad Sharing Basis.',
            'created_at' => '2022-04-24 04:33:06',
            'updated_at' => '2022-04-24 04:33:06'
        ]);

        Inclusion::create([
            'id' => 16,
            'type' => 'hotel',
            'filter' => 'festival',
            'content' => 'Recreational activities in resort premises',
            'created_at' => '2022-04-24 04:33:19',
            'updated_at' => '2022-04-24 04:33:19'
        ]);

        Inclusion::create([
            'id' => 17,
            'type' => 'hotel',
            'filter' => 'festival',
            'content' => 'Adventure activities in Kosi river on extra payment (river crossing, bridge falling & rappelling).',
            'created_at' => '2022-04-24 04:33:29',
            'updated_at' => '2022-04-24 04:33:29'
        ]);

        Inclusion::create([
            'id' => 18,
            'type' => 'hotel',
            'filter' => 'festival',
            'content' => 'Above mentioned package will be applicable only on Indian nationals.',
            'created_at' => '2022-04-24 04:33:43',
            'updated_at' => '2022-04-24 04:33:43'
        ]);

        Inclusion::create([
            'id' => 19,
            'type' => 'safari',
            'filter' => 'gir',
            'content' => 'All members safari reporting',
            'created_at' => '2022-04-24 04:35:40',
            'updated_at' => '2022-04-24 04:35:40'
        ]);

        Inclusion::create([
            'id' => 20,
            'type' => 'safari',
            'filter' => 'gir',
            'content' => 'Permit Clearance of all visitors',
            'created_at' => '2022-04-24 04:35:50',
            'updated_at' => '2022-04-24 04:35:50'
        ]);

        Inclusion::create([
            'id' => 21,
            'type' => 'safari',
            'filter' => 'gir',
            'content' => 'Nature Guide at the time of safari',
            'created_at' => '2022-04-24 04:36:00',
            'updated_at' => '2022-04-24 04:36:00'
        ]);

        Inclusion::create([
            'id' => 22,
            'type' => 'safari',
            'filter' => 'gir',
            'content' => 'Jeep and Experienced Driver',
            'created_at' => '2022-04-24 04:36:17',
            'updated_at' => '2022-04-24 04:36:17'
        ]);

        Inclusion::create([
            'id' => 23,
            'type' => 'safari',
            'filter' => 'jim',
            'content' => 'All members safari reporting',
            'created_at' => '2022-04-24 04:35:40',
            'updated_at' => '2022-04-24 04:35:40'
        ]);

        Inclusion::create([
            'id' => 24,
            'type' => 'safari',
            'filter' => 'jim',
            'content' => 'Permit Clearance of all visitors',
            'created_at' => '2022-04-24 04:35:50',
            'updated_at' => '2022-04-24 04:35:50'
        ]);

        Inclusion::create([
            'id' => 25,
            'type' => 'safari',
            'filter' => 'jim',
            'content' => 'Jeep and Experienced Driver',
            'created_at' => '2022-04-24 04:36:17',
            'updated_at' => '2022-04-24 04:36:17'
        ]);

        Inclusion::create([
            'id' => 26,
            'type' => 'safari',
            'filter' => 'ranthambore',
            'content' => 'All members safari reporting',
            'created_at' => '2022-04-24 04:35:40',
            'updated_at' => '2022-04-24 04:35:40'
        ]);

        Inclusion::create([
            'id' => 27,
            'type' => 'safari',
            'filter' => 'ranthambore',
            'content' => 'Permit Clearance of all visitors',
            'created_at' => '2022-04-24 04:35:50',
            'updated_at' => '2022-04-24 04:35:50'
        ]);

        Inclusion::create([
            'id' => 28,
            'type' => 'safari',
            'filter' => 'ranthambore',
            'content' => 'Nature Guide at the time of safari',
            'created_at' => '2022-04-24 04:36:00',
            'updated_at' => '2022-04-24 04:36:00'
        ]);

        Inclusion::create([
            'id' => 29,
            'type' => 'safari',
            'filter' => 'ranthambore',
            'content' => 'Pickup and Drop from nearby resorts for jungle safari',
            'created_at' => '2022-04-24 04:36:17',
            'updated_at' => '2022-04-24 04:36:17'
        ]);

        Inclusion::create([
            'id' => 30,
            'type' => 'safari',
            'filter' => 'ranthambore',
            'content' => 'Jeep and Experienced Driver',
            'created_at' => '2022-04-24 04:41:58',
            'updated_at' => '2022-04-24 04:41:58'
        ]);

        Inclusion::create([
            'id' => 31,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Safari Booking Reporting',
            'created_at' => '2022-04-24 04:32:14',
            'updated_at' => '2022-04-24 04:32:14'
        ]);

        Inclusion::create([
            'id' => 32,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Permit Clearance',
            'created_at' => '2022-04-24 04:32:27',
            'updated_at' => '2022-04-24 04:32:27'
        ]);

        Inclusion::create([
            'id' => 33,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Meals as per the Booking',
            'created_at' => '2022-04-24 04:32:34',
            'updated_at' => '2022-05-30 20:47:51'
        ]);

        Inclusion::create([
            'id' => 34,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Welcome drink on arrival',
            'created_at' => '2022-05-11 16:08:47',
            'updated_at' => '2022-05-11 16:08:47'
        ]);

        Inclusion::create([
            'id' => 35,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Complimentary use of Recreational activities in resort premises',
            'created_at' => '2022-05-11 16:09:09',
            'updated_at' => '2022-05-15 00:53:08'
        ]);

        Inclusion::create([
            'id' => 36,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Nature walk & bonfire (in Winter Season only)',
            'created_at' => '2022-05-11 16:09:23',
            'updated_at' => '2022-05-11 16:09:23'
        ]);

        Inclusion::create([
            'id' => 37,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Adventure activities in Kosi river on extra payment (river crossing, bridge falling & rappelling)',
            'created_at' => '2022-05-11 16:09:37',
            'updated_at' => '2022-05-11 16:09:37'
        ]);

        Inclusion::create([
            'id' => 39,
            'type' => 'cab',
            'filter' => NULL,
            'content' => 'Road Tax',
            'created_at' => '2022-05-14 18:56:10',
            'updated_at' => '2022-05-14 18:56:10'
        ]);

        Inclusion::create([
            'id' => 40,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Complimentary use of swimming pool',
            'created_at' => '2022-05-15 00:52:47',
            'updated_at' => '2022-05-15 00:52:47'
        ]);

        Inclusion::create([
            'id' => 41,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Guide Fee is not Included, You have to pay on the spot INR 800.',
            'created_at' => '2022-06-14 16:53:56',
            'updated_at' => '2022-06-14 16:53:56'
        ]);

        Inclusion::create([
            'id' => 42,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Safari Booking Reporting',
            'created_at' => '2022-04-24 04:32:14',
            'updated_at' => '2022-04-24 04:32:14'
        ]);

        Inclusion::create([
            'id' => 43,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Permit Clearance',
            'created_at' => '2022-04-24 04:32:27',
            'updated_at' => '2022-04-24 04:32:27'
        ]);

        Inclusion::create([
            'id' => 44,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Meals as per the Booking',
            'created_at' => '2022-04-24 04:32:34',
            'updated_at' => '2022-05-30 20:47:51'
        ]);

        Inclusion::create([
            'id' => 45,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Welcome drink on arrival',
            'created_at' => '2022-05-11 16:08:47',
            'updated_at' => '2022-05-11 16:08:47'
        ]);

        Inclusion::create([
            'id' => 46,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Complimentary use of Recreational activities in resort premises',
            'created_at' => '2022-05-11 16:09:09',
            'updated_at' => '2022-05-15 00:53:08'
        ]);

        Inclusion::create([
            'id' => 47,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Nature walk & bonfire (in Winter Season only)',
            'created_at' => '2022-05-11 16:09:23',
            'updated_at' => '2022-05-11 16:09:23'
        ]);

        Inclusion::create([
            'id' => 48,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Adventure activities in Kosi river on extra payment (river crossing, bridge falling & rappelling)',
            'created_at' => '2022-05-11 16:09:37',
            'updated_at' => '2022-05-11 16:09:37'
        ]);

        Inclusion::create([
            'id' => 49,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Complimentary use of swimming pool',
            'created_at' => '2022-05-15 00:52:47',
            'updated_at' => '2022-05-15 00:52:47'
        ]);

        Inclusion::create([
            'id' => 50,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Guide Fee is not Included, You have to pay on the spot INR 800.',
            'created_at' => '2022-06-14 16:53:56',
            'updated_at' => '2022-06-14 16:53:56'
        ]);
    }
}
