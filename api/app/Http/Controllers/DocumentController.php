<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf',
            'userId' => 'required',
            'type' => 'required',
        ]);

        $user_id = $request->userId;
        $type = $request->type;
        $file = '';

        if(isset($request->file))
        {
            $file = $request->file('file');
        }

        try {
            if($file !== '') {
                Storage::disk('public')->put('/documents/'.$user_id.'/'.$type.'.pdf',file_get_contents($file));
                Document::create([
                    'type' => $type,
                    'user_id' => $user_id,
                    'status' => 'waiting_for_approval',
                    'path' => '/documents/'.$user_id.'/'.$type.'.pdf',
                    'feedback' => ''
                ]);
            }
        }
        catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'File saved successfully!']);
    }

    public function index()
    {
        $documents = Document::with('user')->orderBy('created_at', 'desc')->get();
        return response()->json(['documents' => $documents]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request, string $id)
    {
        $document = Document::where('user_id', $id)->where('type', 'LIKE', $request->type)->first();
        return response()->json(['document' => $document]);
    }

    public function getDocument(Request $request, string $id)
    {
        $document = Document::where('id', $id)->with('user')->first();
        return response()->json(['document' => $document]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $document = Document::where('id', $id)->first();

        if(isset($request->status)){$document->status = $request->status;}
        if(isset($request->feedback)){$document->feedback = $request->feedback;}

        $document->save();
        return response()->json(['status' => true, 'message' => 'Document updated successfully!']);
    }

    public function destroy(string $id)
    {
        $document = Document::where('id', $id)->first();

        if (!$document) {
            return response()->json(['status' => false, 'message' => 'Document not found.'], 404);
        }

        if (Storage::disk('public')->exists($document->path)) {
            Storage::disk('public')->delete($document->path);
        }

        $document->delete();

        return response()->json(['status' => true, 'message' => 'Document was successfully deleted!']);

    }
}
