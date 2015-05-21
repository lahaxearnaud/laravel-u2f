<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="fr" />
    <script src="{!! secure_asset('vendor/u2f/u2f.js') !!}"></script>
    <script src="{!! secure_asset('vendor/u2f/app.js') !!}"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container" style="margin-top:30px">
    <div class="col-md-6 col-md-offset-3">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">{{ trans('u2f::messages.auth.title') }}</h1>
            </div>
            <div class="panel-body" style="padding: 5px">

                <div class="alert alert-danger" role="alert" id="error" style="display: none"></div>
                <div class="alert alert-success" role="alert" id="success" style="display: none">
                    {{ trans('u2f::messages.success') }}
                </div>

                <div align="center">
                    <img src="https://ssl.gstatic.com/accounts/strongauth/Challenge_2SV-Gnubby_graphic.png" alt=""/>
                </div>

                <h3>
                    {{ trans('u2f::messages.insertKey') }}
                </h3>

                <p>
                    {{ trans('u2f::messages.buttonAdvise') }}
                    <br>
                    {{ trans('u2f::messages.noButtonAdvise') }}
                </p>
            </div>
        </div>
    </div>
</div>


{!! Form::open(array('route' => 'u2f.auth', 'id' => 'form')) !!}
{!! Form::hidden('authentication', '', ['id' => 'authentication']) !!}
{!! Form::close() !!}

<script type="text/javascript">
        var req = {!! json_encode($authenticationData) !!};

        var errors = {
            1: "{{ trans('u2f::errors.other_error') }}",
            2: "{{ trans('u2f::errors.bad_request') }}",
            3: "{{ trans('u2f::errors.configuration_unsupported') }}",
            4: "{{ trans('u2f::errors.device_ineligible') }}",
            5: "{{ trans('u2f::errors.timeout') }}"
        };

        u2fClient.login(req, errors);
</script>
</body>
</html>
