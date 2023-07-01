<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class dashboardController extends Controller
{
    public function index(){
        $gender = DB::table('hocsinh')
        ->select('gioitinh', DB::raw('count(id) as soluong'))
        ->groupBy('gioitinh')
        ->get();
        $data = "";
        foreach($gender as $item){
           $data.="['".$item->gioitinh."',     ".$item->soluong."],";
        }
        $chartGender = $data;
        $hk = DB::table('hocsinh')
        ->select('hanhkiem', DB::raw('count(id) as soluong'))
        ->groupBy('hanhkiem')
        ->get();
        
        $data2 = "";
        foreach($hk as $item){
            $data2.="['".$item->hanhkiem."',     ".$item->soluong."],";
        }
        $charthk = $data2;

        return view('main_dashboard',  compact('chartGender', 'charthk'));
    }
    public function class_index(){
        $user = Auth::user();
        $class = DB::table('lop')->where('magv', $user->teacher_id)->first();
        
        $gender = DB::table('hocsinh')
                ->select('gioitinh', DB::raw('count(id) as soluong'))
                ->where('malop', $class->id)
                ->groupBy('gioitinh')
                ->get();
        $data = "";
        foreach($gender as $item){
            $data.="['".$item->gioitinh."',     ".$item->soluong."],";
        }
        $chartGender = $data;

        $hk = DB::table('hocsinh')
        ->select('hanhkiem', DB::raw('count(id) as soluong'))
        ->where('malop', $class->id)
        ->groupBy('hanhkiem')
        ->get();
        
        $data2 = "";
        foreach($hk as $item){
            $data2.="['".$item->hanhkiem."',     ".$item->soluong."],";
        }
        $charthk = $data2;

        $diemtb = DB::table('hocsinh')
                  ->where('malop', $class->id)
                  ->get();
        $data3 = "";
        foreach($diemtb as $item){
            $data3.= "['".$item->name."', ".$item->diemtrungbinh."],";
        }
        $chartdtb = $data3;
        return view('student_grade.dashboard', compact('chartGender', 'charthk', 'chartdtb'));
    }
}
