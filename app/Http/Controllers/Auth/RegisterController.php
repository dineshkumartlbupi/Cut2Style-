<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function register(Request $request)
    {


        $validated = $request->validate(
            [
                'role' => 'required|in:Admin, User, Vendor',
                'name' => 'required|string|max:255',
                'gender' => 'required|in:Male,Female,Other',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6',

            ]
        );
        $user = User::create(
            [
                'role' => $validated['role'],
                'name' => $validated['name'],
                'gender' => $validated['gender'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),

            ]
        );
        $token = $user->createToken('api-token')->plainTextToken;
        $user->token = $token;
        $user->save();
        return redirect()->route('dashboard')->with('success', 'Registration successful!');
        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Registration successful'
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }
}
