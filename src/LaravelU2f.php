<?php namespace Lahaxearnaud\U2f;

use App\User;
use Lahaxearnaud\U2f\Models\U2fKey;

class LaravelU2f {

    protected $u2f;

    function __construct ()
    {
        $scheme = \Request::isSecure() ? "https://" : "http://";
        $this->u2f = new \u2flib_server\U2F($scheme . \Request::getHttpHost());
    }

    public function getRegisterData(User $user)
    {

        return $this->u2f->getRegisterData(U2fKey::where('user_id', $user->id)->get()->all());
    }

    public function doRegister(User $user, $registerData, $keyData)
    {
        $reg = $this->u2f->doRegister( $registerData, $keyData);
        $reg->user_id = $user->id;

        return U2fKey::create((array) $reg);
    }

    public function getAuthenticateData(User $user)
    {

        return $this->u2f->getAuthenticateData(U2fKey::where('user_id', $user->id)->get()->all());
    }

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

        if(is_null($U2fKey)) {
            return false;
        }

        $U2fKey->counter = $reg->counter;
        $U2fKey->save();


        \Session::set('otp', true);

        return $U2fKey;
    }

    public function check()
    {
        return \Session::get('otp', false);
    }
}