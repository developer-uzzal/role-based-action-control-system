<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{

    function index()
    {
        return response()->json([
            'status' => 'success',
            'users' => User::all()
        ]);
    }
    function login(Request $request)
    {

        try {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required | min:6'
            ]);

            $auth = User::where('email', $request->email)->first();

            if (!$auth) {
                return response()->json(['message' => 'Invalid credentials']);
            } else {
                if (password_verify($request->password, $auth->password)) {

                    $token = $auth->createToken('auth_token')->plainTextToken;

                    $permissions = $auth->roles->pluck('permissions')->flatten()->pluck('name')->unique();

                    return response()->json([
                        'message' => 'Login successfully',
                        'token' => $token,
                        'permissions' => $permissions
                    ]);
                } else {
                    return response()->json(['message' => 'Invalid credentials']);
                }
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    function logout(Request $request)
    {

        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successfully']);
    }


    function store(Request $request)
    {

        try {

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required | min:6'
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            return response()->json(['message' => 'User created successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    function update(Request $request, $id)
    {

        try {

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'required | min:6'
            ]);
            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            return response()->json(['message' => 'User updated successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    function destroy($id)
    {
        try {
            User::where('id', $id)->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
