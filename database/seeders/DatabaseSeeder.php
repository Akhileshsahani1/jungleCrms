<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StateSeed::class);
        $this->call(UserSeed::class);
        $this->call(RoleSeed::class);
        $this->call(PermissionSeed::class);
        $this->call(UserRoleSeed::class);
        $this->call(RolePermissionSeed::class);
        $this->call(LeadStatusSeed::class);
        $this->call(PaymentModeSeed::class);
        $this->call(TermSeed::class);
        $this->call(VoucherSeed::class);
        $this->call(InclusionSeed::class);
        $this->call(ExclusionSeed::class);
        $this->call(HotelSeed::class);
        $this->call(HotelImageSeed::class);
        $this->call(HotelRoomSeed::class);
        $this->call(HotelRoomServiceSeed::class);
        $this->call(VendorSeed::class);
        $this->call(PermitRateSeed::class);
        $this->call(CompanySeed::class);
        $this->call(CountrySeed::class);
        $this->call(LeadSeed::class);
        $this->call(IternarySeed::class);
        $this->call(CabEstimateSeeder::class);
        $this->call(HotelEstimateSeeder::class);
        $this->call(SafariEstimateSeeder::class);
        $this->call(TourEstimateSeed::class);
        $this->call(PackageEstimateSeed::class);
        $this->call(BookingSeeder::class);
        $this->call(LeadFollowUpSeeder::class);
        $this->call(CountryStateSeed::class);
    }
}
