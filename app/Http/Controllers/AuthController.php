<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Passport;
use Carbon\Carbon;
use App\Models\UserAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Config;




class AuthController extends Controller
{

    public function generateApiCredentials(Request $request)
    {
        $user = UserAuth::findOrFail($request->id);
        
        $apiKey = Str::random(20);
        $apiSecret = substr(base64_encode(Str::random(40)), 0, 50);

        $user->forceFill([
            'api_key' => $apiKey,
            'secret_key' => $apiSecret,
        ])->save();

        return response()->json([
            'api_key' => $apiKey,
            'secret_key' => $apiSecret,
        ]);
    }

    public function generateToken(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string',
            'secret_key' => 'required|string',
        ]);

        $user = UserAuth::where('api_key', $request->api_key)->first();

        if (!$user || $user->secret_key !== $request->secret_key) {
            return response()->json(['error' => 'Invalid API credentials'], 404);
        }

        Auth::login($user);
        
        $users = Auth::user();

        $token = $users->createToken('passportToken');

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
  
    }
    
}
