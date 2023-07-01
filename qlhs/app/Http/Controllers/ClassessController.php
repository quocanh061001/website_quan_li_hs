<?php

namespace App\Http\Controllers;

use App\Models\Classess;
use App\Models\giaovien;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('classes.index');
    }

    public function fetchclasses(){
        try{
            $data = DB::table('lop')->join('giaovien', 'lop.magv', '=', 'giaovien.id')
                                    ->join('khoi', 'lop.makhoi', '=', 'khoi.id')
                                    ->select('lop.*', 'giaovien.name AS gvcn', 'khoi.name AS khoi')
                                    ->get();
            $khoi = DB::table('khoi')->get();
            $gvcn = DB::table('giaovien')->where('state', 0)->get();
            return response()->json([
                'classes'=>$data,
                'khoi'=>$khoi,
                'gvcn'=>$gvcn
            ]);
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
    public function search(Request $request){
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('lop')->join('giaovien', 'lop.magv', '=', 'giaovien.id')
                                        ->join('khoi', 'lop.makhoi', '=', 'khoi.id')
                                        ->select('lop.*', 'giaovien.name AS gvcn', 'khoi.name AS khoi')
                                        ->where('giaovien.name', 'like', '%'.$query.'%')
                                        ->orWhere('lop.name', 'like', '%'.$query.'%')
                                        ->get();
                    
            } else {
                $data = DB::table('lop')->join('giaovien', 'lop.magv', '=', 'giaovien.id')
                                        ->join('khoi', 'lop.makhoi', '=', 'khoi.id')
                                        ->select('lop.*', 'giaovien.name AS gvcn', 'khoi.name AS khoi')
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
                    <td>'.$row->gvcn.'</td>
                    <td>'.$row->khoi.'</td>
                    <td><button type="button" value="'.$row->id.'" class="edit_classes btn btn-primary btn-sm">Edit</button><a class="btn btn-danger" style="text-decoration:none; color:white" href="class_student/'.$row->id.'">Chi tiết lớp</a></td>\
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
                'khoi' => 'required',
                'gvcn'=> 'required',
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
            DB::table('giaovien')->where('id', $request->input('gvcn'))->update(['state' => 1]);
              $class = new Classess();
              $class->name = $request->input('name');
              $class->magv = $request->input('gvcn');
              $class->makhoi = $request->input('khoi');
              $class->namhoc = 1;
              $class->save();
              return response()->json([
                  'status'=>200,
                  'message'=>'Class Added Successfully'
              ]);
           }
        }catch(Exception $e){
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Classess $classess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try{      
            $lop = DB::table('lop')->find($id);
            // $khoi = DB::table('khoi')->get();
            // $gvcn = giaovien::all();
            $khoi = DB::table('khoi')->where('id', '<>', $lop->makhoi)->get();
            $gvcn = DB::table('giaovien')->where('id', '<>', $lop->magv)->get();
            $khoi_selected = DB::table('khoi')->where('id', $lop->makhoi)->value('name');
            $gvcn_selected = DB::table('giaovien')->where('id', $lop->magv)->value('name');
            if($lop){
                return response()->json([
                    'status' => 200,
                    'message' => $lop,
                    'khoi'=> $khoi,
                    'gvcn' => $gvcn,
                    'khoi_selected' => $khoi_selected,
                    'gvcn_selected' => $gvcn_selected
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
                'khoi' => 'required',
                'gvcn'=> 'required',
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
              $class = Classess::find($id);
              if($class){
                $gv = giaovien::where('id', $request->input('gvcn'))->first();
                
                if($class->magv == $gv->id){
                    $class->name = $request->input('name');
                    $class->makhoi = $request->input('khoi');
                    $class->update();
                    return response()->json([
                        'status' => 200,
                        'message' => 'class update Successfully',
                    ]);
                }if($gv->state == 1){
                    return response()->json([
                        'status'=>400,
                        'errors'=> ['giáo viên này đã là giáo viên chủ nhiệm'],
                    ]);
                }else{
                    giaovien::where('id', $class->magv)->update(['state'=>0]);
                    giaovien::where('id', $request->input('gvcn'))->update(['state'=>1]);

                    $class->name = $request->input('name');
                    $class->makhoi = $request->input('khoi');
                    $class->magv = $request->input('gvcn');
                    $class->update();
                    return response()->json([
                        'status' => 200,
                        'message' => 'class update Successfully',
                    ]);
                }
              }else
              {
                return response()->json([
                    'status' => 404,
                    'message' => 'class not found',
                ]);
              }
              return response()->json([
                'status'=>200,
                'message'=>'class update Successfully',
            ]);
           }
        }catch(Exception $e){
          dd($e->getMessage());
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classess $classess)
    {
        //
    }

    public function detail(Request $request , $id){
       $class_info = DB::table('lop')->join('giaovien', 'lop.magv', '=', 'giaovien.id')
                                     ->select('lop.*', 'giaovien.name AS teacher_name')
                                     ->where('lop.id', '=', $id)
                                     ->first();
      
        return view('classes.class_detail', [
            'class'=>$class_info
        ]);
    }
}
