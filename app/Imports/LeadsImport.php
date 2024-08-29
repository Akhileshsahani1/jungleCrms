<?php

namespace App\Imports;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\{
                            ToModel,
                            WithHeadingRow };

class LeadsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $data = [
            'name'             => trim($row['name']),
            'email'            => trim($row['email']),
            'mobile'           => trim($row['mobile']),
            'website'          => $row['website'] ?? "SMO",
            'meta'             => $row['meta'],
            "assigned_to"      => Auth::user()->id,
            'destination'      => $row['destination'] ?? NULL,
        ];
        // echo "<pre/>";print_r($data);die;
        return new Lead($data);
    }
}
