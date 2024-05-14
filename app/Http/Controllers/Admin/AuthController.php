<?php

namespace App\Http\Controllers\Admin;

use App\Base\Responses\apiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    use apiResponse;

    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('validation errors', ['errors' => $e->errors()], 422);
        }

        if (!Auth::attempt($request->all())) {
            return $this->fail('Invalid email and/or password', 200);
        }

        $token = Auth::User()->createToken('crud');
        $loggedUser = Auth::User();
        return $this->success('Logded in successfully', [
            'user' => $loggedUser,
            'token' => $token->plainTextToken
        ], 200);
//        return response()->json(['token' => $token->plainTextToken], 200);

    }

    public function createUser(Request $request)
    {
        $messages = [
            'email.unique' => 'This email is already in use', // Custom message for the email uniqueness
        ];

        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6'
            ], $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('validation errors', ['errors' => $e->errors()], 422);
        }

        $newUser = new User();
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = Hash::make($request->password);
        $newUser->save();

        return response()->json([
            'user' => $validated
        ], 201);
    }

    public function getUserById($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        }
        return response()->json("user not found", 400);

    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

}
