<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
                $role->permissions()->attach($item);
            }


            return response()->json(['message' => 'Permission assigned successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
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

            return response()->json(['message' => 'Permissions assigned successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
