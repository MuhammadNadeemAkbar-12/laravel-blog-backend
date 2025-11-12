<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
     protected $fillable = [
        'user_id',
        'task_name',
        'description',
        'image',
        'created_at',
        'status',
        'is_deleted',
        'updated_at',


    ];
}
