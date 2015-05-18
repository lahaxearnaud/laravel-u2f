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

    /**
     * @param \Lahaxearnaud\U2f\LaravelU2f $u2f
     */
    public function __construct(LaravelU2f $u2f)
    {
        $this->u2f = $u2f;
    }

    /**
     * @author LAHAXE Arnaud
     *
     *
     * @return mixed
     */
    public function registerData()
    {
        list($req, $sigs) = $this->u2f->getRegisterData(\Auth::user());
        \Event::fire('u2f.register.data', [ 'user' => \Auth::user()]);

        \Session::set('registerData', $req);

        return view('u2f::register')
            ->with('currentKeys', $sigs)
            ->with('registerData', $req);

    }

    /**
     * @author LAHAXE Arnaud
     *
     *
     * @return mixed
     */
    public function register()
    {
        try {
            $key = $this->u2f->doRegister(\Auth::user(), \Session::get('registerData'), json_decode(\Input::get('register')));
            \Event::fire('u2f.register', [ 'u2fKey' => $key, 'user' => \Auth::user()]);

            return redirect('/');

        } catch (\Exception $e) {

            return \Redirect::route('u2f.register.data');
        }
    }

    /**
     * @author LAHAXE Arnaud
     *
     *
     * @return mixed
     */
    public function authData()
    {
        $req = $this->u2f->getAuthenticateData(\Auth::user());
        \Event::fire('u2f.authentification.data', [ 'user' => \Auth::user()]);

        \Session::set('authentificationData', $req);

        return view('u2f::authentification')
            ->with('authentificationData', $req);
    }

    /**
     * @author LAHAXE Arnaud
     *
     *
     * @return mixed
     */
    public function auth()
    {
        try {
            $key = $this->u2f->doAuthenticate(\Auth::user(), \Session::get('authentificationData'), json_decode(\Input::get('authentification')));
            \Event::fire('u2f.authentification', [ 'u2fKey' => $key, 'user' => \Auth::user()]);

            return redirect('/');

        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());

            return \Redirect::route('u2f.auth.data');
        }
    }
}
