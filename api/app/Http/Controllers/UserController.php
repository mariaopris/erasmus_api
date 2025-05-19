<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\ModelHasRole;
use App\Models\Step;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        $user = User::where('id',$request->user()->id)->first();
        $role = ModelHasRole::select('role_id')->where('model_id', $request->user()->id)->first();
        try{
            return response()->json([
                'id' => $request->user()->id,
                'email' => $request->user()->email,
                'password' => $request->user()->password,
                'name'=>$request->user()->name,
                'family_name'=>$request->user()->family_name,
                'role'=>$role->role_id,
            ]);
        }catch (\Exception $exception) {
            $response = [
                'state' => false,
                'error' => $exception->getMessage(),
            ];
            return response()->json($response, 400);
        }
    }

    public function logout(Request $request){
        try {
            $user = $request->user();
            if ($user !== null) {
                $user->currentAccessToken()->delete();
            }
            return response()->json(['message'=>'Logout successfully']);

        } catch (\Exception $exception) {
            $response = [
                'state' => false,
                'error' => $exception->getMessage(),
            ];
            return response()->json($response, 400);
        }
    }

    public function index()
    {
        $steps = Step::with('user')->get();
        $students = collect($steps)->groupBy('user_id');

        return response()->json(['students' => $students]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'family_name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()],400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->family_name = $request->family_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        try {
            $user->save();
            $user->assignRole(2);

            Step::create(
                ['type' => 'before', 'tag' => '1_1', 'status' => 'incomplete', 'user_id' => $user->id]
            );
            Step::create(
                ['type' => 'before', 'tag' => '1_2', 'status' => 'not_available', 'user_id' => $user->id]
            );
            Step::create(
                ['type' => 'before', 'tag' => '1_3', 'status' => 'not_available', 'user_id' => $user->id]
            );
            Step::create(
                ['type' => 'before', 'tag' => '1_4', 'status' => 'not_available', 'user_id' => $user->id]
            );
            Step::create(
                ['type' => 'during', 'tag' => '2_1', 'status' => 'not_available', 'user_id' => $user->id]
            );
            Step::create(
                ['type' => 'during', 'tag' => '2_2', 'status' => 'not_available', 'user_id' => $user->id]
            );
            Step::create(
                ['type' => 'after', 'tag' => '3_1', 'status' => 'not_available', 'user_id' => $user->id]
            );
            Step::create(
                ['type' => 'after', 'tag' => '3_2', 'status' => 'not_available', 'user_id' => $user->id]
            );
            Step::create(
                ['type' => 'after', 'tag' => '3_3', 'status' => 'not_available', 'user_id' => $user->id]
            );
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'User saved successfully!', 'id' => $user->id]);
    }

    public function show(string $id)
    {
        $user = User::where('id', $id)->first();
        return response()->json(['user' => $user]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->form, [
            'name' => 'required',
            'family_name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'nationality' => 'required',
            'country' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'phone_number' => 'required',
            'is_complete' => 'required',
            'home_university' => 'required',
            'degree' => 'required',
            'year' => 'required',
            'identity_no' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()]);
        }

        try {
            $user = User::where('id', $id)->first();

            if(isset($request->form['name'])){$user->name = $request->form['name'];}
            if(isset($request->form['family_name'])){$user->family_name = $request->form['family_name'];}
            if(isset($request->form['email'])){$user->email = $request->form['email'];}
            if(isset($request->form['gender'])){$user->gender = $request->form['gender'];}
            if(isset($request->form['date_of_birth'])){$user->date_of_birth = $request->form['date_of_birth'];}
            if(isset($request->form['nationality'])){$user->nationality = $request->form['nationality'];}
            if(isset($request->form['country'])){$user->country = $request->form['country'];}
            if(isset($request->form['address'])){$user->address = $request->form['address'];}
            if(isset($request->form['city'])){$user->city = $request->form['city'];}
            if(isset($request->form['postal_code'])){$user->postal_code = $request->form['postal_code'];}
            if(isset($request->form['phone_number'])){$user->phone_number = $request->form['phone_number'];}
            if(isset($request->form['is_complete'])){$user->is_complete = 1;}
            if(isset($request->form['home_university'])){$user->home_university = $request->form['home_university'];}
            if(isset($request->form['degree'])){$user->degree = $request->form['degree'];}
            if(isset($request->form['year'])){$user->year = $request->form['year'];}
            if(isset($request->form['identity_no'])){$user->identity_no = $request->form['identity_no'];}

            $user->save();
        }
        catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'User updated successfully !']);
    }

    public function destroy(string $id)
    {
        User::where('id', $id)->delete();
        return response()->json(['status' => true, 'message' => 'User was successfully deleted!']);

    }
}
