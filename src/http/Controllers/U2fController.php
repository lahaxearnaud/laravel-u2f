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

        \Session::set('u2f.registerData', $req);

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
            $key = $this->u2f->doRegister(\Auth::user(), \Session::get('u2f.registerData'), json_decode(\Input::get('register')));
            \Event::fire('u2f.register', [ 'u2fKey' => $key, 'user' => \Auth::user()]);
            \Session::forget('u2f.registerData');

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
        \Event::fire('u2f.authentication.data', [ 'user' => \Auth::user()]);

        \Session::set('u2f.authenticationData', $req);

        return view('u2f::authentication')
            ->with('authenticationData', $req);
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
            $key = $this->u2f->doAuthenticate(\Auth::user(), \Session::get('u2f.authenticationData'), json_decode(\Input::get('authentication')));
            \Event::fire('u2f.authentication', [ 'u2fKey' => $key, 'user' => \Auth::user()]);
            \Session::forget('u2f.authenticationData');

            return redirect('/');

        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());

            return \Redirect::route('u2f.auth.data');
        }
    }
}
