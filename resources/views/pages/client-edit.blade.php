@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@push('css')
@endpush

@include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<style>
    input[type="file"] {
        display: block;
    }

    .left-sidenav-menu {
        padding: 0px !important;
        margin-top: 0px !important;
    }

    .imageThumb {
        max-height: 200px;
        border: 2px solid;
        padding: 1px;
        cursor: pointer;
    }

    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }

    .remove {
        display: block;
        background: #444;
        border: 1px solid black;
        color: white;
        text-align: center;
        cursor: pointer;
    }

    .remove:hover {
        background: white;
        color: black;
    }

    .profile_update .nav-tabs {
        border: 0 none;
    }

    .profile_update .nav-tabs .nav-item {
        -webkit-box-flex: 1;
        flex-grow: 1;
        max-width: 100%;
        margin-right: 5px;
    }

    .nav-tabs .nav-item {
        margin-bottom: -1px;
    }

    .profile_update .nav-tabs .nav-item .nav-link {
        display: block;
        text-align: center;
        background: #dce1e9;
        border: 0 none !important;
        border-radius: 5px !important;
        overflow: hidden;
        padding: 8px 0;
        font-weight: 500;
        text-transform: uppercase;
    }

    .select2-container .select2-selection--single {

        height: 40px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 36px !important;
    }

    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #d2d6da;
        border-radius: 10px;
    }
</style>
<div id="alert">
    @include('components.alert')
</div>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="/client-update/{{$client->id}}" id="uploadForm" role="form" method="POST" enctype="multipart/form-data">
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
                                    <input class="form-control" type="text" name="name" value="{{$client->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label"><span class="required">*</span>Redirect URL</label>
                                    <input class="form-control" type="text" name="redirect" value="{{$client->redirect}}">
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-name" class="form-control-label">{{ __('Image') }}</label>
                                <input class="form-control" type="file" name="image_url" placeholder="Choose image" id="files">
                                @error('icon_url')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                                @if(isset($client->image_url))
                                <span class="pip">
                                    <img class="imageThumb" src="{{ $client->image_url }}" title="" />
                                    <span data="1" class="remove">Remove image</span>
                                </span>
                                @endif
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
    $(document).ready(function() {
        $('.remove').click(function(e) {
            $(this).parent(".pip").remove();

        });

        if (window.File && window.FileList && window.FileReader) {
            $("#files").on("change", function(e) {
                var files = e.target.files,
                    filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    var fileReader = new FileReader();
                    fileReader.onload = (function(e) {
                        var file = e.target;
                        $("<span class=\"pip\">" +
                            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                            "<br/><span class=\"remove\">Remove image</span>" +
                            "</span>").insertAfter("#files");
                        $(".remove").click(function() {
                            $(this).parent(".pip").remove();
                        });

                    });
                    fileReader.readAsDataURL(f);
                }

            });
        } else {
            alert("Your browser doesn't support to File API")
        }
    });
</script>

<script>
    jQuery("#uploadForm").submit(function(e) {
        e.preventDefault();
        formPost('uploadForm', 'main-submit-button', '{{ route("update",$client->id) }}', '{{ url("/client-management") }}')
    });
</script>

@endsection