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
        return response()->json(['user' => $user, 'token' => $token]);
    }
    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required',]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => ['The provided credentials are incorrect.'],]);
        }
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out.']);
    }
}