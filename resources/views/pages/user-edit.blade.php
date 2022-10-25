@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])

<div id="alert">
    @include('components.alert')
</div>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{route('user.update',$user->id)}}" id="uploadForm" role="form" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Update User</p>
                            <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">User Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Name</label>
                                    <input class="form-control" type="text" name="name" value="{{$user->name ?? ''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Email address</label>
                                    <input class="form-control" type="email" name="email" value="{{$user->email ?? ''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Mobile</label>
                                    <input class="form-control" type="text" name="mobile" value="{{$user->mobile}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">User Type</label>
                                    <select class="form-select" name="user_type" aria-label="Default select example">
                                        <option selected disabled>Select Type</option>
                                        <option @if ($user->user_type == 'user')
                                            selected
                                            @endif value="user">user</option>
                                        <option @if ($user->user_type == 'admin')
                                            selected
                                            @endif value="admin">admin</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Password</label>
                                    <input class="form-control" type="password" name="password">
                                </div>
                            </div>

                        </div>
                        <hr class="horizontal dark">
                    </div>
                </form>
            </div>
        </div>

    </div>
    @include('layouts.footers.auth.footer')
</div>
@include('layouts._partial._ajax_form_submit')
<script>
    jQuery("#uploadForm").submit(function(e) {
        e.preventDefault();
        formPost('uploadForm', 'main-submit-button', "{{ route('user.update',$user->id) }}", '{{ url("/user-management") }}')
    });
</script>


@endsection