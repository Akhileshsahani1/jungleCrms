<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermSeed extends Seeder
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
                'mode'      =>  'estimate',
                'type'      =>  'cab',
                'content'   =>  'This Cab estimate term and condition ' . $i . ' is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($j = 1; $j < 11; $j++) {
            Term::create([
                'mode'      =>  'estimate',
                'type'      =>  'hotel',
                'filter'    =>  'normal',
                'content'   =>  'This Hotel estimate term and condition ' . $j . ' for normal days is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($k = 1; $k < 11; $k++) {
            Term::create([
                'mode'      =>  'estimate',
                'type'      =>  'hotel',
                'filter'    =>  'weekend',
                'content'   =>  'This Hotel estimate term and condition ' . $k . ' for weekend days is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($l = 1; $l < 11; $l++) {
            Term::create([
                'mode'      =>  'estimate',
                'type'      =>  'hotel',
                'filter'    =>  'festival',
                'content'   =>  'This Hotel estimate term and condition ' . $l . ' for festival days is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($m = 1; $m < 11; $m++) {
            Term::create([
                'mode'      =>  'estimate',
                'type'      =>  'safari',
                'filter'    =>  'gir',
                'content'   =>  'This Safari estimate term and condition ' . $m . ' for Gir is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($n = 1; $n < 11; $n++) {
            Term::create([
                'mode'      =>  'estimate',
                'type'      =>  'safari',
                'filter'    =>  'jim',
                'content'   =>  'This Safari estimate term and condition ' . $n . ' for Jim Corbett is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($o = 1; $o < 11; $o++) {
            Term::create([
                'mode'      =>  'estimate',
                'type'      =>  'safari',
                'filter'    =>  'ranthambore',
                'content'   =>  'This Safari estimate term and condition ' . $o . ' for Ranthambore is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($p = 1; $p < 11; $p++) {
            Term::create([
                'mode'      =>  'estimate',
                'type'      =>  'tour',
                'filter'    =>  'gir',
                'content'   =>  'This Tour estimate term and condition ' . $p . ' for Gir is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($q = 1; $q < 11; $q++) {
            Term::create([
                'mode'      =>  'estimate',
                'type'      =>  'tour',
                'filter'    =>  'jim',
                'content'   =>  'This Tour estimate term and condition ' . $q . ' for Jim Corbett is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($r = 1; $r < 11; $r++) {
            Term::create([
                'mode'      =>  'estimate',
                'type'      =>  'tour',
                'filter'    =>  'ranthambore',
                'content'   =>  'This Tour estimate term and condition ' . $r . ' for Ranthambore is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($s = 1; $s < 11; $s++) {
            Term::create([
                'mode'      =>  'estimate',
                'type'      =>  'package',
                'filter'    =>  'gir',
                'content'   =>  'This Package estimate term and condition ' . $s . ' for Gir is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($t = 1; $t < 11; $t++) {
            Term::create([
                'mode'      =>  'estimate',
                'type'      =>  'package',
                'filter'    =>  'jim',
                'content'   =>  'This Package estimate term and condition ' . $t . ' for Jim Corbett is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }

        for ($u = 1; $u < 11; $u++) {
            Term::create([
                'mode'      =>  'estimate',
                'type'      =>  'package',
                'filter'    =>  'ranthambore',
                'content'   =>  'This Package estimate term and condition ' . $u . ' for Ranthambore is coming from Defaults > Estimates > Terms & Conditions',
            ]);
        }
    }
}
