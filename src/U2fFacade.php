<?php namespace Lahaxearnaud\U2f;

use Illuminate\Support\Facades\Facade;

class U2fFacade extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'u2f'; }
}
