<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UniversitiesImport;

class UniversityController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        University::truncate();

        Excel::import(new UniversitiesImport, $request->file('file'));

        return response()->json('Data imported successfully!');
    }

    public function index()
    {
        $universities = University::all();
        return response()->json(['universities' => $universities]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->form, [
            'name' => 'required',
            'country' => 'required',
            'code' => 'required',
            'coordinator' => 'required',
            'mobility_period' => 'required',
            'isced_codes' => 'required',
            'years' => 'required',
            'languages' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()]);
        }

        try {
            $university = University::create([
                'name' => $request->form['name'],
                'email' => $request->form['email'],
                'country' => $request->form['country'],
                'code' => $request->form['code'],
                'coordinator' => $request->form['coordinator'],
                'mobility_period' => $request->form['mobility_period'],
                'isced_codes' => $request->form['isced_codes'],
                'years' => $request->form['years'],
                'languages' => $request->form['languages'],
                'description' => $request->form['description']
            ]);
        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'University saved successfully !']);
    }

    public function show(string $id)
    {
        $university = University::where('id', $id)->first();
        return response()->json(['university' => $university]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $university = University::where('id', $id)->first();

        if(isset($request->name)){$university->name = $request->name;}
        if(isset($request->email)){$university->email = $request->email;}
        if(isset($request->country)){$university->country = $request->country;}
        if(isset($request->code)){$university->code = $request->code;}
        if(isset($request->coordinator)){$university->coordinator = $request->coordinator;}
        if(isset($request->mobility_period)){$university->mobility_period = $request->mobility_period;}
        if(isset($request->isced_codes)){$university->isced_codes = $request->isced_codes;}
        if(isset($request->years)){$university->years = $request->years;}
        if(isset($request->university_languages)){$university->languages = $request->university_languages;}
        if(isset($request->description)){$university->description = $request->description;}

        $university->save();
        return response()->json(['status' => true, 'message' => 'University updated successfully !']);
    }

    public function destroy(string $id)
    {
        University::where('id', $id)->delete();
        return response()->json(['status' => true, 'message' => 'University was successfully deleted!']);
    }
}
