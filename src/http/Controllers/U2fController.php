<?php namespace Lahaxearnaud\U2f\Http\Controllers;

use App\Event;
use App\Http\Controllers\Controller;
use Lahaxearnaud\U2f\LaravelU2f;

class U2fController extends Controller
{

    /**
     * @var LaravelU2f
     */
    protected $u2f;

    public function __construct(LaravelU2f $u2f)
    {
        $this->u2f = $u2f;
    }

    public function registerData()
    {
        list($req, $sigs) = $this->u2f->getRegisterData(\Auth::user());

        \Session::set('registerData', $req);

        return view('u2f::register')
            ->with('currentKeys', $sigs)
            ->with('registerData', $req);

    }

    public function register()
    {
        try {
            $key = $this->u2f->doRegister(\Auth::user(), \Session::get('registerData'), json_decode(\Input::get('register')));
            \Event::fire('u2f.register', [ 'u2fKey' => $key ]);

            return redirect('/');

        } catch (\Exception $e) {

            return \Redirect::route('u2f.register.data');
        }
    }

    public function authData()
    {
        $req = $this->u2f->getAuthenticateData(\Auth::user());

        \Session::set('authentificationData', $req);

        return view('u2f::authentification')
            ->with('authentificationData', $req);
    }

    public function auth()
    {
        try {
            $this->u2f->doAuthenticate(\Auth::user(), \Session::get('authentificationData'), json_decode(\Input::get('authentification')));

            return redirect('/');

        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());

            return \Redirect::route('u2f.auth.data');
        }
    }
}
