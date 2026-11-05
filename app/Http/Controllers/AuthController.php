<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=> Hash::make($data['password'])

        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token'=>$token
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        //disini ngecek kredensial
        if(!Auth::attempt($data)){
            return response()->json([
                'message'=>'Email atau password salah'
            ], 401);// disini menggunakan 401 dan bukan 422 karena 422 sudah diatasi di bagian requestnya
        }

        //jika berhasil, mengambil usernya
        $user = User::where('email', $request->email)->firstOrFail();

        //membuat token yang baru
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token'=>$token
        ],200);
    }   
}
