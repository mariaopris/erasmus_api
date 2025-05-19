<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DegreeController extends Controller
{
    public function index()
    {
        $degrees = Degree::with('university')->get();
        return response()->json(['degrees' => $degrees]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->form, [
            'name' => 'required',
            'university_id' => 'required',
            'department_id' => 'required',
            'level' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()]);
        }

        try {
            $degree = Degree::create([
                'name' => $request->form['name'],
                'university_id' => $request->form['university_id'],
                'department_id' => $request->form['department_id'],
                'level' => $request->form['level']
            ]);
        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'Degrees saved successfully !']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        Degree::where('id', $id)->delete();
        return response()->json(['status' => true, 'message' => 'Degree was successfully deleted!']);

    }
}
