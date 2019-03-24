<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{!! secure_asset('vendor/u2f/u2f.js') !!}"></script>
    <script src="{!! secure_asset('vendor/u2f/app.js') !!}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('u2f::messages.auth.title') }}</div>

                            <div class="card-body">
                                <div class="alert alert-danger d-none" role="alert" id="u2f-error"></div>
                                <div class="alert alert-success d-none" role="alert" id="u2f-success">
                                    {{ __('u2f::messages.success') }}
                                </div>

                                <div align="center">
                                    <img src="https://ssl.gstatic.com/accounts/strongauth/Challenge_2SV-Gnubby_graphic.png" alt=""/>
                                </div>

                                <h3>
                                    {{ __('u2f::messages.insertKey') }}
                                </h3>

                                <p>
                                    {{ __('u2f::messages.buttonAdvise') }}
                                    <br>
                                    {{ __('u2f::messages.noButtonAdvise') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('u2f.auth') }}" id="form">
                @csrf
                <input type="hidden" name="authentication" id="authentication">
            </form>
        </main>
    </div>

    <script>
        var req = {!! json_encode($authenticationData) !!};

        var errors = {
            1: "{{ __('u2f::errors.other_error') }}",
            2: "{{ __('u2f::errors.bad_request') }}",
            3: "{{ __('u2f::errors.configuration_unsupported') }}",
            4: "{{ __('u2f::errors.device_ineligible') }}",
            5: "{{ __('u2f::errors.timeout') }}"
        };

        u2fClient.login(req, errors);
    </script>
</body>
</html>
