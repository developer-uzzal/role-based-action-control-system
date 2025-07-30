<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Role;
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
}
