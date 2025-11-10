<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\RolePermission;

class RolePermissionsController extends Controller
{
    public function userRolePermissions() {
        $role_permissions = RolePermission::all();
        return response()->json([
            'success' => 'success',
            'total_role_permission' => $role_permissions->count(),
            'role_permission' => $role_permissions,
        ]);
    }
        
}
