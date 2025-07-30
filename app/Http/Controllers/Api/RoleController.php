<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    function index()
    {
        $roles = Role::all();

        $permissions = $roles->pluck('permissions')->flatten()->pluck('name')->unique();
        return response()->json(
            [
                'status' => 'success',
                'roles' => $roles,
                'permissions' => $permissions
            ]
        );
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

            if($role) {
                return response()->json(
                    [
                        'status' => 'success',
                        'role' => $role
                    ]
                );
            }else {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Role not created'
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

    function show($id)
    {
        try {
            $role = Role::find($id);
            $permissions = $role->permissions->pluck('name');
            
            if($role) {
                return response()->json(
                    [
                        'status' => 'success',
                        'role' => $role,
                        'permissions' => $permissions
                    ]
                );
            }else {
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

            return response()->json(
                [
                    'status' => 'success',
                    'role' => $role
                ]
            );
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    function destroy($id)
    {
        try {
            $role = Role::find($id);
            $role->delete();
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Role deleted successfully'
                ]
            );
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }   
}
