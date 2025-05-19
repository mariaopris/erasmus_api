<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('university', 'department')->get();
        return response()->json(['courses' => $courses]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->form, [
            'university_id' => 'required',
            'department_id' => 'required',
            'degree_id' => 'required',
            'name' => 'required',
            'language' => 'required',
            'level' => 'required',
            'year' => 'required',
            'semester' => 'required',
            'no_credits' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()]);
        }

        try {
            $course = Course::create([
                'university_id' => $request->form['university_id'],
                'department_id' => $request->form['department_id'],
                'degree_id' => $request->form['degree_id'],
                'name' => $request->form['name'],
                'language' => $request->form['language'],
                'level' => $request->form['level'],
                'year' => $request->form['year'],
                'semester' => $request->form['semester'],
                'no_credits' => $request->form['no_credits'],
                'description' => $request->form['description'],
                'link' => $request->form['link']
            ]);
        }
        catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'Course saved successfully !']);

    }

    public function show(string $id)
    {
        $course = Course::where('id', $id)->with('university', 'department', 'degree')->first();
        return response()->json(['course' => $course]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $course = Course::where('id', $id)->first();

        if(isset($request->university_id)){$course->university_id = $request->university_id;}
        if(isset($request->department_id)){$course->department_id = $request->department_id;}
        if(isset($request->degree_id)){$course->degree_id = $request->degree_id;}
        if(isset($request->name)){$course->name = $request->name;}
        if(isset($request->language)){$course->language = $request->language;}
        if(isset($request->level)){$course->level = $request->level;}
        if(isset($request->year)){$course->year = $request->year;}
        if(isset($request->semester)){$course->semester = $request->semester;}
        if(isset($request->no_credits)){$course->no_credits = $request->no_credits;}
        if(isset($request->description)){$course->description = $request->description;}
        if(isset($request->tags)){$course->tags = $request->tags;}
        if(isset($request->link)){$course->link = $request->link;}

        $course->save();
        return response()->json(['status' => true, 'message' => 'Course updated successfully !']);
    }

    public function destroy(string $id)
    {
        Course::where('id', $id)->delete();
        return response()->json(['status' => true, 'message' => 'Course was successfully deleted!']);

    }
}
