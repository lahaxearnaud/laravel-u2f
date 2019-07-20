/**
 * Created by arnaud on 21/05/15.
 */

var u2fClient = {
    login: function (request, errors) {
        setTimeout(function () {

            u2f.sign(request[0].appId, request[0].challenge, request, function (data) {
                var alert = null;

                if (data.errorCode) {
                    if (alert) {
                        alert = document.getElementById('u2f-error');
                        alert.innerHTML = errors[data.errorCode];
                        alert.classList.toggle('d-none');
                        alert.classList.toggle('d-block');
                    }

                    return;
                }

                var form = document.getElementById('form');
                var auth = document.getElementById('authentication');

                alert = document.getElementById('u2f-success');
                if (alert) {
                    alert.classList.toggle('d-none');
                    alert.classList.toggle('d-block');
                }
                auth.value = JSON.stringify(data);
                form.submit();
            });
        }, 1000);
    },

    register: function (request, keys, errors) {
        setTimeout(function () {
            var registerRequests = [{version: request.version, challenge: request.challenge, attestation: 'direct'}];

            u2f.register(request.appId, registerRequests, keys, function (data) {
                var form = document.getElementById('form');
                var reg = document.getElementById('register');
                var alert = null;

                if (data.errorCode) {
                    alert = document.getElementById('u2f-error');
                    alert.innerHTML = errors[data.errorCode];
                    alert.classList.toggle('d-none');
                    alert.classList.toggle('d-block');

                    return;
                }

                alert = document.getElementById('u2f-success');
                alert.classList.toggle('d-none');
                alert.classList.toggle('d-block');

                reg.value = JSON.stringify(data);
                form.submit();
            });
        }, 1000);
    }
};
