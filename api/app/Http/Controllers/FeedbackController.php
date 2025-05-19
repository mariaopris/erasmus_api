<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Feedback;
use App\Models\Message;
use App\Models\RecommendationCriterion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function getDashboardData()
    {
        $feedback_score = Feedback::avg('score');
        $no_students = User::role('user')->count();;
        $no_rec = RecommendationCriterion::count();;
        $unread_mes = Message::where('read', 0)->count();
        $no_doc = Document::where('status', 'LIKE', 'waiting_for_approval')->count();

        return response()->json(['feedback_score' => number_format($feedback_score, 2), 'no_students' => $no_students,
            'no_rec' => $no_rec, 'unread_mes' => $unread_mes, 'no_doc' => $no_doc]);
    }

    public function index()
    {
        $feedbacks = Feedback::all();
        return response()->json(['feedbacks' => $feedbacks]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->form, [
            'recommendation_id' => 'required',
            'score' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()]);
        }

        try {
            $feedback = Feedback::create([
                'recommendation_id' => $request->form['recommendation_id'],
                'score' => $request->form['score'],
                'comment' => $request->form['comment'],
            ]);
        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'Feedback saved successfully!']);
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
        //
    }
}
