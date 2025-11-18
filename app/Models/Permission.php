<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    // one to many relationship with roles 
    public function roles() {
        return $this->hasMany(Role::class, "permission_id");
    }
}
