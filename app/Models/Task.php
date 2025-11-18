<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $table = 'tasks';
    
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

    // one to one 
    public function user() {
        return $this->belongsTo(User::class, "user_id");
    }

    // one to many relationship with comments
 public function comments()
{
    return $this->hasMany(Comment::class, 'task_id')->orderBy('created_at', 'desc');
}

    



}
