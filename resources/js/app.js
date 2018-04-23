/**
 * Created by arnaud on 21/05/15.
 */

u2fClient = {
    login: function (request, errors) {
        setTimeout(function () {

            u2f.sign(request[0].appId, request[0].challenge, request, function (data) {
                var alert = null;

                if (data.errorCode) {
                    alert = document.getElementById('error');
                    alert.innerHTML = errors[data.errorCode];
                    alert.style.display = 'block';

                    return;
                }

                var form = document.getElementById('form');
                var auth = document.getElementById('authentication');

                alert = document.getElementById('success');
                alert.style.display = 'block';
                auth.value = JSON.stringify(data);
                form.submit();
            });
        }, 1000);
    },

    register: function (request, keys, errors) {
        setTimeout(function () {
            u2f.register(request.appId, [request], keys, function (data) {
                var form = document.getElementById('form');
                var reg = document.getElementById('register');
                var alert = null;

                if (data.errorCode) {
                    alert = document.getElementById('error');
                    alert.innerHTML = errors[data.errorCode];
                    alert.style.display = 'block';

                    return;
                }

                alert = document.getElementById('success');
                alert.style.display = 'block';

                reg.value = JSON.stringify(data);
                form.submit();
            });
        }, 1000);
    }
}
