<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;




class ApiAuthController extends Controller
{
    /**
     * Kullanıcı Girişi (Login)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }
    
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ], 200);
    }
    

    /**
     * Kullanıcı Çıkışı (Logout)
     */
    public function logout(Request $request)
    {
        
        Log::info('Logout request received', [
            'request_headers' => $request->headers->all(),
            'token' => $request->bearerToken(),
            'user_ip' => $request->ip(),
        ]);
    
        
        $user = $request->user();
        Log::info('Attempting to retrieve user', [
            'user' => $user ? $user->toArray() : null,
            'token' => $request->bearerToken(),
        ]);
    
       
        if (!$user) {
            Log::warning('User is null', [
                'token' => $request->bearerToken(),
                'authenticated' => false,
                'request_headers' => $request->headers->all(),
            ]);
            return response()->json(['message' => 'User is not authenticated or token not found'], 401);
        }
    
        
        $currentToken = $user->currentAccessToken();
        Log::info('Checking current access token', [
            'current_token' => $currentToken ? $currentToken->toArray() : null,
        ]);
    
        
        if ($currentToken) {
            $currentToken->delete();
            Log::info('Logout successful', [
                'user_id' => $user->id,
            ]);
            return response()->json(['message' => 'Logout successful'], 200);
        } else {
            Log::warning('No valid access token found for user', [
                'user_id' => $user->id,
                'token' => $request->bearerToken(),
            ]);
            return response()->json(['message' => 'User is not authenticated or token not found'], 401);
        }
    }
    
    
}
