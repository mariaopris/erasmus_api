<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{

    public function index()
    {
        $steps = Step::with('user')->get();
        $latestUsers = collect($steps)
            ->sortByDesc('created_at')
            ->unique('user_id')
            ->take(10)
            ->pluck('user_id');

        $filtered = collect($steps)
            ->whereIn('user_id', $latestUsers)
            ->groupBy('user_id');

        return response()->json(['steps' => $filtered]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        $steps = Step::where('user_id', $id)->get();
        return response()->json(['steps' => $steps]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $step = Step::where('user_id', $id)->where('tag','LIKE', $request->tag)->first();

        if(isset($request->status)){$step->status = $request->status;}

        $step->save();
        return response()->json(['status' => true, 'message' => 'Step updated successfully !']);
    }

    public function destroy(string $id)
    {
        //
    }
}
