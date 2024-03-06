<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $match  = '01723629080';
            $name   = $row['name'] ?? 'null';
            $phone  = $row['phone'] ?? 'null';
            $status = $row['status'] ?? 0;

            if ($phone === $match) {
                $status = 1; 
            } else {
                $status = 0;
            }

            Customer::create([
                'name'   => $name,
                'phone'  => $phone,
                'status' => $status,
            ]);
        }
    }
}
