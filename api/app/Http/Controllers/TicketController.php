<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{

    public function getUserTickets($user_id)
    {
        $tickets = Ticket::where('user_id', $user_id)->get();
        return response()->json(['tickets' => $tickets]);
    }

    public function index()
    {
        $tickets = Ticket::with('user', 'messages')->orderBy('created_at', 'desc')->get();
        return response()->json(['tickets' => $tickets]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->form, [
            'user_id' => 'required',
            'title' => 'required',
            'department' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()]);
        }

        try {
            $ticket = Ticket::create([
                'user_id' => $request->form['user_id'],
                'title' => $request->form['title'],
                'department' => $request->form['department'],
                'status' => $request->form['status']
            ]);
        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'Ticket added!', 'id' => $ticket->id]);
    }

    public function show(string $id)
    {
        $ticket = Ticket::where('id', $id)->with('messages', 'user')->first();
        return response()->json(['ticket' => $ticket]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $ticket = Ticket::where('id', $id)->first();

        if(isset($request->status)) {
            $ticket->status = $request->status;
        }

        $ticket->save();
        return response()->json(['status' => true, 'message' => 'Ticket updated successfully!']);

    }

    public function destroy(string $id)
    {
        //
    }
}
