<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function Roles() {
        $roles = Role::all();
        return response()->json([
            'success' => 'success',
            'total_roles' => $roles->count(),
             'roles' => $roles,
        ]);
    }
}
