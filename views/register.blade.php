<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="fr" />
    <script src="chrome-extension://pfboblefjcgdjicmnffhdgionmgcdmne/u2f-api.js"></script>

    <script>
        setTimeout(function() {
            var sigs = {!! json_encode($currentKeys) !!};
            var req = {!! json_encode($registerData) !!};

            u2f.register([req], sigs, function(data) {
                var form = document.getElementById('form');
                var reg = document.getElementById('register');
                console.log("Register callback", data);
                if(data.errorCode) {
                    alert("registration failed with errror: " + data.errorCode);
                    return;
                }
                reg.value = JSON.stringify(data);
                form.submit();
            });
        }, 1000);
    </script>
</head>
<body>


<hr/>
{!! json_encode($currentKeys) !!}
<hr/>
{!! json_encode($registerData) !!}

{!! Form::open(array('route' => 'otp.register', 'id' => 'form')) !!}
    {!! Form::text('register', '', ['id' => 'register']) !!}
    {!! Form::submit('Enrol') !!}
{!! Form::close() !!}

</body>
</html>