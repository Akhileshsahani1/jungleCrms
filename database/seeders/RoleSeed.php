<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create( [
            'id'=>1,
            'name'=>'administrator',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:09:41',
            'updated_at'=>'2021-12-02 00:09:41'
            ] );



            Role::create( [
            'id'=>2,
            'name'=>'staff',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:10:17',
            'updated_at'=>'2021-12-02 00:10:17'
            ] );



            Role::create( [
            'id'=>3,
            'name'=>'team-lead',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:10:54',
            'updated_at'=>'2021-12-02 00:11:43'
            ] );



            Role::create( [
            'id'=>4,
            'name'=>'agent',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:12:03',
            'updated_at'=>'2021-12-02 00:12:03'
            ] );



            Role::create( [
            'id'=>5,
            'name'=>'fresher',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:13:37',
            'updated_at'=>'2021-12-02 00:13:37'
            ] );



            Role::create( [
            'id'=>6,
            'name'=>'dailytourandtravel.com',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:14:30',
            'updated_at'=>'2021-12-02 00:14:30'
            ] );



            Role::create( [
            'id'=>7,
            'name'=>'dailytravel.com',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:15:17',
            'updated_at'=>'2021-12-02 00:15:17'
            ] );



            Role::create( [
            'id'=>8,
            'name'=>'travelwalacab.com',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:16:02',
            'updated_at'=>'2021-12-02 00:16:02'
            ] );



            Role::create( [
            'id'=>9,
            'name'=>'bandhavgarh.com',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:16:17',
            'updated_at'=>'2021-12-02 00:16:17'
            ] );



            Role::create( [
            'id'=>10,
            'name'=>'girlion.in',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:16:32',
            'updated_at'=>'2021-12-02 00:16:32'
            ] );



            Role::create( [
            'id'=>11,
            'name'=>'girlionsafari.com',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:16:43',
            'updated_at'=>'2021-12-02 00:16:43'
            ] );



            Role::create( [
            'id'=>12,
            'name'=>'jimcorbett.in',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:16:54',
            'updated_at'=>'2021-12-02 00:16:54'
            ] );



            Role::create( [
            'id'=>13,
            'name'=>'girsafaribooking.com',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:17:09',
            'updated_at'=>'2021-12-02 00:17:09'
            ] );



            Role::create( [
            'id'=>14,
            'name'=>'jimcorbettnationalparkonline.in',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:22:27',
            'updated_at'=>'2021-12-02 00:22:27'
            ] );



            Role::create( [
            'id'=>15,
            'name'=>'ranthamboretigerreserve.in',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:23:13',
            'updated_at'=>'2021-12-02 00:23:13'
            ] );
    }
}
