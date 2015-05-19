<?php namespace Lahaxearnaud\U2f\Http\Controllers;

use Illuminate\Http\Response;

use App\Http\Controllers\Controller;

/**
 * Class AssetController
 *
 *
 *
 * @package Lahaxearnaud\U2f\Http\Controllers
 * @author  LAHAXE Arnaud
 */
class AssetController extends Controller {

    public function js()
    {

        return new Response(

            \File::get(__DIR__ . '/../../../resources/js/u2f.js'), 200, array(
                'Content-Type' => 'text/javascript',
            )
        );
    }
}
