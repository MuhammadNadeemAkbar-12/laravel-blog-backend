<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
     protected $fillable = [
        'user_id',
        'task_name',
        'description',
        'image',
        'created_at',
        'status',
        'is_deleted',
        'updated_at',
        'deleted_at',
        


    ];
}
