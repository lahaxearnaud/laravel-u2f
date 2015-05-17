<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="fr" />
    <script src="chrome-extension://pfboblefjcgdjicmnffhdgionmgcdmne/u2f-api.js"></script>

    <script>
            var req = {!! json_encode($authentificationData) !!};

            setTimeout(function() {
                console.log("sign: ", req);
                u2f.sign(req, function(data) {
                    var form = document.getElementById('form');
                    var auth = document.getElementById('authentification');
                    console.log("Authenticate callback", data);
                    auth.value=JSON.stringify(data);
                    form.submit();
                });
            }, 1000);
    </script>
</head>
<body>


<hr/>
<hr/>
<pre>
{!! json_encode(Session::all()) !!}
</pre>

{!! Form::open(array('route' => 'otp.auth', 'id' => 'form')) !!}
{!! Form::text('authentification', '', ['id' => 'authentification']) !!}
{!! Form::submit('Enrol') !!}
{!! Form::close() !!}

</body>
</html>