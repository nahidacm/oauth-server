<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Http\Rules\RedirectRule;
use Laravel\Passport\Passport;

class ClientController extends Controller
{
    /**
     * The client repository instance.
     *
     * @var \Laravel\Passport\ClientRepository
     */
    protected $clients;

    /**
     * The validation factory implementation.
     *
     * @var \Illuminate\Contracts\Validation\Factory
     */
    protected $validation;

    /**
     * The redirect validation rule.
     *
     * @var \Laravel\Passport\Http\Rules\RedirectRule
     */
    protected $redirectRule;

    /**
     * Create a client controller instance.
     *
     * @param  \Laravel\Passport\ClientRepository  $clients
     * @param  \Illuminate\Contracts\Validation\Factory  $validation
     * @param  \Laravel\Passport\Http\Rules\RedirectRule  $redirectRule
     * @return void
     */
    public function __construct(
        ClientRepository $clients,
        ValidationFactory $validation,
        RedirectRule $redirectRule
    ) {
        $this->clients = $clients;
        $this->validation = $validation;
        $this->redirectRule = $redirectRule;
    }

    /**
     * Get all of the clients for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function forUser(Request $request)
    {
        $userId = $request->user()->getAuthIdentifier();

        $clients = $this->clients->activeForUser($userId);

        if (Passport::$hashesClientSecrets) {
            return $clients;
        }

        return $clients->makeVisible('secret');
    }

    /**
     * Store a new client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Passport\Client|array
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:191',
                'redirect' => ['required', $this->redirectRule],
                'confidential' => 'boolean',
            ]
        );

        if ($validator->fails()) {
            return $this->ajaxResponse(422, 'The given data was invalid.', $validator->errors(), []);
        }

        try {

            $file = $request->file('image_url');
            $paths = "";
            if ($file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $storeName = $fileName;

                $path = base_path('public/images/uploads');
                if (File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $file->move(base_path('public/images/uploads'), $storeName);
                $paths = '/images/uploads/' . $storeName;
            }


            $client = $this->clients->create(
                $request->user()->getAuthIdentifier(),
                $request->name,
                $request->redirect,
                null,
                false,
                false,
                (bool) $request->input('confidential', true)
            );

            $client->image_url = $paths;
            $client->save();

            if (Passport::$hashesClientSecrets) {
                return ['plainSecret' => $client->plainSecret] + $client->toArray();
            }

            return $this->ajaxResponse(200, 'Client created successfully.', [], []);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error([$exception->getFile(), $exception->getLine(), $exception->getMessage()]);
            return $this->ajaxResponse(500, $exception->getMessage(), [], []);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::find($id);
        return view('pages.client-edit', [
            'client' => $client,

        ]);
    }


    /**
     * Update the given client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $clientId
     * @return \Illuminate\Http\Response|\Laravel\Passport\Client
     */
    public function update(Request $request, $clientId)
    {

        $client = $this->clients->findForUser($clientId, $request->user()->getAuthIdentifier());

        if (!$client) {
            return $this->ajaxResponse(404, 'Client not found.', [], []);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:191',
                'redirect' => ['required', $this->redirectRule],
            ]
        );
        if ($validator->fails()) {
            return $this->ajaxResponse(422, 'The given data was invalid.', $validator->errors(), []);
        }
        try {

            $file = $request->file('image_url');
            Log::info($request);
            $paths = $client->image_url;

            if ($file) {

                $fileName = time() . '_' . $file->getClientOriginalName();
                Log::info($fileName);
                $storeName = $fileName;
                $path = base_path('public/images/uploads');
                if (File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $file->move(base_path('public/images/uploads'), $storeName);
                $paths = '/images/uploads/' . $storeName;
            }


            $this->clients->update(
                $client,
                $request->name,
                $request->redirect
            );

            $client->image_url = $paths ?? $client->image_url;
            $client->save();

            return $this->ajaxResponse(200, 'Client updated successfully.', [], []);
        } catch (\Exception $exception) {

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

        $client = DB::table('oauth_clients')->where('id', $id)->first();
        if (!$client) {
            return new Response('', 404);
        }

        DB::table('oauth_clients')->where('id', $id)->delete();
        session()->flash('success', 'Client deleted successfully.');
        return redirect('/client-management');
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
