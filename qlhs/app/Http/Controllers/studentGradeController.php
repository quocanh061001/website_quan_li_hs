<?php

namespace App\Http\Controllers;


use App\Models\diemtheomon;
use App\Models\giaovien;
use App\Models\hs_kt;
use App\Models\hs_monhoc;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;


class studentGradeController extends Controller
{
    //
    public function index(){
        $user = Auth::user();
        $class_id = DB::table('lop')->where('magv', $user->teacher_id)->value('id');
        $giaovien = giaovien::find($user->teacher_id);
        $class = DB::table('lop')->where('id', $class_id)->first();
        return view('student_grade.index', [
            'teacher'=>$giaovien,
            'class'=>$class
        ]);
    }

    public function fetchstudentgrade($id){
        $students = DB::table('hocsinh')->where('malop', $id)->get();
        $kt_kl = DB::table('kt_kl')->get();
        return response()->json([
            'students' => $students,
            'kt_kl' => $kt_kl
        ]);
    }

    

    public function search(Request $request)
    {
        $user = Auth::user();
        $class_id = DB::table('lop')->where('magv', $user->teacher_id)->value('id');
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('hocsinh')
                    ->where([['name', 'like', '%'.$query.'%'],['malop','=', $class_id]])
                    ->orWhere([['gioitinh', 'like', '%'.$query.'%'],['malop','=', $class_id]])
                    ->orWhere([['renluyen', 'like', '%'.$query.'%'],['malop','=', $class_id]])
                    ->orWhere([['dantoc', 'like', '%'.$query.'%'],['malop','=', $class_id]])
                    ->get();
                    
            } else {
                $data = DB::table('hocsinh')->where('malop', $class_id)
                    ->orderBy('id', 'asc')
                    ->get();
            }
             
            $total_row = $data->count();
            if($total_row > 0){
                foreach($data as $row)
                {
                    $output .= '
                    <tr>
                    <td>'.$row->id.'</td>
                    <td>'.$row->name.'</td>
                    <td>'.$row->gioitinh.'</td>
                    <td>'.$row->dantoc.'</td>
                    <td>'.$row->renluyen.'</td>
                    <td>'.$row->diemtrungbinh.'</td>
                    <td><button type="button" value="'.$row->id.'" class="add_grade btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddGradeModal">Chi tiết học sinh</button></td>
                    </tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
            );
            echo json_encode($data);
        }
    }
    public function search_grade(Request $request, $student_id)
    {
       
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('hocsinh')->join('hs_monhoc', 'hocsinh.id', '=', 'hs_monhoc.mahs')
                                            ->join('monhoc', 'hs_monhoc.mamonhoc', '=', 'monhoc.id')
                                            ->join('diemtheomon', 'hs_monhoc.id', '=', 'diemtheomon.hs_mh')
                                            ->join('loaidiem', 'diemtheomon.maloaidiem', '=', 'loaidiem.id')
                                            ->select('diemtheomon.id AS id' , 'monhoc.name AS name', 'loaidiem.name AS loaidiem', 'diemtheomon.diem AS diem')
                                            ->where([['monhoc.name', 'like', '%'.$query.'%'],['hocsinh.id','=', $student_id]])
                                            ->orWhere([['loaidiem.name', 'like', '%'.$query.'%'],['hocsinh.id','=', $student_id]])
                                            ->get();
                    
            } else {
                $data = DB::table('hocsinh')->join('hs_monhoc', 'hocsinh.id', '=', 'hs_monhoc.mahs')
                ->join('monhoc', 'hs_monhoc.mamonhoc', '=', 'monhoc.id')
                ->join('diemtheomon', 'hs_monhoc.id', '=', 'diemtheomon.hs_mh')
                ->join('loaidiem', 'diemtheomon.maloaidiem', '=', 'loaidiem.id')
                ->select('diemtheomon.id AS id' , 'monhoc.name AS name', 'loaidiem.name AS loaidiem', 'diemtheomon.diem AS diem')
                ->where('hocsinh.id', '=', $student_id)
                ->get();
            }
             
            $total_row = $data->count();
            if($total_row > 0){
                foreach($data as $row)
                {
                    $output .= '
                    <tr>
                    <td>'.$row->name.'</td>
                    <td>'.$row->loaidiem.'</td>
                    <td>'.$row->diem.'</td>
                    <td><button type="button" value="'.$row->id.'" class="edit_mark btn btn-primary btn-sm">Sửa</button><button type="button" value="'.$row->id.'" class="delete_mark btn btn-danger btn-sm">Xóa</button></td>
                    </tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
            );
            echo json_encode($data);
        }
    }

    public function search_ktkl(Request $request, $student_id){
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('hocsinh')->join('hs_monhoc', 'hocsinh.id', '=', 'hs_monhoc.mahs')
                                            ->join('monhoc', 'hs_monhoc.mamonhoc', '=', 'monhoc.id')
                                            ->join('hs_kt', 'hs_monhoc.id', '=', 'hs_kt.hs_mh')
                                            ->join('kt_kl', 'hs_kt.makhenthuong', '=', 'kt_kl.id')
                                            ->select('hs_kt.id AS id' , 'monhoc.name AS name', 'kt_kl.name AS kt_kl', 'hs_kt.diem AS diem', 'hs_kt.updated_at AS created_day')
                                            ->where([['monhoc.name', 'like', '%'.$query.'%'],['hocsinh.id','=', $student_id]])
                                            ->orWhere([['kt_kl.name', 'like', '%'.$query.'%'],['hocsinh.id','=', $student_id]])
                                            ->get();
                    
            } else {
                $data = DB::table('hocsinh')->join('hs_monhoc', 'hocsinh.id', '=', 'hs_monhoc.mahs')
                ->join('monhoc', 'hs_monhoc.mamonhoc', '=', 'monhoc.id')
                ->join('hs_kt', 'hs_monhoc.id', '=', 'hs_kt.hs_mh')
                ->join('kt_kl', 'hs_kt.makhenthuong', '=', 'kt_kl.id')
                ->select('hs_kt.id AS id' , 'monhoc.name AS name', 'kt_kl.name AS kt_kl', 'hs_kt.diem AS diem', 'hs_kt.updated_at AS created_day')
                ->where('hocsinh.id', '=', $student_id)
                ->get();
            }
             
            $total_row = $data->count();
            if($total_row > 0){
                foreach($data as $row)
                {
                    $output .= '
                    <tr>
                    <td>'.$row->created_day.'</td>
                    <td>'.$row->kt_kl.'</td>
                    <td>'.$row->name.'</td>
                    <td>'.$row->diem.'</td>
                    <td><button type="button" value="'. $row->id .'" class="edit_hskt btn btn-primary btn-sm">Sửa</button><button type="button" value="'. $row->id .'" class="delete_hskt btn btn-danger btn-sm">Xóa</button></td>\
                    </tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
            );
            echo json_encode($data);
        }
    }
    public function student_detail($id){
        $student = Student::find($id);
        
        $subject_grade = DB::table('hocsinh')->join('hs_monhoc', 'hocsinh.id', '=', 'hs_monhoc.mahs')
                                             ->join('monhoc', 'hs_monhoc.mamonhoc', '=', 'monhoc.id')
                                             ->join('diemtheomon', 'hs_monhoc.id', '=', 'diemtheomon.hs_mh')
                                             ->join('loaidiem', 'diemtheomon.maloaidiem', '=', 'loaidiem.id')
                                             ->select('diemtheomon.id AS id' , 'monhoc.name AS name', 'loaidiem.name AS loaidiem', 'diemtheomon.diem AS diem')
                                             ->where('hocsinh.id', '=', $id)
                                             ->get();
        $subject = DB::table('monhoc')->get();
        $loaidiem = DB::table('loaidiem')->get();

        $kt_kl = DB::table('kt_kl')->get();
        $hskt_grade = DB::table('hocsinh')->join('hs_monhoc', 'hocsinh.id', '=', 'hs_monhoc.mahs')
                                             ->join('monhoc', 'hs_monhoc.mamonhoc', '=', 'monhoc.id')
                                             ->join('hs_kt', 'hs_monhoc.id', '=', 'hs_kt.hs_mh')
                                             ->join('kt_kl', 'hs_kt.makhenthuong', '=', 'kt_kl.id')
                                             ->select('hs_kt.id AS id' , 'monhoc.name AS name', 'kt_kl.name AS kt_kl', 'hs_kt.diem AS diem', 'hs_kt.updated_at AS created_day')
                                             ->where('hocsinh.id', '=', $id)
                                             ->get();
        $dtb_list = DB::table('hs_monhoc')->join('monhoc', 'hs_monhoc.mamonhoc', '=', 'monhoc.id')
                                          ->select(DB::raw('round(hs_monhoc.DTB, 2) AS dtb'), 'monhoc.name AS name')
                                          ->where('hs_monhoc.mahs', '=', $id)->get();
        if($student->renluyen >= 30){
            $hanhkiem = 'Tốt';      
        }elseif($student->renluyen >= 20){
            $hanhkiem = 'Khá';      
        }else{
            $hanhkiem = 'Trung bình';      
        }
        return response()->json([
            'student'=>$student,
            'subject_grade' => $subject_grade,
            'subject' => $subject,
            'loaidiem' => $loaidiem,
            'kt_kl' => $kt_kl,
            'hskt_grade' => $hskt_grade,
            'hanhkiem' => $hanhkiem,
            'dtb_list' => $dtb_list
        ]);
    }

    public function DTB(hs_monhoc $hsmh, $student_id){
      $diem = DB::table('hs_monhoc')
                ->join('diemtheomon', 'hs_monhoc.id', '=', 'diemtheomon.hs_mh')
                ->select(DB::raw('COUNT(diemtheomon.id) AS soluong'), DB::raw('SUM(diemtheomon.diem) AS tongdiem'), 'maloaidiem', 'hs_monhoc.mamonhoc')
                ->where([
                  ['hs_monhoc.mahs', '=' , $student_id],
                  ['hs_monhoc.mamonhoc', '=', $hsmh->mamonhoc]
                  ])
                ->groupBy('diemtheomon.maloaidiem', 'hs_monhoc.mamonhoc')
                ->get();
    if($diem->count()){
      $tuso = 0;
      $mauso = 0;
      foreach($diem as $item){ 
           if($item->maloaidiem == 1){
              $tuso = $tuso + $item->tongdiem;
              $mauso = $mauso + $item->soluong;
           }
           elseif($item->maloaidiem == 2){
              $tuso = $tuso + ($item->tongdiem)*2;
              $mauso = $mauso + ($item->soluong)*2 ;
           }else{
              $tuso = $tuso + ($item->tongdiem)*3;
              $mauso = $mauso + ($item->soluong)*3 ;
           }
      }
            $hsmh->DTB = $tuso/$mauso;
            $hsmh->update();
            $student = Student::find($hsmh->mahs);
            $diemtb_hs = DB::table('hs_monhoc')->where('mahs', $hsmh->mahs)
                                               ->avg('DTB');
            $student->diemtrungbinh = $diemtb_hs;
            $student->update();
    }else{
      $hsmh->DTB = null;
      $hsmh->update();
      $student = Student::find($hsmh->mahs);
            $diemtb_hs = DB::table('hs_monhoc')->where('mahs', $hsmh->mahs)
                                               ->avg('DTB');
            $student->diemtrungbinh = $diemtb_hs;
            $student->update();
    }
   
    }

    public function store(Request $request , $id)
    {
        try{
            $validator = Validator::make($request->all(),[
                'subject' => 'required',
                'loaidiem' => 'required',
                'diem'=> 'required',
           ]);
           if($validator->fails())
           {
              return response()->json([
                  'status'=>400,
                  'errors'=>$validator->messages(),
              ]);
           }
           else
           {
              $hs_mh = DB::table('hs_monhoc')->where([
                ['mahs', '=', $id],
                ['mamonhoc', '=', $request->input('subject')]
              ])->first();
              $diemtheomon = new diemtheomon();
              $diemtheomon->maloaidiem = $request->input('loaidiem');
              $diemtheomon->hs_mh = $hs_mh->id;
              $diemtheomon->diem = $request->input('diem');
              $diemtheomon->hk_nh = 1;
              $diemtheomon->save();
              $hs_mh2 = hs_monhoc::find($hs_mh->id);

              $this->DTB($hs_mh2, $hs_mh->mahs);
              return response()->json([
                  'status'=>200,
                  'message'=>'Thêm thành công'
              ]);
           }
        }catch(Exception $e){
            dd($e);
        }
    }

    public function edit($class_id, $student_id, $id){
        $diemtm = diemtheomon::find($id);
        $hs_mh = DB::table('hs_monhoc')->where('id', $diemtm->hs_mh)->first();
        $subject = DB::table('monhoc')->where('id', '<>', $hs_mh->mamonhoc)->get();
        $loaidiem = DB::table('loaidiem')->where('id', '<>', $diemtm->maloaidiem)->get();
        $tenmonhoc = DB::table('monhoc')->where('id', $hs_mh->mamonhoc)->first();
        $tenloaidiem =DB::table('loaidiem')->where('id', $diemtm->maloaidiem)->first();

        return response()->json([
            'subject' => $subject,
            'loaidiem' => $loaidiem,
            'loaidiem_select' => $diemtm->maloaidiem,
            'subject_select' => $hs_mh->mamonhoc,
            'diem' => $diemtm->diem,
            'tenmonhoc' => $tenmonhoc->name,
            'tenloaidiem' => $tenloaidiem->name
        ]);
    }

    public function update(Request $request, $student_id, $id){ 
        try{
            $validator = Validator::make($request->all(),[
                'diem' => 'required',
                'loaidiem' => 'required',
                'monhoc'=> 'required',
           ]);
           if($validator->fails())
           {
              return response()->json([
                  'status'=>400,
                  'errors'=>$validator->messages(),
              ]);
           }
           else
           {
              $hs_mh = DB::table('hs_monhoc')->where([
                    ['mahs', '=', $student_id],
                    ['mamonhoc', '=', $request->input('monhoc')]
              ])->first();
              $diemtheomon = diemtheomon::find($id);
              if($diemtheomon){
                $diemtheomon->maloaidiem = $request->input('loaidiem');
                $diemtheomon->hs_mh = $hs_mh->id;
                $diemtheomon->diem = $request->input('diem');
                $diemtheomon->update();
                $hs_mh2 = hs_monhoc::find($hs_mh->id);
               $this->DTB($hs_mh2, $hs_mh->mahs);

                return response()->json([
                    'status' => 200,
                  
                ]);
              }else
              {
                return response()->json([
                    'status' => 404,
                    'message' => 'teacher not found',
                ]);
              }
              return response()->json([
                'status'=>200,
                
            ]);
           }
        }catch(Exception $e){
          dd($e->getMessage());
        } 
    }

    public function destroy($id){
        $dtm = diemtheomon::find($id);
        $hsmh = $dtm->hs_mh;
        $dtm->delete();
        $hs_mh = hs_monhoc::find($hsmh); 
        $this->DTB($hs_mh, $hs_mh->mahs);
        return response()->json([
             'status' => 200,
             'message' => 'teacher deleted successfully'
        ]);
    }

    public function ktkl_store(Request $request , $id){
        try{
            $validator = Validator::make($request->all(),[
                'subject' => 'required',
                'makhenthuong' => 'required',
                'diem'=> 'required',
           ]);
           if($validator->fails())
           {
              return response()->json([
                  'status'=>400,
                  'errors'=>$validator->messages(),
              ]);
           }
           else
           {
              $hs_mh = DB::table('hs_monhoc')->where([
                ['mahs', '=', $id],
                ['mamonhoc', '=', $request->input('subject')]
              ])->first();
              $hs_kt = new hs_kt();
              $hs_kt->makhenthuong = $request->input('makhenthuong');
              $hs_kt->hs_mh = $hs_mh->id;
              $hs_kt->diem = $request->input('diem'); 
              $hs_kt->save();

              $student = Student::find($id);
              $loaikt = DB::table('kt_kl')->where('id',  $hs_kt->makhenthuong )->first();
              if($loaikt->loai==1){
                $student->renluyen =$student->renluyen + $hs_kt->diem;
              }else{
                $student->renluyen =$student->renluyen - $hs_kt->diem;
              }
              if($student->renluyen >= 30){
                $student->hanhkiem = "Tốt";
              }elseif($student->renluyen > 20){
                $student->hanhkiem = "Khá";               
              }else{
                $student->hanhkiem = "Trung bình";               
              }
              $student->update();

              return response()->json([
                  'status'=>200,
                  'message'=>'Thêm thành công'
              ]);
           }
        }catch(Exception $e){
            dd($e);
        }
    }

    public function ktkl_edit($class_id, $student_id, $id){
        $hskt = hs_kt::find($id);
    
        $hs_mh = DB::table('hs_monhoc')->where('id', $hskt->hs_mh)->first();
        $subject = DB::table('monhoc')->where('id', '<>', $hs_mh->mamonhoc)->get();
        $ktkl = DB::table('kt_kl')->where('id', '<>', $hskt->makhenthuong)->get();
        $tenmonhoc = DB::table('monhoc')->where('id', $hs_mh->mamonhoc)->first();
        $tenktkl =DB::table('kt_kl')->where('id', $hskt->makhenthuong)->first();

        return response()->json([
            'subject' => $subject,
            'ktkl' => $ktkl,
            'ktkl_select' => $hskt->makhenthuong,
            'subjectktkl_select' => $hs_mh->mamonhoc,
            'diem' => $hskt->diem,
            'tenmonhoc' => $tenmonhoc->name,
            'tenktkl' => $tenktkl->name
        ]);
    }
    public function ktkl_update(Request $request, $student_id, $id){ 
        try{
            $validator = Validator::make($request->all(),[
                'diem' => 'required',
                'ktkl' => 'required',
                'monhoc'=> 'required',
           ]);
           if($validator->fails())
           {
              return response()->json([
                  'status'=>400,
                  'errors'=>$validator->messages(),
              ]);
           }
           else
           {
              $hs_mh = DB::table('hs_monhoc')->where([
                    ['mahs', '=', $student_id],
                    ['mamonhoc', '=', $request->input('monhoc')]
              ])->first();
              $hskt = hs_kt::find($id);
              if($hskt){
                $student = Student::find($student_id);
                $kt_kl = DB::table('kt_kl')->where('id', $hskt->makhenthuong)->first();
                if($kt_kl->loai == 1){
                    if($request->input('diem')>$hskt->diem){
                        $student->renluyen = $student->renluyen + ($request->input('diem')-$hskt->diem);
                   }else{
                       $student->renluyen = $student->renluyen - ($hskt->diem-$request->input('diem'));
                   }
                }else{
                    if($request->input('diem')>$hskt->diem){
                        $student->renluyen = $student->renluyen - ($request->input('diem')-$hskt->diem);
                   }else{
                    $student->renluyen = $student->renluyen + ($hskt->diem-$request->input('diem'));
                   }
                }
                if($student->renluyen >= 30){
                    $student->hanhkiem = "Tốt";
                  }elseif($student->renluyen > 20){
                    $student->hanhkiem = "Khá";               
                  }else{
                    $student->hanhkiem = "Trung bình";               
                  }
                $student->update();

                $hskt->makhenthuong = $request->input('ktkl');
                $hskt->hs_mh = $hs_mh->id;  
                $hskt->diem = $request->input('diem');
                $hskt->update();
  
                return response()->json([
                    'status' => 200,
                  
                ]);
              }else
              {
                return response()->json([
                    'status' => 404,
                    'message' => 'teacher not found',
                ]);
              }
              return response()->json([
                'status'=>200,
                
            ]);
           }
        }catch(Exception $e){
          dd($e->getMessage());
        } 
    }
    public function ktkl_destroy($id){
        $hskt = hs_kt::find($id);
        $hsmh = DB::table('hs_monhoc')->where('id', $hskt->hs_mh)->first();
        $hs = Student::find($hsmh->mahs);
        $hs->renluyen = $hs->renluyen - $hskt->diem;
        if($hs->renluyen >= 30){
            $hs->hanhkiem = "Tốt";
          }elseif($hs->renluyen > 20){
            $hs->hanhkiem = "Khá";               
          }else{
            $hs->hanhkiem = "Trung bình";               
          }
        $hs->update();
        $hskt->delete();
        return response()->json([
             'status' => 200,
             
        ]);
    }
}
