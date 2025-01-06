<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
 
class AuthController extends Controller
{
    // Enregistrer un utilisateur
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        // Debug temporaire
        return response()->json([
            'provided_password' => $validatedData['password'],
            'hashed_password' => $user->password,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    
    // In your login method
    public function login(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // Retrieve the user by email
        $user = User::where('email', $validatedData['email'])->first();
    
        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'Invalid email'], 401);
        }
    
        // Debug: Log the user data
        \Log::info('User data', ['user' => $user]);
    
        // Debug: Log the provided password
        \Log::info('Provided password', ['provided_password' => $validatedData['password']]);
    
        // Check if the password matches the stored hashed password
        if (!Hash::check($validatedData['password'], $user->password)) {
            \Log::info('Password check failed', [
                'provided_password' => $validatedData['password'],
                'stored_password' => $user->password,
                'password_check' => Hash::check($validatedData['password'], $user->password),
            ]);
            return response()->json(['message' => 'Invalid password'], 401);
        }
    
        // Debug: Log the success if password matches
        \Log::info('Password check succeeded', ['user' => $user]);
    
        // If successful, create an authentication token
        $token = $user->createToken('auth_token')->plainTextToken;
    
        // Return the token
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
    

    // Déconnexion
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
