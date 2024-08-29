<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;

class VoucherSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 11; $i++) {
            Term::create([
                'mode'      =>  'voucher',
                'type'      =>  'cab',
                'content'   =>  'This Cab voucher term and condition ' . $i . ' is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($j = 1; $j < 11; $j++) {
            Term::create([
                'mode'      =>  'voucher',
                'type'      =>  'hotel',
                'filter'    =>  'normal',
                'content'   =>  'This Hotel voucher term and condition ' . $j . ' for normal days is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($k = 1; $k < 11; $k++) {
            Term::create([
                'mode'      =>  'voucher',
                'type'      =>  'hotel',
                'filter'    =>  'weekend',
                'content'   =>  'This Hotel voucher term and condition ' . $k . ' for weekend days is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($l = 1; $l < 11; $l++) {
            Term::create([
                'mode'      =>  'voucher',
                'type'      =>  'hotel',
                'filter'    =>  'festival',
                'content'   =>  'This Hotel voucher term and condition ' . $l . ' for festival days is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($m = 1; $m < 11; $m++) {
            Term::create([
                'mode'      =>  'voucher',
                'type'      =>  'safari',
                'filter'    =>  'gir',
                'content'   =>  'This Safari voucher term and condition ' . $m . ' for Gir is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($n = 1; $n < 11; $n++) {
            Term::create([
                'mode'      =>  'voucher',
                'type'      =>  'safari',
                'filter'    =>  'jim',
                'content'   =>  'This Safari voucher term and condition ' . $n . ' for Jim Corbett is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($o = 1; $o < 11; $o++) {
            Term::create([
                'mode'      =>  'voucher',
                'type'      =>  'safari',
                'filter'    =>  'ranthambore',
                'content'   =>  'This Safari voucher term and condition ' . $o . ' for Ranthambore is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($p = 1; $p < 11; $p++) {
            Term::create([
                'mode'      =>  'voucher',
                'type'      =>  'tour',
                'filter'    =>  'gir',
                'content'   =>  'This Tour voucher term and condition ' . $p . ' for Gir is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($q = 1; $q < 11; $q++) {
            Term::create([
                'mode'      =>  'voucher',
                'type'      =>  'tour',
                'filter'    =>  'jim',
                'content'   =>  'This Tour voucher term and condition ' . $q . ' for Jim Corbett is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($r = 1; $r < 11; $r++) {
            Term::create([
                'mode'      =>  'voucher',
                'type'      =>  'tour',
                'filter'    =>  'ranthambore',
                'content'   =>  'This Tour voucher term and condition ' . $r . ' for Ranthambore is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($s = 1; $s < 11; $s++) {
            Term::create([
                'mode'      =>  'voucher',
                'type'      =>  'package',
                'filter'    =>  'gir',
                'content'   =>  'This Package voucher term and condition ' . $s . ' for Gir is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($t = 1; $t < 11; $t++) {
            Term::create([
                'mode'      =>  'voucher',
                'type'      =>  'package',
                'filter'    =>  'jim',
                'content'   =>  'This Package voucher term and condition ' . $t . ' for Jim Corbett is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($u = 1; $u < 11; $u++) {
            Term::create([
                'mode'      =>  'voucher',
                'type'      =>  'package',
                'filter'    =>  'ranthambore',
                'content'   =>  'This Package voucher term and condition ' . $u . ' for Ranthambore is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }
    }
}
