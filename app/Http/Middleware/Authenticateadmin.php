<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticateadmin extends Middleware
{

    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        
            if ($this->auth->guard('user-api')->check()) {
                return $this->auth->shouldUse('user-api');
            }
        

        $this->unauthenticated($request, ['user-api']);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('userlog');
    }
}
