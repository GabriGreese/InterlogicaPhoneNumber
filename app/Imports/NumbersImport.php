<?php

namespace App\Imports;

use App\Models\Number;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NumbersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Number([
            'csv_id' => $row['id'],
            'sms_phone' => $row['sms_phone']
        ]);
    }
}
