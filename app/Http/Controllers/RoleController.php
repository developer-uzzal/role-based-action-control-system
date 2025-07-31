<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    function index()
    {

        $roles = Role::all();

        $permissions = $roles->pluck('permissions')->flatten()->pluck('name')->unique();

        return Inertia::render('Roles/Roles', ['roles' => $roles, 'permissions' => $permissions]);
    }
    function store(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required | string | min:3 | unique:roles,name'
            ]);

            $role = Role::create([
                'name' => $request->name
            ]);

            if ($role) {

                return back()->with('success',['status' => 'success', 'message' => 'Role created successfully']);

            } else {
                return back()->with('error', ['status' => 'error', 'message' => 'Role not created']);
            }
        } catch (Exception $e) {
            return back()->with('error', ['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    function show($id)
    {
        try {
            $role = Role::find($id);
            $permissions = $role->permissions->pluck('name');

            if ($role) {
                return response()->json(
                    [
                        'status' => 'success',
                        'role' => $role,
                        'permissions' => $permissions
                    ]
                );
            } else {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Role not found'
                    ]
                );
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required | string | min:3 | unique:roles,name'
            ]);

            $role = Role::find($id);
            $role->name = $request->name;
            $role->save();

            return back()->with('success', ['status' => 'success', 'message' => 'Role updated successfully']);
        } catch (Exception $e) {
            return back()->with('error', ['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    function destroy($id)
    {
        try {
            $role = Role::find($id);
            $role->delete();
            
            return back()->with('success', ['status' => 'success', 'message' => 'Role deleted successfully']);
        } catch (Exception $e) {
            return back()->with('error', ['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
