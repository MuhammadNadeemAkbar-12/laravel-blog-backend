<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Reqest;

class PermissionController extends Controller
{
    public function permission() {
        $permissions = Permission::all();
        return response()->json([
            'success' => 'success',
            'total_permissions' => $permissions->count(),
            'data' => $permissions,
        ]);
    }


    
}
