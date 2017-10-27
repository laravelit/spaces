<?php

namespace Laravelit\Spaces\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Laravelit\Spaces\Exceptions\RoleDeniedException;

class VerifySpaces
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param int|string $role
     * @return mixed
     * @throws \Laravelit\Spaces\Exceptions\RoleDeniedException
     */
    public function handle($request, Closure $next, $space)
    {
        if ($this->auth->check() && $this->auth->user()->is($space)) {
            return $next($request);
        }

        throw new RoleDeniedException($space);
    }
}
