<?php

namespace App\Http\Controllers;

use App\Exports\HocsinhExport;
use App\Models\hs_monhoc;
use App\Models\Student;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Imports\HocsinhImport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public $class_id;

    public function index($id)
    {
        // $this->class_id = $id;
        // $student = DB::table('hocsinh')->where('malop', $id);
        // return view('classes.class_detail', [
        //     'student' => $student
          
        // ]);
    }
   public function fetchstudent($id){
        // $value = $request->session()->get('id');
        // dd($value);
        $students = DB::table('hocsinh')->where('malop', $id)->get();
        
        return response()->json([
            'students' => $students,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function uploadStudent(Request $request){
        Excel::import(new HocsinhImport,  $request->file('file')->store('temp'));
        

        return back();
   }

   public function exportStudent($id) 
    {
        $data = new HocsinhExport($id);
        return Excel::download($data, 'student.xlsx');
    }
    public function search(Request $request, $class_id){
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('hocsinh')
                    ->where([['name', 'like', '%'.$query.'%'], ['malop', '=', $class_id]])
                    ->orWhere([['gioitinh', 'like', '%'.$query.'%'], ['malop', '=', $class_id]])
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
                    <td><button type="button" value="'.$row->id.'" class="edit_student btn btn-primary btn-sm">Edit</button><button type="button" value="'.$row->id.'" class="delete_student btn btn-danger btn-sm">Delete</button></td>\
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
    

    public function store(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|max:191',
                'gender' => 'required',
                'address'=> 'required',
                'dt'=> 'required',
                'nk'=> 'required',
                'rl'=> 'required',

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
              $student = new Student();
              $student->name = $request->input('name');
              $student->gioitinh = $request->input('gender');
              $student->diachi = $request->input('address');
              $student->dantoc = $request->input('dt');
              $student->nienkhoa = $request->input('nk');
              $student->renluyen = $request->input('rl');
              $student->malop = $id;
              if($request->input('rl') >= 30){
                $student->hanhkiem = 'Tốt';
              }elseif($request->input('rl') > 20){
                $student->hanhkiem = 'Khá';
              }else{
                $student->hanhkiem = 'Trung bình';
              }
              
              $student->save();
              
              for($i=1; $i<=9; $i++){
                $hs_monhoc = new hs_monhoc();
                $hs_monhoc->mahs = $student->id;
                $hs_monhoc->mamonhoc = $i;
                $hs_monhoc->save();  
              }
              return response()->json([
                  'status'=>200,
                  'message'=>'student Added Successfully'
              ]);
           }
        }catch(Exception $e){
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($class_id, $id)
    {
        try{      
            $student = DB::table('hocsinh')->find($id);
            if($student){
                return response()->json([
                    'status' => 200,
                    'message' => $student
                ]);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'class not found',
                ]);
            }
        }catch(Exception $e){
            dd($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|max:191',
                'gender' => 'required',
                'address'=> 'required',
                'dt'=> 'required',
                'nk'=> 'required',
                'rl'=> 'required',
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
              $student = Student::find($id);
              if($student){
                $student->name = $request->input('name');
                $student->gioitinh = $request->input('gender');
                $student->diachi = $request->input('address');
                $student->dantoc = $request->input('dt');
                $student->nienkhoa = $request->input('nk');
                $student->renluyen = $request->input('rl');
                if($request->input('rl') >= 30){
                    $student->hanhkiem = 'Tốt';
                  }elseif($request->input('rl') > 20){
                    $student->hanhkiem = 'Khá';
                  }else{
                    $student->hanhkiem = 'Trung bình';
                  }
                $student->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'student update Successfully',
                ]);
              }else
              {
                return response()->json([
                    'status' => 404,
                    'message' => 'student not found',
                ]);
              }
              return response()->json([
                'status'=>200,
                'message'=>'Student update Successfully',
            ]);
           }
        }catch(Exception $e){
          dd($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        for($i=1; $i<=9; $i++){
            $hs_monhoc = hs_monhoc::where([['mahs', '=', $id], ['mamonhoc', '=', $i]])->first();
            $hs_monhoc->delete();
        }
        $student = Student::find($id);
        $student->delete();
        return response()->json([
             'status' => 200,
             'message' => 'student deleted successfully'
        ]);
    }
}
