<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        return view('students.index');
    }
    public function fetchstudent()
    {
        $students = Student::all();
        return response()->json([
            'students' => $students,
        ]);
    }
    public function storestudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|max:191',
            'course' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray()
            ]);
        } else {
            $student = new Student();
            $student->name = $request->name;
            $student->email = $request->email;
            $student->phone = $request->phone;
            $student->course = $request->course;
            $studentadded =  $student->save();

            if ($studentadded) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Student Added Successfully.'
                ]);
            }
        }
    }

    public function editstudent($id)
    {
        $student = Student::find($id);
        if ($student) {
            return response()->json([
                'status' => 200,
                'student' => $student,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Student Not Found',
            ]);
        }
    }

    public function updatestudent(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|max:191',
            'course' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray()
            ]);
        }
        else 
        {
            $student = Student::find($id);
            if ($student) 
            {
            $student->name = $request->name;
            $student->email = $request->email;
            $student->phone = $request->phone;
            $student->course = $request->course;
            $studentadded =  $student->update();

            if ($studentadded) 
            {
                return response()->json([
                    'status' => 200,
                    'message' => 'Student Updated Successfully.'
                ]);
            }
                
            } 
            else 
            {
                return response()->json([
                    'status' => 404,
                    'message' => 'Student Not Found',
                ]);
            }
           
        }
    }

    public function deletestudent($id){
        // dd($id);
        $student = Student::find($id);
        if($student){
            $student->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Student Deleted Successfully.'
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No Student Found.'
            ]);
        }
    }












}
