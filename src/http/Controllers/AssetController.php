<?php namespace Lahaxearnaud\U2f\Http\Controllers;

/**
 * Created by PhpStorm.
 * Author LAHAXE Arnaud <lahaxe.arnaud@gmail.com>
 * Date: 18/05/15
 * Time: 07:32
 */

use Illuminate\Http\Response;

use App\Http\Controllers\Controller;

class AssetController extends Controller{

    public function js ()
    {

        return new Response(

            \File::get(__DIR__ . '/../../../resources/js/u2f.js'), 200, array(
                'Content-Type' => 'text/javascript',
            )
        );
    }
}
