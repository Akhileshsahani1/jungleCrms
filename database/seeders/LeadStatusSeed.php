<?php

namespace Database\Seeders;

use App\Models\LeadStatus;
use Illuminate\Database\Seeder;

class LeadStatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LeadStatus::create( [
            'id'=>1,
            'name'=>'Only Enquiry',
            'created_at'=>'2021-12-02 02:43:18',
            'updated_at'=>'2021-12-02 02:43:18'
            ] );

            LeadStatus::create( [
            'id'=>2,
            'name'=>'Call back required',
            'created_at'=>'2021-12-02 02:44:02',
            'updated_at'=>'2021-12-02 02:44:02'
            ] );

            LeadStatus::create( [
            'id'=>3,
            'name'=>'Fake Lead',
            'created_at'=>'2021-12-02 02:44:10',
            'updated_at'=>'2021-12-02 02:44:10'
            ] );

            LeadStatus::create( [
            'id'=>4,
            'name'=>'Converted',
            'created_at'=>'2021-12-02 02:44:26',
            'updated_at'=>'2021-12-02 02:44:26'
            ] );

            LeadStatus::create( [
            'id'=>5,
            'name'=>'Booked from other agent',
            'created_at'=>'2021-12-02 02:44:33',
            'updated_at'=>'2021-12-02 02:44:33'
            ] );

            LeadStatus::create( [
            'id'=>6,
            'name'=>'Price Issue',
            'created_at'=>'2021-12-02 02:44:47',
            'updated_at'=>'2021-12-02 02:44:47'
            ] );

            LeadStatus::create( [
            'id'=>7,
            'name'=>'Wrong Number',
            'created_at'=>'2021-12-02 02:44:57',
            'updated_at'=>'2021-12-02 02:44:57'
            ] );

            LeadStatus::create( [
            'id'=>8,
            'name'=>'Booked By GOVT',
            'created_at'=>'2021-12-02 02:45:07',
            'updated_at'=>'2021-12-02 02:45:07'
            ] );

            LeadStatus::create( [
            'id'=>9,
            'name'=>'Number Off',
            'created_at'=>'2021-12-02 02:45:29',
            'updated_at'=>'2021-12-02 02:45:29'
            ] );

            LeadStatus::create( [
            'id'=>10,
            'name'=>'Plan Not Confirm',
            'created_at'=>'2021-12-02 02:45:48',
            'updated_at'=>'2021-12-02 02:45:48'
            ] );

            LeadStatus::create( [
            'id'=>11,
            'name'=>'Pipeline',
            'created_at'=>'2021-12-02 02:46:00',
            'updated_at'=>'2021-12-02 02:46:00'
            ] );

            LeadStatus::create( [
            'id'=>12,
            'name'=>'Plan Changed',
            'created_at'=>'2021-12-02 02:46:08',
            'updated_at'=>'2021-12-02 02:46:08'
            ] );

            LeadStatus::create( [
            'id'=>13,
            'name'=>'Booking Slot Not Available',
            'created_at'=>'2021-12-02 02:46:17',
            'updated_at'=>'2021-12-02 02:46:17'
            ] );

            LeadStatus::create( [
            'id'=>14,
            'name'=>'Zone Not Available',
            'created_at'=>'2021-12-02 02:46:27',
            'updated_at'=>'2021-12-02 02:46:27'
            ] );

            LeadStatus::create( [
            'id'=>15,
            'name'=>'Price Checking',
            'created_at'=>'2021-12-02 02:46:42',
            'updated_at'=>'2021-12-02 02:46:42'
            ] );

            LeadStatus::create( [
            'id'=>16,
            'name'=>'Booking done with us',
            'created_at'=>'2021-12-02 02:46:52',
            'updated_at'=>'2021-12-02 02:46:52'
            ] );

            LeadStatus::create( [
            'id'=>17,
            'name'=>'Voucher Generate',
            'created_at'=>'2021-12-02 02:47:11',
            'updated_at'=>'2021-12-02 02:47:11'
            ] );

            LeadStatus::create( [
            'id'=>18,
            'name'=>'Busy',
            'created_at'=>'2021-12-02 02:47:18',
            'updated_at'=>'2021-12-02 02:47:18'
            ] );

            LeadStatus::create( [
            'id'=>19,
            'name'=>'Plan Cancelled',
            'created_at'=>'2021-12-02 02:47:27',
            'updated_at'=>'2021-12-02 02:47:27'
            ] );

            LeadStatus::create( [
            'id'=>20,
            'name'=>'Plan Not Confirm',
            'created_at'=>'2021-12-02 02:47:38',
            'updated_at'=>'2021-12-02 02:47:38'
            ] );

            LeadStatus::create( [
            'id'=>21,
            'name'=>'Not Interested',
            'created_at'=>'2021-12-02 02:47:57',
            'updated_at'=>'2021-12-02 02:47:57'
            ] );

            LeadStatus::create( [
            'id'=>22,
            'name'=>'Language Problem',
            'created_at'=>'2021-12-02 02:48:07',
            'updated_at'=>'2021-12-02 02:48:07'
            ] );

            LeadStatus::create( [
            'id'=>23,
            'name'=>'Testing module',
            'created_at'=>'2022-02-22 01:45:19',
            'updated_at'=>'2022-02-22 01:45:19'
            ] );
    }
}
