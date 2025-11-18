<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'is_read',
        'created_at'
    ];
    
    protected $casts = [
        'is_read' => 'datetime',
    ];

    // one to one user
    public function user() {
        return $this->belongsTo(User::class, "user_id");   
    }
    
}
