<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    // many to one relationship with roles
    public function role() {
        return $this->belongsTo(Role::class, "role_id");
    }

    // many to one relationship with permissions
    public function permission() {
        return $this->belongsTo(Permission::class, "permission_id");
    }
 
}
