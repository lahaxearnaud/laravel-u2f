<?php
/**
 * User: LAHAXE Arnaud <alahaxe@boursorama.fr>
 * Date: 18/05/2015
 * Time: 17:49
 * FileName : u2f.php
 * Project : laravel-u2f
 */

return [
    /*
     * Enable the u2f middleware, if false the middleware will not redirect to the u2f authentication page
     */
    'enable' => true,

    /*
     * Do not redirect user without u2f key to the u2fauthentication page after login
     */
    'byPassUserWithoutKey' => true,

    /*
     * Controller configuration
     */
    'register' => [
        /*
         * the template to load for the registration page
         */
        'view' => 'u2f::register',

        /*
         * the route to redirect after a successful key registration (default /)
         */
        'postSuccessRedirectRoute' => '',

    ],

    'authenticate' => [
        /*
         * the template to load for the authentication page
         */
        'view' => 'u2f::authentication',

        /*
         * the route to redirect after a successful key authentication (default /)
         */
        'postSuccessRedirectRoute' => '',
    ]
];