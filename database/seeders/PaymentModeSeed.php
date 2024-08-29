<?php

namespace Database\Seeders;

use App\Models\PaymentMode;
use Illuminate\Database\Seeder;

class PaymentModeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMode::create([
            'id' => 1,
            'name' => 'Jungle Safari Bank Details',
            'mode' => 'offline',
            'details' => [
                "account_holder_name" => "JUNGLE SAFARI INDIA", 
                "account_number" => "9246475627", 
                "ifsc_code" => "KKBK0005292", 
                "account_type" => "current", 
                "bank_name" => "Kotak Mahindra Bank"
            ],
            'status' => '1',
            'created_at' => '2022-04-23 08:00:49',
            'updated_at' => '2022-04-23 08:00:49'
        ]);             

        PaymentMode::create([
            'id' => 2,
            'name' => 'JSI Razorpay',
            'mode' => 'razorpay',
            'details' => [
                "razorpay_key" => "rzp_live_MxDMgEZLYl8qkG", 
                "razorpay_secret_key" => "3DvcpBTw7qkQIA0rNXM5MTsX"],
            'status' => '1',
            'created_at' => '2022-04-23 08:00:49',
            'updated_at' => '2022-04-23 08:00:49'
        ]);

        PaymentMode::create([
            'id' => 3,
            'name' => 'JSI Kotak UPI',
            'mode' => 'upi',
            'details' => ["upi_id" => "junglesafari360-3@okhdfcbank"],
            'status' => '1',
            'created_at' => '2022-04-23 08:00:49',
            'updated_at' => '2022-04-23 08:00:49'
        ]);

        // PaymentMode::create([
        //     'id' => 4,
        //     'name' => 'JSI Razorpay',
        //     'mode' => 'razorpay',
        //     'details' => [
        //         "razorpay_key" => "rzp_test_FvMwf7j3FOOnh8", 
        //         "razorpay_secret_key" => "vGHpxOQsTjDLdYsAiqYi0S5m"],
        //     'status' => '1',
        //     'created_at' => '2022-04-23 08:00:49',
        //     'updated_at' => '2022-04-23 08:00:49'
        // ]);
    }
}
