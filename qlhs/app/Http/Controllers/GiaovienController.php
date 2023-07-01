<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\giaovien;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class GiaovienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('teachers.index');    
    }

    public function fetchteacher(){
        $teachers = DB::table('giaovien')->join('monhoc', 'giaovien.bomon','=', 'monhoc.id')->select('giaovien.id', 'giaovien.name', 'giaovien.gioitinh', 'monhoc.name AS tenbomon')->get();
        $subjects = DB::table('monhoc')->get();
        return response()->json([
            'teachers'=>$teachers,
            'subjects'=>$subjects
        ]);
    }

    public function search(Request $request){
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('giaovien')
                    ->where('name', 'like', '%'.$query.'%')
                    ->orWhere('gioitinh', 'like', '%'.$query.'%')
                    ->orWhere('bomon', 'like', '%'.$query.'%')
                    ->get();
                    
            } else {
                $data = DB::table('giaovien')
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
                    <td>'.$row->bomon.'</td>
                    <td><button type="button" value="'.$row->id.'" class="edit_teacher btn btn-primary btn-sm">Edit</button><button type="button" value="'.$row->id.'" class="delete_teacher btn btn-danger btn-sm">Delete</button></td>\
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
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|max:191',
                'gender' => 'required',
                'subject'=> 'required',
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
              $teacher = new giaovien();
              $teacher->name = $request->input('name');
              $teacher->gioitinh = $request->input('gender');
              $teacher->bomon = $request->input('subject');
              $teacher->state = 0;
              $teacher->save();
              return response()->json([
                  'status'=>200,
                  'message'=>'Teacher Added Successfully'
              ]);
           }
        }catch(Exception $e){
            dd($e);
        }
      
    }

    /**
     * Display the specified resource.
     */
    public function show(giaovien $giaovien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $teacher = giaovien::find($id);
        $subject_name = DB::table('monhoc')->where('id', $teacher->bomon)->value('name');
        $subject = DB::table('monhoc')->where('id', '<>', $teacher->bomon)->get();
        $gt_selected = $teacher->gioitinh;
        if($gt_selected == 'Nam'){
            $gt = 'Nữ';
        }else{
            $gt = 'Nam';
        }
        if($teacher){
            return response()->json([
                'status' => 200,
                'message' => $teacher,
                'subject'=> $subject,
                'subject_name' => $subject_name,
                'gt_selected' => $gt_selected,
                'gt' => $gt
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'teacher not found',
            ]);
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
                'subject'=> 'required',
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
              $teacher = giaovien::find($id);
              if($teacher){
                $teacher->name = $request->input('name');
                $teacher->gioitinh = $request->input('gender');
                $teacher->bomon = $request->input('subject');
                $teacher->state = 0;
                $teacher->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'teacher update Successfully',
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
        $teacher = giaovien::find($id);
        $teacher->delete();
        return response()->json([
             'status' => 200,
             'message' => 'teacher deleted successfully'
        ]);
    }
}
