/**
 * Created by arnaud on 18/05/15.
 */

window.u2fClient = {

    register: function(req, sigs, callback) {
        u2f.register([req], sigs, callback);
    },

    authentification: function(req) {
        u2f.sign(req, callback);
    }
};