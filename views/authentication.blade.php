<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="fr" />
    <script src="{!! route('u2f.assets.js') !!}"></script>
</head>
<body>


<h1>Auth by key</h1>

<img src="https://developers.yubico.com/U2F/u2f_workflow.png" alt="U2F Workflow"/>

{!! Form::open(array('route' => 'u2f.auth', 'id' => 'form')) !!}
{!! Form::hidden('authentication', '', ['id' => 'authentication']) !!}
{!! Form::close() !!}


<script type="text/javascript">
    setTimeout(function() {
        var req = {!! json_encode($authenticationData) !!};

        u2f.sign(req, function(data) {
            var form = document.getElementById('form');
            var auth = document.getElementById('authentication');
            console.log("Authenticate callback", data);
            auth.value=JSON.stringify(data);
            form.submit();
        });
    }, 1000);
</script>
</body>
</html>
