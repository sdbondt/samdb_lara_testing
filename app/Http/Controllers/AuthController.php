<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function signup() {
        $attr = request()->validate([
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'name' => ['required'],
            'password' => ['required']
        ]);
        $user = User::create($attr);
        $token = $user->createToken('authToken')->plainTextToken;
        return [
            'token' => $token
        ];
    }

    public function login() {
        request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $user = User::where('email', request('email'))->first();

        if(! $user) {
            return response('Credentials don\'t match.', Response::HTTP_UNAUTHORIZED);
        }

        if(!Hash::check(request()->password, $user->password)) {
            return response('Credentials don\'t match.', Response::HTTP_UNAUTHORIZED);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        return [
            'token' => $token
        ];
    }
}
