<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class RoleAuthorization extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
{
    try {
        logger(JWTAuth::parseToken());
        $user = JWTAuth::parseToken()->authenticate();
        $request->merge(['user' => $user]);
        logger($user);
    } catch (TokenExpiredException $e) {
        return $this->unauthorized('Your token has expired. Please, login again.');
    } catch (TokenInvalidException $e) {
        return $this->unauthorized('Your token is invalid. Please, login again.');
    }catch (JWTException $e) {
        return $this->unauthorized('Please, attach a Bearer Token to your request');
    }
    if ($user && in_array($user->role, $roles)) {
        return $next($request);
    }

    return $this->unauthorized();
}

private function unauthorized($message = null){
    return response()->json([
        'message' => $message ? $message : 'You are unauthorized to access this resource',
        'success' => false
    ], 401);
}
}
