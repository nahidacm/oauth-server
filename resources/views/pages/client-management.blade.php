@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Client Management'])
<style>

</style>
<div class="row mt-4 mx-4">

    <div class="col-12">
        @if($errors->any())
        <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
            <span class="alert-text text-white">
                {{$errors->first()}}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="fa fa-close" aria-hidden="true"></i>
            </button>
        </div>
        @endif
        @if(session('success'))
        <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
            <span class="alert-text text-white">
                {{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="fa fa-close" aria-hidden="true"></i>
            </button>
        </div>
        @endif

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
                    <table class="table align-items-center mb-0 table-wrapper-scroll-y fl-table">
                        <thead>
                            @if( count($data) > 0 )
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Client ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Secret</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Redirect URL</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Image</th>
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
                                <td>
                                    @if($client->image_url)
                                    <div>
                                        <img src="{{ $client->image_url }}" class="avatar avatar-sm me-3">
                                    </div>
                                    @endif
                                </td>

                                <td class="align-middle text-end">
                                    <a href="{{url('client-edit', $client->id)}}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Client">
                                        <i class="fas fa-user-edit text-secondary"></i>
                                    </a>
                                    <span>


                                        <a href="javascript::void(0)" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Delete Client">
                                            <i data-id="{{$client->id}}" class="del cursor-pointer fas fa-trash text-secondary"></i>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        @else
                        <div style="text-align:center" id="not-found">No Client found </div>
                        @endif


                    </table>
                </div>
            </div>
            {{-- Pagination --}}
            <div class="d-flex justify-content-end">
                {!! $data->links() !!}
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth.footer')
<script>
    $(document).ready(function() {

        $(".del").click(function() {
            if (!confirm("Do you want to delete")) {
                return false;
            } else {
                var dataId = $(this).data("id");
                window.location.href = "/client-delete/" + dataId;

            }


        });
    });
</script>
@endsection