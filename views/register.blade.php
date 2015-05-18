<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="fr" />
    <script src="{!! route('u2f.assets.js') !!}"></script>
</head>
<body>

<h1>Register u2f key</h1>

{!! Form::open(array('route' => 'u2f.register', 'id' => 'form')) !!}
    {!! Form::hidden('register', '', ['id' => 'register']) !!}
{!! Form::close() !!}

<script type="text/javascript">
    var sigs = {!! json_encode($currentKeys) !!};
    var req = {!! json_encode($registerData) !!};

    setTimeout(function() {
        u2f.register([req], sigs, function(data) {
            var form = document.getElementById('form');
            var reg = document.getElementById('register');
            console.log("Register callback", data);
            if(data.errorCode) {
                alert("registration failed with error: " + data.errorCode);
                return;
            }
            reg.value = JSON.stringify(data);
            form.submit();
        });
    }, 1000);
</script>
</body>
</html>
