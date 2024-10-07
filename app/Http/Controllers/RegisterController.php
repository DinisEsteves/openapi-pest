<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request): JsonResponse
    {
       $request->validate([
           'name' => 'required|string',
           'email' => 'required|email',
           'password' => 'required|string|confirmed',
       ]);

        $user = User::query()->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json($user->toArray(), Response::HTTP_CREATED);
    }
}
