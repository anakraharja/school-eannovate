<?php

namespace App\Http\Controllers\Api\Mobile;

use App\ClassRoom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    public function index()
    {
        $class = ClassRoom::with('createdby','modifiedby')->orderBy('id')->get();
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $class
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ["required","max:64"],
            'major' => ["required"],
            'created_by' => ["required"],
            'modified_by' => ["required"],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'failed request',
                'errors' => $validator->errors()
            ],400);
        }
        $class = ClassRoom::create([
            'name' => $request->name,
            'major' => $request->major,
            'created_by' => $request->created_by,
            'modified_by' => $request->modified_by,
        ]);
        if($class){
            return response()->json([
                'status' => 200,
                'message' => 'Success created new class',
            ],201);
        }else{
            return response()->json([
                'status' => 500,
                'message' => 'Failed, internal server error!',
            ],500);
        }
    }

    public function show($id)
    {
        $class = ClassRoom::findOrfail($id);
        return response()->json([
            'status' => 200,
            'data' => $class,
        ],200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ["required","max:64"],
            'major' => ["required"],
            'modified_by' => ["required"],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'failed request',
                'errors' => $validator->errors()
            ],400);
        }
        $class = ClassRoom::findOrFail($id);
        $class->update([
            'name' => $request->name,
            'major' => $request->major,
            'modified_by' => $request->modified_by,
            'modified_date' => date('Y-m-d H:i:s',time())
        ]);
        if($class){
            return response()->json([
                'status' => 200,
                'message' => 'Success updated class',
                'data' => $class
            ],201);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Failed, data not found!',
            ],400);
        }
    }

    public function destroy($id)
    {
        $class = ClassRoom::findOrfail($id);
        if($class){
            $class->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success deleted class',
            ],201);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Failed, data not found!',
            ],400);
        }
    }

}
