<?php namespace Lahaxearnaud\U2f\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Lahaxearnaud\U2f\LaravelU2f;

class U2f
{

    /**
     * @var LaravelU2f
     */
    protected $u2f;

    function __construct (LaravelU2f $u2f)
    {
        $this->u2f = $u2f;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(!$this->u2f->check()) {
            return redirect('auth/u2f/auth');
        }

        /** @var Response $response */
        return $next($request);
    }
}
