<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => 'Abhishek Sinha',
            'email' => 'abhisheksubi@gmail.com',
            'phone' => '8130717976',
            'avatar' => NULL,
            'leads_per_day' => 999,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$dwIOqeR3gXcPUbmRoCWrjuRIq3dksOBvoEEdebG4AGtIMv2BAYpym',
            'is_active' => 0,
            'remember_token' => 'ejEsuhuZZMVYevTZkjlhvdpE9yAacKG7OGGxYSIUgFPDgIi3BfWMN8Ry7d9b',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-02-12 17:17:11'
        ]);

        User::create([
            'id' => 2,
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'phone' => '9971717045',
            'avatar' => NULL,
            'leads_per_day' => 999,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => Hash::make('password'),
            'is_active' => 1,
            'remember_token' => 'vFwG8tuHI1JHh3EPkSxXQOzCriqNShOkuiish4oD5Rc2Akb45VhRDAJghmu7',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-02-13 13:30:42'
        ]);

        User::create([
            'id' => 3,
            'name' => 'Arvind',
            'email' => 'bonishbrade@gmail.com',
            'phone' => '9354516643',
            'avatar' => NULL,
            'leads_per_day' => 999,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$10HU/3mn46HKfHuPXM1p4e5EE7DzTjc6vrJT/aT9knRCn6rjqVOvW',
            'is_active' => 0,
            'remember_token' => 'kH2NOg2uTzXgt5chLFD78IcRvQ4XEMqvhGFITkuA5M093K1QRDo5bFXv5jMT',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-02-12 17:16:59'
        ]);

        User::create([
            'id' => 4,
            'name' => 'Abhishek Corbett',
            'email' => 'jimcorbett360@gmail.com',
            'phone' => '0000000000',
            'avatar' => NULL,
            'leads_per_day' => 999,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$mAJI9YTQzDz7tWwcpzdDcOFO7wVX2og7EDBnUa/lbnl7CLC7bFhL.',
            'is_active' => 0,
            'remember_token' => 'ZEE6SHHoXi',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2022-08-23 17:48:57'
        ]);

        User::create([
            'id' => 5,
            'name' => 'Neha Prajapati',
            'email' => 'nehaprajapati@junglesafariindia.in',
            'phone' => '9971268452',
            'avatar' => NULL,
            'leads_per_day' => 999,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$PNHf8Ln11bPeAuVafsh8Z.WIDCgX3YL2PgLXiFUZaagsj4lQBc2OK',
            'is_active' => 1,
            'remember_token' => 'MxAmqtwPsj8PQp791SFrYv4FrMMmzKf9Y0pQlxIrytx6S6UOQkVrzYtUFDf0',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-03-30 11:16:42'
        ]);

        User::create([
            'id' => 6,
            'name' => 'Ajay',
            'email' => 'contact@girlion.in',
            'phone' => '9953686128',
            'avatar' => NULL,
            'leads_per_day' => 50,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$cdCDBz3Q.7mCvx7GIcNPyeI25xBDxrSfCcN8oH4mwQM7tglMD/BR.',
            'is_active' => 1,
            'remember_token' => 'walYwMXBuGta2ZS6flovO0yqdk8muzxe1czVPC5ZsDWJ2X1xX63tVa36c7de',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-03-30 11:16:12'
        ]);

        User::create([
            'id' => 7,
            'name' => 'Sohan',
            'email' => 'sohanveer@girlionsafari.com',
            'phone' => '9958292240',
            'avatar' => NULL,
            'leads_per_day' => 10,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$ZZRHYQPgv7TnDOJ/RvmvoeNy.2pIQW/lpVnAOjVbOLaNiSTbAWMGe',
            'is_active' => 1,
            'remember_token' => '0ZONxdpiQB9VbVyV32e498WO36d9j5eLClVx8MqBkAqfy2pHA9BywByUHN02',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-02-23 15:04:08'
        ]);

        User::create([
            'id' => 9,
            'name' => 'Shadab',
            'email' => 'shadab@ranthamboretigerreserve.in',
            'phone' => '9718717119',
            'avatar' => NULL,
            'leads_per_day' => 80,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$YrVinFhnFSEohZ5uUM4quOK0anAv.DVgRA3sG8CCwAt9ikXnKWtYC',
            'is_active' => 1,
            'remember_token' => 'uyuO5QaJdxNWOW8W6tTjb0djHTEojdDKoYoMzCx7HhVLpQY5o1Ribrn3wMzb',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-04-04 16:18:21'
        ]);

        User::create([
            'id' => 10,
            'name' => 'Manoj',
            'email' => 'manojsinhabgp@gmail.com',
            'phone' => '9971717039',
            'avatar' => NULL,
            'leads_per_day' => 999,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$qnBZfRsD2t4nDgBghrj.cOxfg0YoFM86XKfLpLoyv9lV4DLQdXes.',
            'is_active' => 0,
            'remember_token' => 'Q5eGJeHDbxpmbNgbaI7qGqvSKT16N5rOVS9zmUsk2OynfQFwAM9GIGeUhtOB',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-02-12 17:15:29'
        ]);

        User::create([
            'id' => 11,
            'name' => 'Govind',
            'email' => 'govind@jimcorbett.in',
            'phone' => '0000000000',
            'avatar' => NULL,
            'leads_per_day' => 15,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$FwTK4gAHhjftB7/vp6gW.On363DKiap8kvX4qCAiZ0/jOKi8f.zBa',
            'is_active' => 0,
            'remember_token' => 'FDdcMjveRxva7M8vScpY5oLtvny9kHkh8z5NBPDu8tGxgdUFqcSwA8LHomCO',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2022-09-19 15:09:48'
        ]);

        User::create([
            'id' => 12,
            'name' => 'Neha',
            'email' => 'neha@jimcorbett.in',
            'phone' => '0000000',
            'avatar' => NULL,
            'leads_per_day' => 69,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$zcY1fMfr6x2IghTlhxlGyOCLrb0kB73lqR8bgUFGtAjVPzZjAbxE.',
            'is_active' => 0,
            'remember_token' => 'LyiGFRYOq0LcprItUEUlEP188NW5nzrtsjYMFOfjyW1DQHcepxyqIcEtzYzP',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-02-20 12:08:47'
        ]);

        User::create([
            'id' => 13,
            'name' => 'Monika Joshi',
            'email' => 'monika@girlionsafari.com',
            'phone' => '00000000',
            'avatar' => NULL,
            'leads_per_day' => 32,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$GvVGuIl3pTIgvXX7T4tkF.z0vfJnW8mxMpFCPv5qglxpiahFCVnzS',
            'is_active' => 0,
            'remember_token' => 'QwXVAShP8WsARCsBKD5y5ebMWhCp09DNH3aoN80w0Oev5cBsAQcz13lnG1sd',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-02-12 17:12:33'
        ]);

        User::create([
            'id' => 14,
            'name' => 'Payal',
            'email' => 'payal@ranthamboretigerreserve.in',
            'phone' => '8527518718',
            'avatar' => NULL,
            'leads_per_day' => 65,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$..ySNSJRKCeKfyMBzxR4kOQ3xP6HuTXLLbrfAgI2UrWYicUW37ocS',
            'is_active' => 1,
            'remember_token' => 'N46pJy6Gb0t2iahRE5soHcl8xXm7hqMrFvWDF5e587asnbm7e7BZq0vTVK3Z',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-04-07 17:30:11'
        ]);

        User::create([
            'id' => 15,
            'name' => 'Ifra Malik',
            'email' => 'ifra@jimcorbett.in',
            'phone' => '0000000000',
            'avatar' => NULL,
            'leads_per_day' => 45,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$hqvMuX7nD0z8itWR20sZZuRKX4Wpczmt2OQr1dINJf43PVXerVemi',
            'is_active' => 0,
            'remember_token' => 'YPGpUuIOFBREFTLpCVqM8WRIYKnKBSLqZYC9n9pa6hdXWnAPhidNs2QNjTQX',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2022-12-14 13:37:23'
        ]);

        User::create([
            'id' => 16,
            'name' => 'Rohit',
            'email' => 'rohit@ranthamboretigerreserve.in',
            'phone' => '7289842772',
            'avatar' => NULL,
            'leads_per_day' => 60,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$JOW4D0tEdxXQsMTKzXYJeOybs/rTb4KnKywpN54pzyRC/RPajjhPu',
            'is_active' => 1,
            'remember_token' => '3cW4eafjdaWWYJ6EMdgyh7rRjVBzvDGpSu5F2va9n7ObcSsFDUEmPATAySN8',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-03-30 11:14:57'
        ]);

        User::create([
            'id' => 17,
            'name' => 'Maneesha Joshi',
            'email' => 'maneesha@jimcorbett.in',
            'phone' => '0000000000',
            'avatar' => NULL,
            'leads_per_day' => 35,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$./mUfE6oi5W5aJJD2AU8eeRezfc5UGQ.BpSFufXj9kcB3IlEY3Epi',
            'is_active' => 0,
            'remember_token' => 'hiBeXGcgsHQdIudUfYqnXOk5MRDd90NM0VUY6UETIb199EJ9HI20rwmSa6OS',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-02-12 17:17:46'
        ]);

        User::create([
            'id' => 19,
            'name' => 'Vivek Tiwari',
            'email' => 'vivek@girlionsafari.com',
            'phone' => '9821798148',
            'avatar' => NULL,
            'leads_per_day' => 20,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$rBlgoTdX.EDuT2/4dXUYeOpF/Zlv3ID3vbRX/2MPbKBgLL2BCBXa.',
            'is_active' => 1,
            'remember_token' => 'IpgGgFuFx3RwmnzMidXIZSSYRhudxumSbjqApK8GroaXGqcRAs5iHDe4gzls',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-03-30 11:14:28'
        ]);

        User::create([
            'id' => 20,
            'name' => 'Vaishnavi Ranthambore',
            'email' => 'vaishnavi@ranthamboretigerreserve.in',
            'phone' => '888888888',
            'avatar' => NULL,
            'leads_per_day' => 50,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$Mb4s6UIIyP/Lsr9af2I/feWJczyEVayfGBUOoCkFXzNflnGUh1zfC',
            'is_active' => 0,
            'remember_token' => '40MbhH7LtOlntC52da0X7W0h8JiZIjJpnnwsggqTKUrS79nFmOr6QOU85CgY',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2022-08-23 17:44:58'
        ]);

        User::create([
            'id' => 21,
            'name' => 'Sushil Ranthabore',
            'email' => 'sushil@ranthamboretigerreserve.in',
            'phone' => NULL,
            'avatar' => NULL,
            'leads_per_day' => 999,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$vrxZRziNdkCJDI0EZ5rrmuoC6RHVuYbkV9MjVCjkeVPgFSX9US4ZS',
            'is_active' => 1,
            'remember_token' => 'ryWNKkBKEo',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2022-05-09 11:41:03'
        ]);

        User::create([
            'id' => 22,
            'name' => 'Rahul',
            'email' => 'rahul@girlionsafari.com',
            'phone' => '7834942435',
            'avatar' => NULL,
            'leads_per_day' => 20,
            'email_verified_at' => '2021-12-02 00:00:28',
            'password' => '$2y$10$Ck9PsO5ySjMdCJy4G9BPQO3lKeZaq1TclpImylSV3ZqN9rdxowl0e',
            'is_active' => 1,
            'remember_token' => 'gl87nM9MvAJtshg70JJv6gPRQqjSyuJ6Bn5PJLN3lxVmJzlyhRuukBgHjtPp',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-04-25 17:33:05'
        ]);

        User::create([
            'id' => 24,
            'name' => 'Mahira',
            'email' => 'mahira@girlionsafari.com',
            'phone' => '8920774519',
            'avatar' => NULL,
            'leads_per_day' => 36,
            'email_verified_at' => NULL,
            'password' => '$2y$10$87sGhD/AytLordZyWx0iku6h/8KshkF6dKJC1kaA5s/b/a4gq5ICO',
            'is_active' => 1,
            'remember_token' => 'z1nwkKxpcUnf0fsBFgadRiwtT4MBvzyMp7FlauVexIQWOB0JqZD2fFXlxlfF',
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2023-03-30 11:13:45'
        ]);

        User::create([
            'id' => 25,
            'name' => 'Arun Prakash Gautam',
            'email' => 'arun@girlionsafari.com',
            'phone' => '0000000000',
            'avatar' => NULL,
            'leads_per_day' => 20,
            'email_verified_at' => NULL,
            'password' => '$2y$10$2Cl.kd9llHralZZ3cWvUS.wbOQyzvfCXglo0RZQXWZ1dvMwdaQMKW',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2022-10-06 13:34:54'
        ]);

        User::create([
            'id' => 26,
            'name' => 'Priti',
            'email' => 'priti@dailytourandtravel.com',
            'phone' => '0000000000',
            'avatar' => NULL,
            'leads_per_day' => 999,
            'email_verified_at' => NULL,
            'password' => '$2y$10$wsEtGTrICy5I5weGhWqlFed2pxs17axtPjEZoOGO8xGuVekr0yvvC',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2022-05-09 11:41:03',
            'updated_at' => '2022-09-19 15:03:31'
        ]);

        User::create([
            'id' => 31,
            'name' => 'Sarika HR',
            'email' => 'hr@junglesafariindia.in',
            'phone' => '9821766412',
            'avatar' => NULL,
            'leads_per_day' => 1000,
            'email_verified_at' => NULL,
            'password' => '$2y$10$sdd8D1oIX8kWywIshJpaF..sDCJWXziAu7pVsVKKYzQIT/bL8o2SW',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-09-01 13:01:15',
            'updated_at' => '2023-02-13 10:33:34'
        ]);

        User::create([
            'id' => 32,
            'name' => 'Pankaj',
            'email' => 'pankaj@junglesafariindia.in',
            'phone' => '8929841422',
            'avatar' => NULL,
            'leads_per_day' => 10,
            'email_verified_at' => NULL,
            'password' => '$2y$10$dNJghkFMEDR4DbpagCKzzOQRDaFpJBiW9rOaD6ndgMAqcXayQCE.e',
            'is_active' => 0,
            'remember_token' => '9XaFBTPLU7CbILwrnRCtMEx68ORk27JvY7XXHf5rc9BIg7p8Ed9xKGz9juuw',
            'created_at' => '2022-09-01 13:26:19',
            'updated_at' => '2023-02-12 17:12:16'
        ]);

        User::create([
            'id' => 33,
            'name' => 'Monu Chaudhary',
            'email' => 'monu@junglesafariindia.in',
            'phone' => '9953873986',
            'avatar' => NULL,
            'leads_per_day' => 40,
            'email_verified_at' => NULL,
            'password' => '$2y$10$YRSXuHCA1OtJSrgrtmlvuurbA1nskO9T/2ItzIrvTKSrOAkoifLma',
            'is_active' => 0,
            'remember_token' => 'QWt7Qb2GY3uew1nRBpWnQAj0CL8ML8dj6J6aNQ0ztdo1EHichbAn15KUNzEX',
            'created_at' => '2022-09-01 13:28:18',
            'updated_at' => '2023-02-12 17:12:06'
        ]);

        User::create([
            'id' => 34,
            'name' => 'Mansa Negi',
            'email' => 'mansa@girlionsafari.com',
            'phone' => '000000000000000',
            'avatar' => NULL,
            'leads_per_day' => 29,
            'email_verified_at' => NULL,
            'password' => '$2y$10$p6MLdjKJofBmweC6cm.8JukvhklSl51fsH0IRm3/SXImiUtB4lyBi',
            'is_active' => 0,
            'remember_token' => 'EWtxzM0fGfZkfYKB3uFKD7wFCWDaghetChO0eENjBgQjcue66X9ZXautSsam',
            'created_at' => '2022-09-14 10:17:35',
            'updated_at' => '2023-02-25 11:41:01'
        ]);

        User::create([
            'id' => 35,
            'name' => 'Shyam Tripathi',
            'email' => 'Shyam2@jimcorbett.in',
            'phone' => '9582038720',
            'avatar' => NULL,
            'leads_per_day' => 50,
            'email_verified_at' => NULL,
            'password' => '$2y$10$k2TeO9.vHwRf2HiafxvmKeOwud9Hyj1nnDnMXg862bRkhq6Jky7Eu',
            'is_active' => 1,
            'remember_token' => 'Tpa0nEaImETZr7Fn5jtFlqLS7lwOCu1oQFWt4Dk1Xbmv4LN9ydXdbZRzKNrp',
            'created_at' => '2022-09-15 11:03:40',
            'updated_at' => '2023-04-06 12:08:59'
        ]);

        User::create([
            'id' => 36,
            'name' => 'Neha Ranthambore',
            'email' => 'neha@ranthamboretigerreserve.in',
            'phone' => '0000000000',
            'avatar' => NULL,
            'leads_per_day' => 10,
            'email_verified_at' => NULL,
            'password' => '$2y$10$L3ncGd0yOFc6ZSTadKqiA.cn0/.G.4nt0kUwi.LCDm3AId1kOZySO',
            'is_active' => 0,
            'remember_token' => '8LZweyYt0xPDrCHejOB1ZIATkEgKGSyv5fxl2qON7NM8Y10MOavQXxuooCDy',
            'created_at' => '2022-09-17 11:42:01',
            'updated_at' => '2023-02-12 13:05:25'
        ]);

        User::create([
            'id' => 37,
            'name' => 'Mr. Dev',
            'email' => 'dev@jimcorbett.in',
            'phone' => '0000000000',
            'avatar' => NULL,
            'leads_per_day' => 30,
            'email_verified_at' => NULL,
            'password' => '$2y$10$d/0/9WZVF1Dy.ma8ejtooO77LMZXiVqMuXvhJCCG9xaWLjKXvpSq6',
            'is_active' => 0,
            'remember_token' => 'noctl5LIDAPbtU4m2GHtirmHsrMKt2WwyGphmmbuuvQAvHOCHRG3Nx2jx5Ij',
            'created_at' => '2022-09-17 11:43:59',
            'updated_at' => '2023-02-12 13:05:17'
        ]);

        User::create([
            'id' => 38,
            'name' => 'Shyam',
            'email' => 'Shyam@jimcorbett.in',
            'phone' => '7303929404',
            'avatar' => NULL,
            'leads_per_day' => 50,
            'email_verified_at' => NULL,
            'password' => '$2y$10$GShRyzgsmTSNu.KlPdw2wOCdGG4/BsJXQvxb4HZHhDkaOvJ2VHXZC',
            'is_active' => 1,
            'remember_token' => '8WkBe8YhUnTlOgjG54PCYbPs1KkuaTBsV1QFWAuezKbSjsXeJlssLCT11rGe',
            'created_at' => '2022-09-17 11:45:21',
            'updated_at' => '2023-04-06 12:09:26'
        ]);

        User::create([
            'id' => 39,
            'name' => 'Md Kasim',
            'email' => 'kasim@ranthamboretigerreserve.in',
            'phone' => '8076130028',
            'avatar' => NULL,
            'leads_per_day' => 40,
            'email_verified_at' => NULL,
            'password' => '$2y$10$cmA70rc8rlodz4Xoj7skQu1Pg8feDRiZhB4adLKB4qLXanXt/fkXe',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-10-04 11:25:38',
            'updated_at' => '2023-03-06 16:13:59'
        ]);

        User::create([
            'id' => 40,
            'name' => 'Munna',
            'email' => 'munna@ranthamboretigerreserve.in',
            'phone' => '0000000',
            'avatar' => NULL,
            'leads_per_day' => 10,
            'email_verified_at' => NULL,
            'password' => '$2y$10$SiXPyJYG0kKxb7qVNpmcOOAosmdMOJ81EtbQJitlGQjltTOyF5uWC',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2022-10-05 13:10:32',
            'updated_at' => '2023-02-12 13:04:46'
        ]);

        User::create([
            'id' => 41,
            'name' => 'Niharika',
            'email' => 'niharika@girlionsafari.com',
            'phone' => '9582010443',
            'avatar' => NULL,
            'leads_per_day' => 0,
            'email_verified_at' => NULL,
            'password' => '$2y$10$JTqtmrQpvx3DBwsS1nK65OpxKg2HhM2YiX2TTnOUihfN3gTKPC3iu',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2022-10-06 13:36:02',
            'updated_at' => '2023-02-12 13:04:37'
        ]);

        User::create([
            'id' => 42,
            'name' => 'Vishal Kumar',
            'email' => 'vishal@girlionsafari.com',
            'phone' => '9818289779',
            'avatar' => NULL,
            'leads_per_day' => 8,
            'email_verified_at' => NULL,
            'password' => '$2y$10$h0hhU.VmSlDvdzWu3TuJ..lrFT5ri81DiCJkkmaNL.hadzEFiqQF.',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2022-10-09 16:28:51',
            'updated_at' => '2023-02-12 13:04:27'
        ]);

        User::create([
            'id' => 43,
            'name' => 'Preeti Rajput',
            'email' => 'preeti@girlionsafari.com',
            'phone' => '999999999',
            'avatar' => NULL,
            'leads_per_day' => 5,
            'email_verified_at' => NULL,
            'password' => '$2y$10$6j7pncrX/CsWWbiw.ZXxWOM3AcjtW6eRRu.cIwLX.ww0HTDNteEYm',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2022-10-10 15:35:40',
            'updated_at' => '2023-04-09 10:59:21'
        ]);

        User::create([
            'id' => 44,
            'name' => 'Harsh Gupta',
            'email' => 'Harsh@girlionsafari.com',
            'phone' => '9643656606',
            'avatar' => NULL,
            'leads_per_day' => 8,
            'email_verified_at' => NULL,
            'password' => '$2y$10$LoXYL5fzy8B8i6ZBIObJc.sQWayzj7pbxVL6ouluJ6usp6iTss5nS',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-10-11 15:00:42',
            'updated_at' => '2023-03-01 13:14:20'
        ]);

        User::create([
            'id' => 45,
            'name' => 'Jyoti Sharma',
            'email' => 'jyoti@ranthamboretigerreserve.in',
            'phone' => '8929798684',
            'avatar' => NULL,
            'leads_per_day' => 20,
            'email_verified_at' => NULL,
            'password' => '$2y$10$7LVK1WJdHdHnRwfBMPFw1ucw1XALWTdozzcGlSwwLtKEuLhLY4.CK',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-10-14 11:03:18',
            'updated_at' => '2023-04-25 17:32:20'
        ]);

        User::create([
            'id' => 46,
            'name' => 'Mahi',
            'email' => 'mahi@girlionsafari.com',
            'phone' => '000000000',
            'avatar' => NULL,
            'leads_per_day' => 0,
            'email_verified_at' => NULL,
            'password' => '$2y$10$MzpERuy1aOu17ByEMlfiQuB8mbQc/I55Y991gBDag1fickyuEliV.',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2022-10-16 10:47:34',
            'updated_at' => '2023-02-12 13:03:55'
        ]);

        User::create([
            'id' => 47,
            'name' => 'Vaishnavi',
            'email' => 'vaishnavi@girlionsafari.com',
            'phone' => '7291023547',
            'avatar' => NULL,
            'leads_per_day' => 20,
            'email_verified_at' => NULL,
            'password' => '$2y$10$RUXEBggwtRWlbLEVJDiUj.2cCtFQkDmxvSGAtiw1um78lOVk8uq4S',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-10-18 10:39:06',
            'updated_at' => '2023-04-25 17:32:43'
        ]);

        User::create([
            'id' => 48,
            'name' => 'Neha Kumari',
            'email' => 'nehakumari@ranthamboretigerreserve.in',
            'phone' => '00000000',
            'avatar' => NULL,
            'leads_per_day' => 15,
            'email_verified_at' => NULL,
            'password' => '$2y$10$sVie53ziSUW34W38x.KMAOJc714bmnVFbHa7lOZrTjGjF38DQj2K2',
            'is_active' => 1,
            'remember_token' => 'xxId8B49nQyLQSkWq8b1SUNflPHQbkdcnXVJdyuB3IFzSxk2x1CnYuiCBdYB',
            'created_at' => '2022-10-25 11:25:59',
            'updated_at' => '2023-04-11 11:15:15'
        ]);

        User::create([
            'id' => 49,
            'name' => 'Arun Kumar',
            'email' => 'arun@ranthamboretigerreserve.in',
            'phone' => '00000000000',
            'avatar' => NULL,
            'leads_per_day' => 20,
            'email_verified_at' => NULL,
            'password' => '$2y$10$/bbx7a3Hsuo9PC18MGOTPex5OwVWX1JL07L8Z1POLGmqVbPxHLDqS',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2022-10-25 12:45:02',
            'updated_at' => '2023-02-12 13:03:37'
        ]);

        User::create([
            'id' => 50,
            'name' => 'Pankaj Yadav',
            'email' => 'pankajyadav@ranthamboretigerreserve.in',
            'phone' => '9289725560',
            'avatar' => NULL,
            'leads_per_day' => 5,
            'email_verified_at' => NULL,
            'password' => '$2y$10$Lp4AHju63pgdTuFLs0Fx.O7n3IOEO.Uz9.A36eG.NRNvt8M2m3/my',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2022-10-25 12:56:41',
            'updated_at' => '2023-02-12 13:03:31'
        ]);

        User::create([
            'id' => 51,
            'name' => 'Umesh',
            'email' => 'umesh@jimcorbett.in',
            'phone' => '9953680729',
            'avatar' => NULL,
            'leads_per_day' => 50,
            'email_verified_at' => NULL,
            'password' => Hash::make('password'),
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-10-26 11:33:15',
            'updated_at' => '2023-04-06 12:08:47'
        ]);

        User::create([
            'id' => 53,
            'name' => 'Rishab',
            'email' => 'rishab@girlionsafari.com',
            'phone' => '9582010308',
            'avatar' => NULL,
            'leads_per_day' => 10,
            'email_verified_at' => NULL,
            'password' => '$2y$10$HDm8lY3UMBx52wLAUQhB7OCXi5GdTPo92vElUKl7DILparchkyyoi',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2022-11-01 11:55:14',
            'updated_at' => '2023-02-12 13:03:14'
        ]);

        User::create([
            'id' => 54,
            'name' => 'Simran',
            'email' => 'Simran@jimcorbett.in',
            'phone' => '8527234115',
            'avatar' => NULL,
            'leads_per_day' => 50,
            'email_verified_at' => NULL,
            'password' => '$2y$10$xH5MHZUlrWwO/3O3qLM44e4SFnOpLRuL.ngDS32FeaiD105A0wnXO',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-11-06 11:06:47',
            'updated_at' => '2023-04-05 17:16:04'
        ]);

        User::create([
            'id' => 55,
            'name' => 'Rakesh Kohli',
            'email' => 'rakeshkohli@junglesafariindia.in',
            'phone' => '0000000000',
            'avatar' => NULL,
            'leads_per_day' => 0,
            'email_verified_at' => NULL,
            'password' => '$2y$10$X/8mtAT1njJfRI7WPWEKAet1Rp4yYtFfMtTFqwT9wEqrK54MKck4.',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2022-11-07 13:32:08',
            'updated_at' => '2023-02-12 13:02:55'
        ]);

        User::create([
            'id' => 56,
            'name' => 'Sakshi',
            'email' => 'sakshi@junglesafariindia.in',
            'phone' => '8376009662',
            'avatar' => NULL,
            'leads_per_day' => 20,
            'email_verified_at' => NULL,
            'password' => '$2y$10$QyrytLhfk.Fy/jcKUduFaOqC.868vjskvE7q.V0CkIxkLXDeteSh2',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-11-07 13:34:58',
            'updated_at' => '2023-04-23 12:12:49'
        ]);

        User::create([
            'id' => 57,
            'name' => 'Shivani Poddar',
            'email' => 'shivani@junglesafariindia.in',
            'phone' => '8527345820',
            'avatar' => NULL,
            'leads_per_day' => 20,
            'email_verified_at' => NULL,
            'password' => '$2y$10$YWfr74/sWJlX3YJt49PVz.wZ2i30kWXGLBkR3S.CcSEAFEXYVOB32',
            'is_active' => 1,
            'remember_token' => 'UgBdrb53Ee5w8uApwhaGT6bqDcgy0kTMydDO5KG81G8zKLrViQdRKXjqix2T',
            'created_at' => '2022-11-07 13:39:37',
            'updated_at' => '2023-04-23 12:13:18'
        ]);

        User::create([
            'id' => 58,
            'name' => 'Dashrath',
            'email' => 'dashrath@ranthamboretigerreserve.in',
            'phone' => '8595134924',
            'avatar' => NULL,
            'leads_per_day' => 40,
            'email_verified_at' => NULL,
            'password' => '$2y$10$m6KGsgSeSv6SXgz.xnK7Gej6fGQM/YfyLxOhxe5X19JJdi5pwb09u',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-11-08 15:26:15',
            'updated_at' => '2023-03-03 17:51:23'
        ]);

        User::create([
            'id' => 59,
            'name' => 'Farheen',
            'email' => 'Shreya1@jimcorbett.in',
            'phone' => '9871972857',
            'avatar' => NULL,
            'leads_per_day' => 50,
            'email_verified_at' => NULL,
            'password' => '$2y$10$zjB/2bSegCgIabHgbrhy5e3aGH.ioTEr/JydJAZi5TRKTtWChlEAK',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-11-10 13:06:00',
            'updated_at' => '2023-04-06 12:08:22'
        ]);

        User::create([
            'id' => 60,
            'name' => 'SIMRAH',
            'email' => 'na@gmail.com',
            'phone' => '9971965629',
            'avatar' => NULL,
            'leads_per_day' => 100,
            'email_verified_at' => NULL,
            'password' => '$2y$10$.w7wx1l8YNchDI7I87DcFuwp9L2/t8gaew91AU6V4AUZLYp7W5AIy',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-11-13 12:10:06',
            'updated_at' => '2023-04-04 16:18:35'
        ]);

        User::create([
            'id' => 61,
            'name' => 'Simran Rajput',
            'email' => 'Simranrajput@jimcorbett.in',
            'phone' => '7303598684',
            'avatar' => NULL,
            'leads_per_day' => 50,
            'email_verified_at' => NULL,
            'password' => '$2y$10$p0THRec0uv8Arfz3vgY1BeHVNCVf3JJLyZ3MfKpjVH/knzGAyzU8a',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-12-09 12:14:46',
            'updated_at' => '2023-04-05 17:15:40'
        ]);

        User::create([
            'id' => 62,
            'name' => 'Diwanshu',
            'email' => 'Diwanshu@ranthamboretigerreserve.in',
            'phone' => '9560847356',
            'avatar' => NULL,
            'leads_per_day' => 100,
            'email_verified_at' => NULL,
            'password' => '$2y$10$UlzH5bKNaQZDDVOfUTtmvOHgJw36doOPQm20IyHdD977faz7YT1Hi',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-12-14 11:05:43',
            'updated_at' => '2023-04-04 16:18:01'
        ]);

        User::create([
            'id' => 63,
            'name' => 'Shashi',
            'email' => 'shashi@jimcorbett.in',
            'phone' => '8287500841',
            'avatar' => NULL,
            'leads_per_day' => 65,
            'email_verified_at' => NULL,
            'password' => '$2y$10$xSuhIYpOeSgbpijVq0meUu2VfVqZWQsGWGcAFTiO1G.GbiyAyJc9m',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2022-12-14 13:38:01',
            'updated_at' => '2023-04-06 17:48:15'
        ]);

        User::create([
            'id' => 64,
            'name' => 'Aman Kumar Prajapati',
            'email' => 'aman@ranthamboretigerreserve.in',
            'phone' => '7290926986',
            'avatar' => NULL,
            'leads_per_day' => 15,
            'email_verified_at' => NULL,
            'password' => '$2y$10$leda9O2QZ8daQc08SyBoIuBZ8iUitipZ2xrCOrLL4TTStTtuWb6b.',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2023-01-07 11:23:16',
            'updated_at' => '2023-02-12 13:01:57'
        ]);

        User::create([
            'id' => 65,
            'name' => 'asif jameel',
            'email' => 'asifjameel@jimcorbett.in',
            'phone' => '9818814226',
            'avatar' => NULL,
            'leads_per_day' => 5,
            'email_verified_at' => NULL,
            'password' => '$2y$10$9k1FN48hJBp9xLUu07mF8.k5Mdy918Bciyj/par3xnNkdbqLJFZK2',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2023-02-12 11:10:41',
            'updated_at' => '2023-02-12 13:11:17'
        ]);

        User::create([
            'id' => 66,
            'name' => 'Sachin',
            'email' => 'Hariom@jimcorbett.in',
            'phone' => '7982193537',
            'avatar' => NULL,
            'leads_per_day' => 10,
            'email_verified_at' => NULL,
            'password' => '123456',
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2023-02-25 11:42:10',
            'updated_at' => '2023-03-26 11:55:57'
        ]);

        User::create([
            'id' => 67,
            'name' => 'Shreya',
            'email' => 'Shreya@jimcorbett.in',
            'phone' => '9871972857',
            'avatar' => NULL,
            'leads_per_day' => 5,
            'email_verified_at' => NULL,
            'password' => '$2y$10$A7jMMClkxE/yCqJeeljxZe3.M4Uu2KYCV9zhoB42kwFTUoZ.gHULC',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2023-03-20 12:57:28',
            'updated_at' => '2023-03-21 10:27:37'
        ]);

        User::create([
            'id' => 69,
            'name' => 'dummy',
            'email' => 'dummy@jimcorbett.in',
            'phone' => '000000',
            'avatar' => NULL,
            'leads_per_day' => 5,
            'email_verified_at' => NULL,
            'password' => '$2y$10$cmL32cJVQ582JafJvs5ks.Lrir/X4YIgebpqTJlWrSCFLAAjSUvDu',
            'is_active' => 0,
            'remember_token' => NULL,
            'created_at' => '2023-03-29 11:28:05',
            'updated_at' => '2023-04-03 15:13:43'
        ]);

        User::create([
            'id' => 70,
            'name' => 'Divya Negi',
            'email' => 'divya@ranthamboretigerreserve.in',
            'phone' => '9599247530',
            'avatar' => NULL,
            'leads_per_day' => 60,
            'email_verified_at' => NULL,
            'password' => Hash::make('password'),
            'is_active' => 1,
            'remember_token' => NULL,
            'created_at' => '2023-04-09 11:51:54',
            'updated_at' => '2023-04-19 16:19:10'
        ]);
    }
}
