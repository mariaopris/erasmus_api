<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->form, [
            'ticket_id' => 'required',
            'user_type' => 'required',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()]);
        }

        try {
            $message = Message::create([
                'ticket_id' => $request->form['ticket_id'],
                'user_type' => $request->form['user_type'],
                'message' => $request->form['message']
            ]);
        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'Message added!']);
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
        $message = Message::where('id', $id)->first();

        $message->read = 1;
        $message->save();
        return response()->json(['status' => true, 'message' => 'Message updated successfully!']);
    }

    public function destroy(string $id)
    {
        //
    }
}
