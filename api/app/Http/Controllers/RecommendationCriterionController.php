<?php

namespace App\Http\Controllers;

use App\Models\RecommendationCriterion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecommendationCriterionController extends Controller
{

    public function index(Request $request)
    {
        $recommendations = RecommendationCriterion::where('user_id', $request->user_id)->orderBy('created_at', 'desc')->get();
        return response()->json(['recommendations' => $recommendations]);

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->form, [
            'user_id' => 'required',
            'year' => 'required',
            'duration' => 'required',
            'university' => 'required',
            'degree' => 'required',
            'preferred_countries' => 'required',
            'study_language' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()]);
        }

        try {
            $recommendation_criterion = RecommendationCriterion::create([
                'user_id' => $request->form['user_id'],
                'year' => $request->form['year'],
                'duration' => $request->form['duration'],
                'university' => $request->form['university'],
                'degree' => $request->form['degree'],
                'preferred_countries' => $request->form['preferred_countries'],
                'study_language' => $request->form['study_language'],
                'status' => $request->form['status'],
            ]);
        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'Recommendation Criteria saved successfully !']);
    }

    public function show(string $id)
    {
        $recommendation = RecommendationCriterion::where('id', $id)->with('university')->first();
        return response()->json(['recommendation' => $recommendation]);

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
        RecommendationCriterion::where('id', $id)->delete();
        return response()->json(['status' => true, 'message' => 'Recommendation was successfully deleted!']);
    }
}
