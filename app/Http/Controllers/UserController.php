<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json(auth()->user(), 200);
    }

    public function update(UserUpdateRequest $request): JsonResponse
    {
        $data = $request->validated(); //karena array jadi $data['password']
        $user = auth()->user();

        if(isset($data['password'])){//halo php apakah data password di array ada?
            $data['password'] = Hash::make($data['password']);
        }else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json($user, 200);
    }
}
