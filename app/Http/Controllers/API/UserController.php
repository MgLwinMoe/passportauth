<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function userRegister(Request $request) {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6"
        ]);
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);
        return response()->json(
            [
                "status" => true,
                "message" => "User created successfully"
            ]
            );
    }
    public function userLogin(Request $request) {
        $user = User::where("email", $request->email)->first();
        if (!$user) {
            return response()->json(["email" => "The provided email is incorrect"]);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(["password" => "The provided password is incorrect"]);
        }
        $response = Http::asForm()->post('http://laravel.example/oauth/token', [
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            'username' => $request->email,
            'password' => $request->password,
            'user' => $user,
            'scope' => ''
        ]);

        return response()->json([
            "data" => [
                "token_type" => $response['token_type'],
                "expires_in" => $response['expires_in'],
                "access_token" => $response['access_token'],
                "refresh_token" => $response['refresh_token']
            ],
            "message" => "Login Success",
        ]);
    }

    public function userDetail()
    {
        $user = \Auth::user();
        return response()->json(
            [
                "status" => 200,
                "data" => $user
            ]
        );
    }
}
