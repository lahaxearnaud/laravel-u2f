<?php namespace Lahaxearnaud\U2f\Http\Controllers;

use App\Event;
use App\Http\Controllers\Controller;
use Lahaxearnaud\U2f\U2f as LaravelU2f;
use Illuminate\Config\Repository as Config;

use Illuminate\Http\Request;



class U2fController extends Controller
{

    /**
     * @var LaravelU2f
     */
    protected $u2f;

    /**
     * @var Config
     */
    protected  $config;

    /**
     * @param LaravelU2f $u2f
     * @param Config $config
     */
    public function __construct(LaravelU2f $u2f, Config $config)
    {

        $this->u2f = $u2f;
        $this->config = $config;
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
        \Event::fire('u2f.register.data', [ 'user' => \Auth::user() ]);

        session(['u2f.registerData' => $req]);

        return view($this->config->get('u2f.register.view'))
            ->with('currentKeys', $sigs)
            ->with('registerData', $req);

    }

    /**
     * @author LAHAXE Arnaud
     *
     *
     * @return mixed
     */
    public function register(Request $request)
    {
        try {
            $key = $this->u2f->doRegister(\Auth::user(), session('u2f.registerData'), json_decode($request->get('register')));
            \Event::fire('u2f.register', [ 'u2fKey' => $key, 'user' => \Auth::user() ]);
            session()->forget('u2f.registerData');

            if ($this->config->get('u2f.register.postSuccessRedirectRoute')) {

                return \Redirect::route($this->config->get('u2f.register.postSuccessRedirectRoute'));
            } else {
                return redirect('/');
            }

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

        if($this->u2f->check()) {
            return $this->redirectAfterSuccessAuth();
        }

        $req = $this->u2f->getAuthenticateData(\Auth::user());
        \Event::fire('u2f.authentication.data', [ 'user' => \Auth::user() ]);

        session(['u2f.authenticationData' => $req]);

        return view($this->config->get('u2f.authenticate.view'))
            ->with('authenticationData', $req);
    }

    /**
     * @author LAHAXE Arnaud
     *
     *
     * @return mixed
     */
    public function auth(Request $request)
    {

        try {
            $key = $this->u2f->doAuthenticate(\Auth::user(), session('u2f.authenticationData'), json_decode($request->get('authentication')));
            \Event::fire('u2f.authentication', [ 'u2fKey' => $key, 'user' => \Auth::user() ]);
            session()->forget('u2f.authenticationData');

            return $this->redirectAfterSuccessAuth();

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            return \Redirect::route('u2f.auth.data');
        }
    }

    protected function redirectAfterSuccessAuth()
    {

        if (strlen($this->config->get('u2f.authenticate.postSuccessRedirectRoute'))) {

            return \Redirect::intended($this->config->get('u2f.authenticate.postSuccessRedirectRoute'));
        } else {
            return \Redirect::intended('/');
        }
    }
}
