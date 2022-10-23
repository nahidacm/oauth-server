@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
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
                        <h6>Users</h6>
                    </div>
                </div>
                <div style="padding: 12px;" class="col-md-2">
                    <a href="/user-create" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New User</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            @if( count($data) > 0 )
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Mobile</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $user)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div>
                                            <h6 class="mb-0 text-sm">{{$user->name}}</h6>
                                        </div>

                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{$user->email ?? ''}}</p>
                                </td>

                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{$user->mobile ?? ''}}</p>
                                </td>



                                <td class="align-middle text-end">
                                    <a href="{{url('user-edit', $user->id)}}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit User">
                                        <i class="fas fa-user-edit text-secondary"></i>
                                    </a>
                                    <span>

                                        <a href="javascript::void(0)" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Delete User">
                                            <i data-id="{{$user->id}}" class="del cursor-pointer fas fa-trash text-secondary"></i>


                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        @else
                        <div style="text-align:center" id="not-found">No User found </div>
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
            if (!confirm("Do you want to delete ?")) {
                return false;
            } else {
                var dataId = $(this).data("id");
                window.location.href = "/user-delete/" + dataId;
            }
        });
    });
</script>


@endsection