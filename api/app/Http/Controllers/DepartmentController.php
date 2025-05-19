<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{

    public function index()
    {
        $departments = Department::with('degrees')->get();
        return response()->json(['departments' => $departments]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->form, [
            'university_id' => 'required',
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()]);
        }

        try {
            Department::create([
                'university_id' => $request->form['university_id'],
                'name' => $request->form['name']
            ]);
        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'Department added!']);
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
        Department::where('id', $id)->delete();
        return response()->json(['status' => true, 'message' => 'Department was successfully deleted!']);
    }
}
