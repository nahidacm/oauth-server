<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <title>{{ config('app.name') }} - Authorization</title>

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <style>
        .passport-authorize .container {
            margin-top: 30px;
        }

        .passport-authorize .scopes {
            margin-top: 20px;
        }

        .passport-authorize .buttons {
            margin-top: 25px;
            text-align: center;
        }

        .passport-authorize .btn {
            width: 125px;
        }

        .passport-authorize .btn-approve {
            margin-right: 15px;
        }

        .passport-authorize form {
            display: inline;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;

        }
    </style>
</head>

<body class="passport-authorize">
    <div class="container">


        <div class="row justify-content-center">
            <div class="col-md-6" style="left: 269px;top: 150px;border: 1px solid;padding: 22px;border-radius: 11px;">
                <div class="card card-default">
                    <div style="text-align: center;" class="card-header">
                        Authorization Request
                    </div>
                    <div class="card-body">
                        <!-- Introduction -->
                        <p style="text-align: center;"><strong>{{ $client->name }}</strong> is requesting permission to access your account.</p>

                        <!-- Scope List -->
                        @if (count($scopes) > 0)
                        <div class="scopes">
                            <p style="text-align: center;"><strong>This application will be able to:</strong></p>

                            <ul>
                                @foreach ($scopes as $scope)
                                <li>{{ $scope->description }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if($client->image_url)
                        <div>
                            <img height="40px" width="40px" style="border-radius: 50%;text-align: center;" src="{{ $client->image_url }}" class="center avatar avatar-sm me-3">
                        </div>
                        @endif

                        <div class="buttons">
                            <!-- Authorize Button -->
                            <form method="post" action="{{ route('passport.authorizations.approve') }}">
                                @csrf

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                                <button type="submit" class="btn btn-success btn-approve">Authorize</button>

                            </form>

                            <!-- Cancel Button -->
                            <form method="post" action="{{ route('passport.authorizations.deny') }}">
                                @csrf
                                @method('DELETE')

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                                <button class="btn btn-danger">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>