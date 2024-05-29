<?php

namespace App\Http\Controllers\Api\Mobile;

use App\ClassRoom;
use App\Http\Controllers\Controller;
use App\Student;
use App\StudentClassRoom;
use App\TokenManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        if(request('class') == null){
            return response()->json([
                'status' => 400,
                'authorization' => 'Authorization',
                'message' => "Param not defind!"
            ],400);
        }
        // all
        if (request('class') == 'all') {
            $students = Student::with('student_class.class')->select()->get();
            if ($students->count() > 0) {
                return response()->json([
                    'status' => 200,
                    'authorization' => 'Authorization',
                    'data' => $students
                ],200);
            }else{
                return response()->json([
                    'status' => 400,
                    'authorization' => 'Authorization',
                    'message' => "Data not fount!"
                ],400);
            }
        }
        if((int) request('class')) {
            $students = Student::with('student_class.class')->classId(request('class'))->get();
            if ($students->count() > 0) {
                return response()->json([
                    'status' => 200,
                    'authorization' => 'Authorization',
                    'data' => $students
                ],200);
            }else{
                return response()->json([
                    'status' => 400,
                    'authorization' => 'Authorization',
                    'message' => "Data not fount!"
                ],400);
            }
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ["required","max:64"],
            'email' => ["required","max:64","email","unique:student,email"],
            'age' => ["required"],
            'class_id' => ["required"],
            'phone_number' => ["nullable","max:16"],
            'picture' => ["nullable","mimes:png,jpg,jpeg,pdf","max:2080"],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'failed request',
                'authorization' => 'Authorization',
                'errors' => $validator->errors()
            ],400);
        }
        $token_explode = explode(" ",$request->header("Authorization"));
        $access_token = $token_explode[1];
        $admin_login = TokenManagement::where("access_token",$access_token)->first()->created_by;
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'age' => $request->age,
            'phone_number' => $request->phone_number,
            'created_by' => $admin_login,
            'modified_by' => $admin_login,
        ];
        if($request->hasFile('picture')){
            $pict = time().date('Y-m-d').'api.'.$request->file('picture')->extension();
            $request->file('picture')->move(public_path('storage/images'), $pict);
            $data['picture'] = $pict;
        }else{
            $data['picture'] = null;
        }
        $student = Student::create($data);
        $response = [
            'id' => $student->id,
            'name' => $student->username,
            'age' => $student->age,
            'phone_number' => $student->phone_number,
            'picture' => $student->picture ? public_path('storage/images/'.$student->picture) : null,
            'class' => []
        ];
        foreach ($request->class_id as $val) {
            if($data_class = ClassRoom::find($val)){
                $stored_class = StudentClassRoom::create([
                    'student_id' => $student->id,
                    'class_id' => $val,
                    'created_by' => $student->created_by,
                ]);
                array_push($response['class'],[
                    'id' => $stored_class->id,
                    'title' => $data_class->name,
                    'major' => $data_class->major,
                ]);
            }
        }
        return response()->json([
            'status' => 200,
            'authorization' => 'Authorization',
            'data' => $response
        ]);
    }
}
