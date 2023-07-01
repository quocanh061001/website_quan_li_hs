<?php

namespace App\Imports;

use App\Models\Classess;
use App\Models\hs_kt;
use App\Models\hs_monhoc;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;


class HocsinhImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     return new Student([
    //         'name' => $row[0],
    //         'gioitinh' => $row[1],
    //         'diachi' => $row[2],
    //         'dantoc' => $row[3],
    //         'malop' => Classess::where('name', $row[4])->pluck('id')->first(),
    //         'nienkhoa' => $row[5],
    //         'renluyen' => $row[6]
    //     ]);
    // }
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            Student::create([
                'name' => $row[0],
                'gioitinh' => $row[1],
                'diachi' => $row[2],
                'dantoc' => $row[3],
                'malop' => Classess::where('name', $row[4])->pluck('id')->first(),
                'nienkhoa' => $row[5],
                'renluyen' => $row[6]
            ]);
            $student = Student::latest('id')->first();
            for($i=1; $i<=9; $i++){
                hs_monhoc::create([
                   'mahs' => $student->id,
                   'mamonhoc' => $i,
                ]);
            }
        }
    }
}
