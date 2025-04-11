<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate(
            ['name' => 'required|string|max:255',
                    'email' => 'required|string|email|unique:users',
                    'password' => 'required|string|min:6',
                    'role' => 'required|in:Admin, User, Vendor',]);
        $user = User::create(
            ['name' => $validated['name'],
                         'email' => $validated['email'],
                         'password' => Hash::make($validated['password']),
                         'role' => $validated['role'],]);
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'message' => 'Registration successful',
            'user' => $user->only(['id', 'name', 'email', 'role']),
            'token' => $token
        ], 201);
    }
    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required',]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'user' => $user->only(['id', 'name', 'email', 'role']),
            'token' => $token
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out.']);
    }
}