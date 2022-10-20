@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@push('css')
@endpush

@include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div id="alert">
    @include('components.alert')
</div>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{url("/oauth/clients")}}" id="uploadForm" role="form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Create Client</p>
                            <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Client Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label"><span class="required">*</span>Client Name</label>
                                    <input class="form-control" type="text" name="name" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label"><span class="required">*</span>Redirect URL</label>
                                    <input class="form-control" type="text" name="redirect" value="">
                                </div>
                            </div>

                        </div>

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
        formPost('uploadForm', 'main-submit-button', '{{ url("/oauth/clients") }}', '{{ url("/client-management") }}')
    });
</script>

@endsection