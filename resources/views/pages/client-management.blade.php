@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Client Management'])
<div class="row mt-4 mx-4">
    <div class="col-12">

        <div class="card mb-4">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-header pb-0">
                        <h6>Clients</h6>
                    </div>
                </div>
                <div style="padding: 12px;" class="col-md-2">
                    <a href="/client-create" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New Client</a>
                </div>
            </div>


            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Client ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Secret</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Redirect URL</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $client)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div>
                                            <h6 class="mb-0 text-sm">{{$client->id}}</h6>
                                        </div>

                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{$client->name ?? ''}}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{$client->secret ?? ''}}</p>
                                </td>



                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{$client->redirect ?? ''}}</p>
                                </td>

                                <td class="align-middle text-end">
                                    <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                        <p class="text-sm font-weight-bold mb-0">Edit</p>
                                        <p class="text-sm font-weight-bold mb-0 ps-2">Delete</p>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth.footer')
@endsection