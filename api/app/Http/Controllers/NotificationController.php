<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();
        return response()->json(['notifications' => $notifications]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->form, [
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()]);
        }

        try {
            Notification::create([
                'message' => $request->form['message']
            ]);
        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'Notification saved successfully!']);
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
        Notification::where('id', $id)->delete();
        return response()->json(['status' => true, 'message' => 'Notification was successfully deleted!']);
    }
}
