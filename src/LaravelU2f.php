<?php namespace Lahaxearnaud\U2f;

use App\User;
use Lahaxearnaud\U2f\Models\U2fKey;

/**
 * Class LaravelU2f
 *
 *
 *
 * @package Lahaxearnaud\U2f
 * @author  LAHAXE Arnaud
 */
class LaravelU2f {

    /**
     * @var \u2flib_server\U2F
     */
    protected $u2f;

    /**
     *
     */
    public function __construct()
    {
        $scheme = \Request::isSecure() ? "https://" : "http://";
        $this->u2f = new \u2flib_server\U2F($scheme . \Request::getHttpHost());
    }

    /**
     * @author LAHAXE Arnaud
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function getRegisterData(User $user)
    {

        return $this->u2f->getRegisterData(U2fKey::where('user_id', $user->id)->get()->all());
    }

    /**
     * @author LAHAXE Arnaud
     *
     * @param \App\User $user
     * @param           $registerData
     * @param           $keyData
     *
     * @return mixed
     */
    public function doRegister(User $user, $registerData, $keyData)
    {
        $reg = $this->u2f->doRegister($registerData, $keyData);
        $reg->user_id = $user->id;

        return U2fKey::create((array) $reg);
    }

    /**
     * @author LAHAXE Arnaud
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function getAuthenticateData(User $user)
    {

        return $this->u2f->getAuthenticateData(U2fKey::where('user_id', $user->id)->get()->all());
    }

    /**
     * @author LAHAXE Arnaud
     *
     * @param \App\User $user
     * @param           $authData
     * @param           $keyData
     *
     * @return bool
     */
    public function doAuthenticate(User $user, $authData, $keyData)
    {

        $reg = $this->u2f->doAuthenticate(
            $authData,
            U2fKey::where('user_id', $user->id)->get()->all(),
            $keyData
        );


        $U2fKey = U2fKey::where([
            'user_id' => $user->id,
            'publicKey' => $reg->publicKey
        ])->first();

        if (is_null($U2fKey)) {
            return false;
        }

        $U2fKey->counter = $reg->counter;
        $U2fKey->save();


        \Session::set('u2f', true);

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
        return \Session::get('u2f', false);
    }
}
