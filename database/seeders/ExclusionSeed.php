<?php

namespace Database\Seeders;

use App\Models\Exclusion;
use Illuminate\Database\Seeder;

class ExclusionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Exclusion::create([
            'id' => 1,
            'type' => 'cab',
            'filter' => NULL,
            'content' => 'Consequential loss, depreciation, wear, and tear, mechanical or electrical breakdown, failure, or breakages.',
            'created_at' => '2022-04-24 04:32:14',
            'updated_at' => '2022-05-14 18:53:51'
        ]);

        Exclusion::create([
            'id' => 2,
            'type' => 'cab',
            'filter' => NULL,
            'content' => 'Any damage to tires and tubes unless the vehicle is also damaged at the same and the liability of the insurer will be restricted to 50% of the cost of replacemen',
            'created_at' => '2022-04-24 04:32:27',
            'updated_at' => '2022-05-14 18:55:52'
        ]);

        Exclusion::create([
            'id' => 3,
            'type' => 'cab',
            'filter' => NULL,
            'content' => 'Driving without a Valid Driving License.',
            'created_at' => '2022-04-24 04:32:34',
            'updated_at' => '2022-05-14 18:56:02'
        ]);

        Exclusion::create([
            'id' => 4,
            'type' => 'hotel',
            'filter' => 'normal',
            'content' => 'Hard drink on arrival.',
            'created_at' => '2022-04-24 04:32:49',
            'updated_at' => '2022-04-24 04:32:49'
        ]);

        Exclusion::create([
            'id' => 5,
            'type' => 'hotel',
            'filter' => 'normal',
            'content' => 'Exclusion On Double/Triple/Quad Sharing Basis.',
            'created_at' => '2022-04-24 04:33:06',
            'updated_at' => '2022-04-24 04:33:06'
        ]);

        Exclusion::create([
            'id' => 6,
            'type' => 'hotel',
            'filter' => 'normal',
            'content' => 'Exclusion use of recreational activities in resort premises.',
            'created_at' => '2022-04-24 04:33:19',
            'updated_at' => '2022-05-15 00:52:00'
        ]);

        Exclusion::create([
            'id' => 7,
            'type' => 'hotel',
            'filter' => 'normal',
            'content' => 'Exclusion activities in Kosi river on extra payment (river crossing, bridge falling & rappelling).',
            'created_at' => '2022-04-24 04:33:29',
            'updated_at' => '2022-04-24 04:33:29'
        ]);

        Exclusion::create([
            'id' => 8,
            'type' => 'hotel',
            'filter' => 'normal',
            'content' => 'Exclusion use of swimming pool',
            'created_at' => '2022-04-24 04:33:43',
            'updated_at' => '2022-05-15 00:51:18'
        ]);

        Exclusion::create([
            'id' => 9,
            'type' => 'hotel',
            'filter' => 'weekend',
            'content' => 'Exclusion drink on arrival.',
            'created_at' => '2022-04-24 04:32:49',
            'updated_at' => '2022-04-24 04:32:49'
        ]);

        Exclusion::create([
            'id' => 10,
            'type' => 'hotel',
            'filter' => 'weekend',
            'content' => 'Exclusion On Double/Triple/Quad Sharing Basis.',
            'created_at' => '2022-04-24 04:33:06',
            'updated_at' => '2022-04-24 04:33:06'
        ]);

        Exclusion::create([
            'id' => 11,
            'type' => 'hotel',
            'filter' => 'weekend',
            'content' => 'Exclusion activities in resort premises',
            'created_at' => '2022-04-24 04:33:19',
            'updated_at' => '2022-04-24 04:33:19'
        ]);

        Exclusion::create([
            'id' => 12,
            'type' => 'hotel',
            'filter' => 'weekend',
            'content' => 'Exclusion activities in Kosi river on extra payment (river crossing, bridge falling & rappelling).',
            'created_at' => '2022-04-24 04:33:29',
            'updated_at' => '2022-04-24 04:33:29'
        ]);

        Exclusion::create([
            'id' => 13,
            'type' => 'hotel',
            'filter' => 'weekend',
            'content' => 'Exclusion mentioned package will be applicable only on Indian nationals.',
            'created_at' => '2022-04-24 04:33:43',
            'updated_at' => '2022-04-24 04:33:43'
        ]);

        Exclusion::create([
            'id' => 14,
            'type' => 'hotel',
            'filter' => 'festival',
            'content' => 'Exclusion drink on arrival.',
            'created_at' => '2022-04-24 04:32:49',
            'updated_at' => '2022-04-24 04:32:49'
        ]);

        Exclusion::create([
            'id' => 15,
            'type' => 'hotel',
            'filter' => 'festival',
            'content' => 'Exclusion On Double/Triple/Quad Sharing Basis.',
            'created_at' => '2022-04-24 04:33:06',
            'updated_at' => '2022-04-24 04:33:06'
        ]);

        Exclusion::create([
            'id' => 16,
            'type' => 'hotel',
            'filter' => 'festival',
            'content' => 'Exclusion activities in resort premises',
            'created_at' => '2022-04-24 04:33:19',
            'updated_at' => '2022-04-24 04:33:19'
        ]);

        Exclusion::create([
            'id' => 17,
            'type' => 'hotel',
            'filter' => 'festival',
            'content' => 'Exclusion activities in Kosi river on extra payment (river crossing, bridge falling & rappelling).',
            'created_at' => '2022-04-24 04:33:29',
            'updated_at' => '2022-04-24 04:33:29'
        ]);

        Exclusion::create([
            'id' => 18,
            'type' => 'hotel',
            'filter' => 'festival',
            'content' => 'Exclusion mentioned package will be applicable only on Indian nationals.',
            'created_at' => '2022-04-24 04:33:43',
            'updated_at' => '2022-04-24 04:33:43'
        ]);

        Exclusion::create([
            'id' => 19,
            'type' => 'safari',
            'filter' => 'gir',
            'content' => 'Exclusion members safari reporting',
            'created_at' => '2022-04-24 04:35:40',
            'updated_at' => '2022-04-24 04:35:40'
        ]);

        Exclusion::create([
            'id' => 20,
            'type' => 'safari',
            'filter' => 'gir',
            'content' => 'Exclusion Clearance of all visitors',
            'created_at' => '2022-04-24 04:35:50',
            'updated_at' => '2022-04-24 04:35:50'
        ]);

        Exclusion::create([
            'id' => 21,
            'type' => 'safari',
            'filter' => 'gir',
            'content' => 'Exclusion Guide at the time of safari',
            'created_at' => '2022-04-24 04:36:00',
            'updated_at' => '2022-04-24 04:36:00'
        ]);

        Exclusion::create([
            'id' => 22,
            'type' => 'safari',
            'filter' => 'gir',
            'content' => 'Exclusion and Experienced Driver',
            'created_at' => '2022-04-24 04:36:17',
            'updated_at' => '2022-04-24 04:36:17'
        ]);

        Exclusion::create([
            'id' => 23,
            'type' => 'safari',
            'filter' => 'jim',
            'content' => 'Exclusion members safari reporting',
            'created_at' => '2022-04-24 04:35:40',
            'updated_at' => '2022-04-24 04:35:40'
        ]);

        Exclusion::create([
            'id' => 24,
            'type' => 'safari',
            'filter' => 'jim',
            'content' => 'Exclusion Clearance of all visitors',
            'created_at' => '2022-04-24 04:35:50',
            'updated_at' => '2022-04-24 04:35:50'
        ]);

        Exclusion::create([
            'id' => 25,
            'type' => 'safari',
            'filter' => 'jim',
            'content' => 'Exclusion and Experienced Driver',
            'created_at' => '2022-04-24 04:36:17',
            'updated_at' => '2022-04-24 04:36:17'
        ]);

        Exclusion::create([
            'id' => 26,
            'type' => 'safari',
            'filter' => 'ranthambore',
            'content' => 'Exclusion members safari reporting',
            'created_at' => '2022-04-24 04:35:40',
            'updated_at' => '2022-04-24 04:35:40'
        ]);

        Exclusion::create([
            'id' => 27,
            'type' => 'safari',
            'filter' => 'ranthambore',
            'content' => 'Exclusion Clearance of all visitors',
            'created_at' => '2022-04-24 04:35:50',
            'updated_at' => '2022-04-24 04:35:50'
        ]);

        Exclusion::create([
            'id' => 28,
            'type' => 'safari',
            'filter' => 'ranthambore',
            'content' => 'Exclusion Guide at the time of safari',
            'created_at' => '2022-04-24 04:36:00',
            'updated_at' => '2022-04-24 04:36:00'
        ]);

        Exclusion::create([
            'id' => 29,
            'type' => 'safari',
            'filter' => 'ranthambore',
            'content' => 'Exclusion and Drop from nearby resorts for jungle safari',
            'created_at' => '2022-04-24 04:36:17',
            'updated_at' => '2022-04-24 04:36:17'
        ]);

        Exclusion::create([
            'id' => 30,
            'type' => 'safari',
            'filter' => 'ranthambore',
            'content' => 'Exclusion and Experienced Driver',
            'created_at' => '2022-04-24 04:41:58',
            'updated_at' => '2022-04-24 04:41:58'
        ]);

        Exclusion::create([
            'id' => 31,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Exclusion Booking Reporting',
            'created_at' => '2022-04-24 04:32:14',
            'updated_at' => '2022-04-24 04:32:14'
        ]);

        Exclusion::create([
            'id' => 32,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Exclusion Clearance',
            'created_at' => '2022-04-24 04:32:27',
            'updated_at' => '2022-04-24 04:32:27'
        ]);

        Exclusion::create([
            'id' => 33,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Exclusion as per the Booking',
            'created_at' => '2022-04-24 04:32:34',
            'updated_at' => '2022-05-30 20:47:51'
        ]);

        Exclusion::create([
            'id' => 34,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Exclusion drink on arrival',
            'created_at' => '2022-05-11 16:08:47',
            'updated_at' => '2022-05-11 16:08:47'
        ]);

        Exclusion::create([
            'id' => 35,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Exclusion use of Recreational activities in resort premises',
            'created_at' => '2022-05-11 16:09:09',
            'updated_at' => '2022-05-15 00:53:08'
        ]);

        Exclusion::create([
            'id' => 36,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Exclusion walk & bonfire (in Winter Season only)',
            'created_at' => '2022-05-11 16:09:23',
            'updated_at' => '2022-05-11 16:09:23'
        ]);

        Exclusion::create([
            'id' => 37,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Exclusion activities in Kosi river on extra payment (river crossing, bridge falling & rappelling)',
            'created_at' => '2022-05-11 16:09:37',
            'updated_at' => '2022-05-11 16:09:37'
        ]);

        Exclusion::create([
            'id' => 39,
            'type' => 'cab',
            'filter' => NULL,
            'content' => 'Exclusion Tax',
            'created_at' => '2022-05-14 18:56:10',
            'updated_at' => '2022-05-14 18:56:10'
        ]);

        Exclusion::create([
            'id' => 40,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Exclusion use of swimming pool',
            'created_at' => '2022-05-15 00:52:47',
            'updated_at' => '2022-05-15 00:52:47'
        ]);

        Exclusion::create([
            'id' => 41,
            'type' => 'tour',
            'filter' => NULL,
            'content' => 'Exclusion Fee is not Included, You have to pay on the spot INR 800.',
            'created_at' => '2022-06-14 16:53:56',
            'updated_at' => '2022-06-14 16:53:56'
        ]);

        Exclusion::create([
            'id' => 42,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Exclusion Booking Reporting',
            'created_at' => '2022-04-24 04:32:14',
            'updated_at' => '2022-04-24 04:32:14'
        ]);

        Exclusion::create([
            'id' => 43,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Exclusion Clearance',
            'created_at' => '2022-04-24 04:32:27',
            'updated_at' => '2022-04-24 04:32:27'
        ]);

        Exclusion::create([
            'id' => 44,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Exclusion as per the Booking',
            'created_at' => '2022-04-24 04:32:34',
            'updated_at' => '2022-05-30 20:47:51'
        ]);

        Exclusion::create([
            'id' => 45,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Exclusion drink on arrival',
            'created_at' => '2022-05-11 16:08:47',
            'updated_at' => '2022-05-11 16:08:47'
        ]);

        Exclusion::create([
            'id' => 46,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Exclusion use of Recreational activities in resort premises',
            'created_at' => '2022-05-11 16:09:09',
            'updated_at' => '2022-05-15 00:53:08'
        ]);

        Exclusion::create([
            'id' => 47,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Exclusion walk & bonfire (in Winter Season only)',
            'created_at' => '2022-05-11 16:09:23',
            'updated_at' => '2022-05-11 16:09:23'
        ]);

        Exclusion::create([
            'id' => 48,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Exclusion activities in Kosi river on extra payment (river crossing, bridge falling & rappelling)',
            'created_at' => '2022-05-11 16:09:37',
            'updated_at' => '2022-05-11 16:09:37'
        ]);

        Exclusion::create([
            'id' => 49,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Exclusion use of swimming pool',
            'created_at' => '2022-05-15 00:52:47',
            'updated_at' => '2022-05-15 00:52:47'
        ]);

        Exclusion::create([
            'id' => 50,
            'type' => 'package',
            'filter' => NULL,
            'content' => 'Exclusion Fee is not Included, You have to pay on the spot INR 800.',
            'created_at' => '2022-06-14 16:53:56',
            'updated_at' => '2022-06-14 16:53:56'
        ]);
    }
}
