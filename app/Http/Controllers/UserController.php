<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function loginPage()
    {
        return Inertia::render('Login');
    }


    function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::get();

        return Inertia::render('Users/User', ['users' => $users, 'roles' => $roles]);
    }
    function login(Request $request)
    {
        try {


            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);

            $email = $request->input('email');
            $password = $request->input('password');


            $user = User::where('email', $email)->first();


            if ($user) {

                if (password_verify($password, $user->password)) {

                    $request->session()->put('userId', $user->id);
                    $request->session()->put('user', $user);

                    $userWithPermissions = User::with('roles.permissions')->find($user->id);

                    $permissions = $userWithPermissions->roles
                        ->pluck('permissions')
                        ->flatten()
                        ->pluck('name')
                        ->unique()
                        ->values()
                        ->all();
                    $request->session()->put('permissions', $permissions);


                    $data  = [
                        'status' => 'success',
                        'message' => 'user login successfully'
                    ];

                    return redirect()->back()->with('success', $data);
                } else {


                    $data  = [
                        'status' => 'failed',
                        'message' => 'password not matched'
                    ];

                    return redirect()->back()->with('error', $data);
                }
            } else {
                $data  = [
                    'status' => 'failed',
                    'message' => 'User not found'
                ];

                return redirect()->back()->with('error', $data);
            }
        } catch (Exception $e) {

            $data  = [
                'status' => 'failed',
                'message' => 'Something went wrong'
            ];

            return redirect()->back()->with('error', $data);
        }
    }

    function logout(Request $request)
    {

        $request->session()->flush();

        $request->session()->get('user_id');


        return redirect()->route('login');
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
            return back()->with('success', ['status' => 'success', 'message' => 'User created successfully']);
        } catch (Exception $e) {
            return back()->with('error', ['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    function show($id)
    {
        try {
            $user = User::where('id', $id)->first();
            return response()->json([
                'status' => 'success',
                'user' =>  $user,
                'permissions' => $user->roles->pluck('permissions')->flatten()->pluck('name')->unique()
            ]);
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
            return back()->with('success', ['status' => 'success', 'message' => 'User updated successfully']);
        } catch (Exception $e) {
            return back()->with('error', ['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    function destroy($id)
    {
        try {
            User::where('id', $id)->delete();
            return back()->with('success', ['status' => 'success', 'message' => 'User deleted successfully']);
        } catch (Exception $e) {
            return back()->with('error', ['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
