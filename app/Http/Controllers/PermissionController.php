<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    function assignPermission(Request $request)
    {


        try {

            $request->validate([
                'role_id' => 'required',
                'items' => 'required'
            ]);

            $roleId = $request->role_id;
            $permissionsItems = $request->items;

            foreach ($permissionsItems as $item) {
                

                $role = Role::find($roleId);
                $permissionId = Permission::where('name', $item)->first()->id;
                $role->permissions()->attach($permissionId);
            }


            return back()->with('success', ['status' => 'success', 'message' => 'Permissions assigned successfully']);
        } catch (Exception $e) {
            return back()->with('error', ['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    function assignUserPermission(Request $request)
    {


        try {

            $request->validate([
                'user_id' => 'required',
                'role_id' => 'required'
            ]);

            $userId = $request->user_id;
            $roleId = $request->role_id;

            $user = User::find($userId);
            $role = Role::find($roleId);

            $user->roles()->attach($role->id);

            return back()->with('success', ['status' => 'success', 'message' => 'Permissions assigned successfully']);
        } catch (Exception $e) {
            return back()->with('error', ['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

            
}
