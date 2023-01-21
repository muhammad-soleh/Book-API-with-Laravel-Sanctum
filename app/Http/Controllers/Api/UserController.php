<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function loginGet()
    {
        return response()->json([
            'message' => 'Silahkan Menggunakan Method Post ke endpoint /api/login'
        ]);
    }
    public function register(Request $request)
    {
        $dataValid = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
        ]);
        $user = User::create($dataValid);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'tipe_token' => 'Bearer'
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Gagal Mengauthentikasi'
            ], 401);
        }
        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout Berhasil'
        ]);
    }
}
