<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class JwtAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            // Token'ı doğrula ve kullanıcıyı al
            $user = JWTAuth::setToken($token)->toUser();
            
            // Token'ı user_token tablosunda kontrol et
            $storedToken = UserToken::where('user_id', $user->id)->where('token', $token)->first();
            if (!$storedToken) {
                return response()->json(['error' => 'Token is invalid'], 401);
            }

            Auth::setUser($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        }

        return $next($request);
    }
}
