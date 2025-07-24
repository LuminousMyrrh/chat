<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function register(Request $request) {
        $data = $request->validate();
        $data['password'] = bcrypt($data['password']);

        $user = $this->createUser($data);

        $token = Auth::login($user);

        return $this->respondWithToken($token);
    }

    public function login(Request $request) {
        $user = User::create();
        $tokens = Token::create($user);

        return $tokens;
    }

    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    private function createUser(array $data)
    {
        $response = Http::post('http://user-crud:8000/api/users', $data);

        if ($response->successful()) {
            return $response->json(); // an array with at least ['id', ...]
        }

        throw new \Exception('Failed to create user: ' . $response->body());
    }

    private function getUser($id) {
        $response = Http::get(
            'http://user-crud:8000/api/users/{id}',
            $id
        );
    }
}

