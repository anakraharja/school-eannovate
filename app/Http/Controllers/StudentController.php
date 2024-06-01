<?php

namespace App\Http\Controllers;

use App\Student;
use App\StudentClassRoom;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $student = Student::with('createdby','modifiedby')->get();
        return view('student.index',[
            'title' => 'Student',
            'icon' => 'fa-user-graduate',
            'student' => $student
        ]);
    }

    public function create()
    {
        $client = new Client();
        $base_uri = 'http://school-eannovate.mochamadmaulana.my.id/api/mobile/class';
        $response = $client->request('GET', $base_uri);
        return view('student.create',[
            'title' => 'Student',
            'icon' => 'fa-user-graduate',
            'class' => json_decode($response->getBody(),true)['data']
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required',"max:64"],
            'email' => ['required',"max:64","email","unique:student,email"],
            'age' => ['required'],
            'class' => ['required'],
            'phone_number' => ['nullable','max:16'],
            'picture' => ['nullable','mimes:png,jpg,jpeg,pdf','max:2080'],
        ]);
        if ($validator->fails()) {
            return back()->with('error', 'Failed create data student!')->withErrors($validator)->withInput();
        }
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'age' => $request->age,
            'phone_number' => $request->phone_number,
            'created_by' => auth()->user()->id,
            'modified_by' => auth()->user()->id,
        ];
        if($request->hasFile('picture')){
            $pict = time().date('Y-m-d').'.'.$request->file('picture')->extension();
            $request->file('picture')->move(public_path('storage/images'), $pict);
            $data['picture'] = $pict;
        }
        $student = Student::create($data);
        foreach ($request->class as $val) {
            StudentClassRoom::create([
                'student_id' => $student->id,
                'class_id' => $val,
                'created_by' => auth()->user()->id,
            ]);
        }
        return back()->with('success','Success created data student');
    }

    public function edit($id)
    {
        $client = new Client();
        $base_uri = 'http://school-eannovate.mochamadmaulana.my.id/api/mobile/class';
        $response = $client->request('GET', $base_uri);
        $student = Student::with('student_class.class')->findOrFail($id);
        return view('student.edit',[
            'title' => 'Student',
            'icon' => 'fa-user-graduate',
            'student' => $student,
            'class' => json_decode($response->getBody(),true)['data']
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required',"max:64"],
            'email' => ['required',"max:64","email","unique:student,email,".$id.",id"],
            'age' => ['required'],
            'phone_number' => ['nullable','max:16'],
            'picture' => ['nullable','mimes:png,jpg,jpeg,pdf','max:2080'],
        ]);
        if ($validator->fails()) {
            return back()->with('error', 'Failed update data student!')->withErrors($validator)->withInput();
        }
        if($request->has('class') > 0){
            foreach ($request->class as $val) {
                if($student_class = StudentClassRoom::with('class')->where('student_id',$id)->where('class_id',$val)->first()){
                    return back()->with('error','The '.$student_class->class->name.' is already exists!')->withInput();
                }
            }
            foreach ($request->class as $result) {
                StudentClassRoom::create([
                    'student_id' => $id,
                    'class_id' => $result,
                    'created_by' => auth()->user()->id
                ]);
            }
        }
        $student = Student::findOrFail($id);
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'age' => $request->age,
            'phone_number' => $request->phone_number,
            'modified_by' => auth()->user()->id,
            'modified_date' => date('Y-m-d H:i:s',time())
        ];
        if($request->hasFile('picture')){
            if($student->picture != NULL){
                $pict = time().'-'.date('Y-m-d').'.'.$request->file('picture')->extension();
                $request->file('picture')->move(public_path('storage/images'), $pict);
                $data['picture'] = $pict;
                $image_old = public_path('storage/images/'.$student->picture);
                if (File::exists($image_old)) {
                    //File::delete($image_old);
                    unlink($image_old);
                }
            }else{
                $pict = time().'-'.date('Y-m-d').'.'.$request->file('picture')->extension();
                $request->file('picture')->move(public_path('storage/images'), $pict);
                $data['picture'] = $pict;

            }
        }
        $student->update($data);
        return back()->with('success','Success updated data student');
    }

    public function destroy($id)
    {
        $student = Student::with('student_class')->findOrFail($id);
        if($student){
            if($student->picture != NULL){
                $image_old = public_path('storage/images/'.$student->picture);
                if (File::exists($image_old)) {
                    //File::delete($image_old);
                    unlink($image_old);
                }
            }
            foreach ($student->student_class as $value) {
                StudentClassRoom::find($value->id)->delete();
            }
            $student->delete();
        }
        return back()->with('success','Success deleted data student');
    }

    public function destroy_picture($id)
    {
        $student = Student::findOrFail($id);
        if($student){
            $image_old = public_path('storage/images/'.$student->picture);
            if (File::exists($image_old)) {
                //File::delete($image_old);
                unlink($image_old);
                $student->update(['picture' => NULL]);
            }
        }
        return back()->with('success','Success deleted picture');
    }

    public function student_class($id)
    {
        $student_class = StudentClassRoom::findOrFail($id);
        $student_class->delete();
        return back()->with('success','Class successfully deleted');
    }

    public function multiple_delete(Request $request)
    {
        $idSelected = $request->id;
        Student::whereIn('id',$idSelected)->delete();
        session()->flash('success','Success delete data selected');
        return response()->json(['success'=>true]);
    }
}
