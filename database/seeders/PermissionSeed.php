<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create( [
            'id'=>1,
            'name'=>'manage-users',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:05:46',
            'updated_at'=>'2021-12-02 00:05:46'
            ] );



            Permission::create( [
            'id'=>2,
            'name'=>'manage-leads',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:05:56',
            'updated_at'=>'2021-12-02 00:05:56'
            ] );



            Permission::create( [
            'id'=>3,
            'name'=>'assign-leads',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:06:16',
            'updated_at'=>'2021-12-02 00:06:16'
            ] );



            Permission::create( [
            'id'=>4,
            'name'=>'manage-bookings',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:06:26',
            'updated_at'=>'2021-12-02 00:06:26'
            ] );



            Permission::create( [
            'id'=>5,
            'name'=>'manage-hotels',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:06:38',
            'updated_at'=>'2021-12-02 00:06:38'
            ] );



            Permission::create( [
            'id'=>6,
            'name'=>'manage-cabs',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:07:31',
            'updated_at'=>'2021-12-02 00:07:31'
            ] );



            Permission::create( [
            'id'=>7,
            'name'=>'manage-tours',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:07:48',
            'updated_at'=>'2021-12-02 00:07:48'
            ] );



            Permission::create( [
            'id'=>8,
            'name'=>'manage-safari-bookings',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:08:06',
            'updated_at'=>'2021-12-02 00:08:06'
            ] );



            Permission::create( [
            'id'=>9,
            'name'=>'manage-customers',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 00:08:35',
            'updated_at'=>'2021-12-02 00:08:35'
            ] );



            Permission::create( [
            'id'=>10,
            'name'=>'manage-lead-status',
            'guard_name'=>'web',
            'created_at'=>'2021-12-02 03:08:16',
            'updated_at'=>'2021-12-02 03:08:16'
            ] );
    }
}
