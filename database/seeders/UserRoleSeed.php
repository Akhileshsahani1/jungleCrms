<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('model_has_roles')->delete();

        DB::table('model_has_roles')->insert(array(
            0 =>
            array(
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 2,
            ),
            1 =>
            array(
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            2 =>
            array(
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            3 =>
            array(
                'role_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            4 =>
            array(
                'role_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            5 =>
            array(
                'role_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 11,
            ),
            6 =>
            array(
                'role_id' => 10,
                'model_type' => 'App\\Models\\User',
                'model_id' => 6,
            ),
            7 =>
            array(
                'role_id' => 10,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            8 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            9 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 6,
            ),
            10 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 7,
            ),
            11 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 13,
            ),
            12 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            13 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            14 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            15 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            16 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            17 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            18 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            19 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            20 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            21 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            22 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            23 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            24 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            25 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            26 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            27 =>
            array(
                'role_id' => 11,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            28 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            29 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 5,
            ),
            30 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 12,
            ),
            31 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            32 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            33 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            34 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            35 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            36 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            37 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            38 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            39 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            40 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 59,
            ),
            41 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            42 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            43 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            44 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            45 =>
            array(
                'role_id' => 12,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            46 =>
            array(
                'role_id' => 13,
                'model_type' => 'App\\Models\\User',
                'model_id' => 6,
            ),
            47 =>
            array(
                'role_id' => 14,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            48 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            49 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 2,
            ),
            50 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            51 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 4,
            ),
            52 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 9,
            ),
            53 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 10,
            ),
            54 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            55 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            56 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            57 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            58 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            59 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            60 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            61 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            62 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 48,
            ),
            63 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            64 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            65 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            66 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            67 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            68 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            69 =>
            array(
                'role_id' => 15,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
        ));
    }
}
