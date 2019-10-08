<?php namespace Lahaxearnaud\U2f;

use Lahaxearnaud\U2f\Models\U2fKey;
use Illuminate\Support\Facades\Request;
use Illuminate\Config\Repository as Config;
use Illuminate\Session\SessionManager as Session;
use Illuminate\Contracts\Auth\Authenticatable as User;

/**
 * Class LaravelU2f
 *
 *
 *
 * @package Lahaxearnaud\U2f
 * @author  LAHAXE Arnaud
 */
class U2f {
    /**
     * @var \u2flib_server\U2F
     */
    protected $u2f;

    /**
     * @var Config
     */
    protected  $config;

    /**
     * @var Session
     */
    protected  $session;

    /**
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Config $config, Session $session)
    {
        $scheme = Request::isSecure() ? "https://" : "http://";
        $this->u2f = new \u2flib_server\U2F($scheme . Request::getHttpHost());
        $this->config = $config;
        $this->session = $session;
    }

    /**
     * @author LAHAXE Arnaud
     *
     * @param User $user
     *
     * @return mixed
     */
    public function getRegisterData(User $user)
    {
        return $this->u2f->getRegisterData(U2fKey::where('user_id', $user->getAuthIdentifier())->get()->all());
    }

    /**
     * @author LAHAXE Arnaud
     *
     * @param User $user
     * @param           $registerData
     * @param           $keyData
     *
     * @return mixed
     */
    public function doRegister(User $user, $registerData, $keyData)
    {
        $reg = $this->u2f->doRegister($registerData, $keyData);
        $reg->user_id = $user->getAuthIdentifier();

        return U2fKey::create((array) $reg);
    }

    /**
     * @author LAHAXE Arnaud
     *
     * @param User $user
     *
     * @return mixed
     */
    public function getAuthenticateData(User $user)
    {
        return $this->u2f->getAuthenticateData(U2fKey::where('user_id', $user->getAuthIdentifier())->get()->all());
    }

    /**
     * @author LAHAXE Arnaud
     *
     * @param User $user
     * @param           $authData
     * @param           $keyData
     *
     * @return bool
     */
    public function doAuthenticate(User $user, $authData, $keyData)
    {
        $reg = $this->u2f->doAuthenticate(
            $authData,
            U2fKey::where('user_id', $user->getAuthIdentifier())->get()->all(),
            $keyData
        );

        $U2fKey = U2fKey::where([
            'user_id' => $user->getAuthIdentifier(),
            'publicKey' => $reg->publicKey
        ])->first();

        if (is_null($U2fKey)) {
            return false;
        }

        $U2fKey->counter = $reg->counter;
        $U2fKey->save();

        session([$this->config->get('u2f.sessionU2fName') => true]);

        return $U2fKey;
    }

    /**
     * @author LAHAXE Arnaud
     *
     *
     * @return mixed
     */
    public function check()
    {
        return $this->session->get($this->config->get('u2f.sessionU2fName'), false);
    }
}
