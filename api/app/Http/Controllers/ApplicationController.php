<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{

    public function getUserApplications($user_id)
    {
        $applications = Application::where('user_id', $user_id)->with('university')->get();
        return response()->json(['applications' => $applications]);
    }

    public function uploadFiles(Request $request)
    {
//        $request->validate([
//            'language' => 'required|mimes:pdf',
//            'id' => 'required|mimes:pdf',
//            'cv' => 'required|mimes:pdf',
//            'letter' => 'required|mimes:pdf',
//            'records' => 'required|mimes:pdf',
//            'userId' => 'required',
//            'applicationId' => 'required',
//        ]);

        $user_id = $request->userId;
        $application_id = $request->applicationId;

        $diplomas_file = '';
        $language_file = '';
        $id_file = '';
        $cv_file = '';
        $letter_file = '';
        $records_file = '';

        if(isset($request->language))
        {
            $language_file = $request->file('language');
        }

        if(isset($request->id))
        {
            $id_file = $request->file('id');
        }

        if(isset($request->cv))
        {
            $cv_file = $request->file('cv');
        }

        if(isset($request->letter))
        {
            $letter_file = $request->file('letter');
        }

        if(isset($request->records))
        {
            $records_file = $request->file('records');
        }

        if(isset($request->diplomas))
        {
            $diplomas_file = $request->file('diplomas');
        }

        try {
            if($language_file !== '') {
                Storage::disk('public')->put('/applications/'.$user_id.'/'.$application_id.'/language_certificate.pdf',file_get_contents($language_file));
            }
            if($id_file !== '') {
                Storage::disk('public')->put('/applications/'.$user_id.'/'.$application_id.'/id.pdf',file_get_contents($id_file));
            }
            if($cv_file !== '') {
                Storage::disk('public')->put('/applications/'.$user_id.'/'.$application_id.'/cv.pdf',file_get_contents($cv_file));
            }
            if($letter_file !== '') {
                Storage::disk('public')->put('/applications/'.$user_id.'/'.$application_id.'/motivation_letter.pdf',file_get_contents($letter_file));
            }
            if($records_file !== '') {
                Storage::disk('public')->put('/applications/'.$user_id.'/'.$application_id.'/transcript_of_records.pdf',file_get_contents($records_file));
            }
            if($diplomas_file !== '') {
                Storage::disk('public')->put('/applications/'.$user_id.'/'.$application_id.'/other_diplomas.pdf',file_get_contents($diplomas_file));
            }
        }
        catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'Files saved successfully!']);
    }

    public function index()
    {
        $applications = Application::with('user')->orderBy('created_at', 'desc')->get();
        return response()->json(['applications' => $applications]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->form, [
            'user_id' => 'required',
            'status' => 'required',
            'academic_year' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'date_of_birth' => 'required',
            'phone' => 'required',
            'id_number' => 'required',
            'faculty' => 'required',
            'study_cycle' => 'required',
            'current_study_year' => 'required',
            'education_field' => 'required',
            'gpa' => 'required',
            'mobility_program' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()]);
        }

        try {
            $application= Application::create([
                'user_id' => $request->form['user_id'],
                'university_id' => $request->form['university_id'],
                'status' => $request->form['status'],
                'selection_score' => $request->form['selection_score'],
                'feedback_comments' => $request->form['feedback_comments'],
                'feedback_admin_id' => $request->form['feedback_admin_id'],
                'academic_year' => $request->form['academic_year'],
                'first_name' => $request->form['first_name'],
                'last_name' => $request->form['last_name'],
                'email' => $request->form['email'],
                'date_of_birth' => $request->form['date_of_birth'],
                'phone' => $request->form['phone'],
                'id_number' => $request->form['id_number'],
                'faculty' => $request->form['faculty'],
                'study_cycle' => $request->form['study_cycle'],
                'current_study_year' => $request->form['current_study_year'],
                'education_field' => $request->form['education_field'],
                'gpa' => $request->form['gpa'],
                'summary' => $request->form['summary'],
                'mobility_program' => $request->form['mobility_program'],
                'period_of_mobility' => $request->form['period_of_mobility'],
                'mobility_start_date' => $request->form['mobility_start_date'],
                'mobility_end_date' => $request->form['mobility_end_date'],
                'destination_type' => $request->form['destination_type'],
                'destination_1' => $request->form['destination_1'],
                'destination_2' => $request->form['destination_2'],
                'destination_3' => $request->form['destination_3'],
                'placement_country' => $request->form['placement_country']
            ]);
        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'Application added!', 'id' => $application->id]);
    }

    public function show(string $id)
    {
        $application = Application::where('id', $id)->first();
        return response()->json(['application' => $application]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $application = Application::where('id', $id)->first();

        if(isset($request->user_id)){$application->user_id = $request->user_id;}
        if(isset($request->university_id)){$application->university_id = $request->university_id;}
        if(isset($request->status)){$application->status = $request->status;}
        if(isset($request->selection_score)){$application->selection_score = $request->selection_score;}
        if(isset($request->feedback_comments)){$application->feedback_comments = $request->feedback_comments;}
        if(isset($request->feedback_admin_id)){$application->feedback_admin_id = $request->feedback_admin_id;}
        if(isset($request->academic_year)){$application->academic_year = $request->academic_year;}
        if(isset($request->first_name)){$application->first_name = $request->first_name;}
        if(isset($request->last_name)){$application->last_name = $request->last_name;}
        if(isset($request->email)){$application->email = $request->email;}
        if(isset($request->date_of_birth)){$application->date_of_birth = $request->date_of_birth;}
        if(isset($request->phone)){$application->phone = $request->phone;}
        if(isset($request->id_number)){$application->id_number = $request->id_number;}
        if(isset($request->faculty)){$application->faculty = $request->faculty;}
        if(isset($request->study_cycle)){$application->study_cycle = $request->study_cycle;}
        if(isset($request->current_study_year)){$application->current_study_year = $request->current_study_year;}
        if(isset($request->education_field)){$application->education_field = $request->education_field;}
        if(isset($request->gpa)){$application->gpa = $request->gpa;}
        if(isset($request->summary)){$application->summary = $request->summary;}
        if(isset($request->mobility_program)){$application->mobility_program = $request->mobility_program;}
        if(isset($request->period_of_mobility)){$application->period_of_mobility = $request->period_of_mobility;}
        if(isset($request->mobility_start_date)){$application->mobility_start_date = $request->mobility_start_date;}
        if(isset($request->mobility_end_date)){$application->mobility_end_date = $request->mobility_end_date;}
        if(isset($request->destination_type)){$application->destination_type = $request->destination_type;}
        if(isset($request->destination_1)){$application->destination_1 = $request->destination_1;}
        if(isset($request->destination_2)){$application->destination_2 = $request->destination_2;}
        if(isset($request->destination_3)){$application->destination_3 = $request->destination_3;}
        if(isset($request->placement_country)){$application->placement_country = $request->placement_country;}

        $application->save();
        return response()->json(['status' => true, 'message' => 'Application updated successfully !']);
    }

    public function destroy(string $id)
    {
        Application::where('id', $id)->delete();
        return response()->json(['status' => true, 'message' => 'Application was successfully deleted!']);
    }
}
