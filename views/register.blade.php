<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="fr" />
    <script src="{!! route('u2f.assets.js') !!}"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container" style="margin-top:30px">
    <div class="col-md-6 col-md-offset-3">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">Enregistrement d'une clef de sécurité</h1>
            </div>
            <div class="panel-body" style="padding: 5px">

                <div align="center">
                    <img src="https://ssl.gstatic.com/accounts/strongauth/Challenge_2SV-Gnubby_graphic.png" alt=""/>
                </div>

                <h3>
                    Insérez votre clé de sécurité.
                </h3>

                <p>
                    Si votre clé de sécurité comporte un bouton, appuyez sur celui-ci.
                    <br>
                    Si ce n'est pas le cas, retirez-la, puis insérez-la à nouveau.
                </p>
            </div>
        </div>
    </div>
</div>

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
