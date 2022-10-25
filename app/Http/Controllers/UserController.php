<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.user-profile');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'max:255', 'min:2'],
                'email' => ['required', 'email', 'max:255',  Rule::unique('users')->ignore(auth()->user()->id),],
                'mobile' => 'unique:users,mobile',

            ]
        );

        if ($validator->fails()) {
            return $this->ajaxResponse(422, 'The given data was invalid.', $validator->errors(), []);
        }

        try {

            User::create([
                'name' => $request->name ?? '',
                'email' => $request->email,
                'password' => $request->password,
                'mobile' => $request->mobile ?? null,
                'user_type' => $request->user_type ?? 'user',

            ]);

            return $this->ajaxResponse(200, 'User created successfully.', [], []);
        } catch (\Exception $exception) {
            Log::error([$exception->getFile(), $exception->getLine(), $exception->getMessage()]);
            return $this->ajaxResponse(500, $exception->getMessage(), [], []);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('pages.user-edit', [
            'user' => $user,

        ]);
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->ajaxResponse(404, 'User not found.', [], []);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'max:255', 'min:2'],
                'email' => ['required', 'email', 'max:255'],


            ]
        );
        if ($validator->fails()) {
            return $this->ajaxResponse(422, 'The given data was invalid.', $validator->errors(), []);
        }
        try {

            $user->update([
                'name' => $request->name ?? $user->name,
                'email' => $request->email ?? $user->email,
                'mobile' => $request->mobile ?? $user->mobile,
                'password' => $request->password ?? $user->password,
                'user_type' => $request->user_type ?? $user->user_type,

            ]);
            return $this->ajaxResponse(200, 'User updated successfully.', [], []);
        } catch (\Exception $exception) {
            Log::error([$exception->getFile(), $exception->getLine(), $exception->getMessage()]);
            return $this->ajaxResponse(500, $exception->getMessage(), [], []);
        }
    }

    /**
     * Delete the given client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $clientId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $user = User::find($id);
        if (!$user) {
            return new Response('', 404);
        }
        $user->delete();
        session()->flash('success', 'User deleted successfully.');
        return redirect('/user-management');
    }

    public function ajaxResponse($code, $message = "The given data was invalid.", $errors = null, $data = null)
    {

        if (!is_null($errors)) {
            if (!is_object($errors)) {
                $errors = (object) $errors;
            }
        }
        return response()->json(
            [
                'message' => $message,
                'errors'  => $errors,
                'data'    => $data,
                'code'    => $code,
            ],
            200
        );
    }
}
