<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
public $timestamps = false;
    protected $fillable = [
        'user_id',  
        'task_id',
        'comment_text',
        
        
    ];
    // one to one user
    public function user() {
        return $this->belongsTo(User::class, "user_id");   
    }         
    // one to one tasks
   public function task(){
    return $this->belongsTo(Task::class, 'task_id');
    
}




}
