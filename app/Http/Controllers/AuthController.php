<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        try {
            // Kullanıcı kimlik doğrulama
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Kullanıcıyı al
            $user = JWTAuth::setToken($token)->toUser();
            $expiresAt = Carbon::now()->addMinutes((int)config('jwt.ttl', 60))->toDateTimeString();

            // Token'ı user_token tablosuna ekle
            UserToken::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'token' => $token,
                    'expires_at' => $expiresAt
                ]
            );

            return response()->json([
                'token' => $token,
                'expires_at' => $expiresAt
            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    public function logout()
    {
        try {
            // Kullanıcının mevcut JWT token'ını al ve geçersiz kıl
            JWTAuth::invalidate(JWTAuth::parseToken());

            return response()->json([
                'success' => true,
                'message' => 'User successfully logged out.'
            ]);
        } catch (JWTException $e) {
            // Token geçersiz kılınamıyorsa hata döndür
            return response()->json([
                'success' => false,
                'message' => 'Failed to logout, please try again.'
            ], 500);
        }

    }

}
