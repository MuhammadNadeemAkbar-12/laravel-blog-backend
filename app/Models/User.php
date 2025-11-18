<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        
    ];

    protected $hidden = [
        'password',
        // 'remember_token',
        
    ];
    protected $timestamp = false;
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // one to many 
    public function tasks() {
        return $this->hasMany(Task::class, "user_id");
    }

    // one to many comments
    public function comments() {
        return $this->hasMany(Comment::class, "user_id");
    }




    // public function profile() {
    //     return $this->hasOne(Profile::class);
    // }
    // one to many notification
    // public function notifications() {
    //     return $this->hasMany(Notification::class, "user_id");
    // }

   // one to many
    // public function comments() {
    //     return $this->hasMany(Comment::class, "user_id");
    // }

    // one to many permissions 
    // public function permissions() {
    //     return $this->hasMany(Permission::class, "user_id");
    // }

    // one to many roles 
    public function role() {
        return $this->hasOne(Role::class, "role_id");
    }
    





   




}