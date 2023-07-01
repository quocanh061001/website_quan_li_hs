<?php

namespace App\Exports;


use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class HocsinhExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $id;
    public function __construct($id)
    {
        $this->id = $id;
    }
    public function collection()
    {
        return DB::table('hocsinh')->join('lop', 'hocsinh.malop', '=', 'lop.id')
                                   ->select('hocsinh.id', 'hocsinh.name', 'hocsinh.gioitinh', 'hocsinh.diachi', 'lop.name', 'hocsinh.hanhkiem', 'hocsinh.diemtrungbinh')
                                   ->where('lop.id', '=', $this->id)
                                   ->get();
    }
}
