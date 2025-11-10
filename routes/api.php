<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pagecontroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionsController;
use Mockery\Generator\StringManipulation\Pass\Pass;

// Route::get('/', [Pagecontroller::class, "home"]);
// Route::get('/about', [Pagecontroller::class, "about"]);
// Route::get('/contact', [Pagecontroller::class, "contact"]);
Route::post('/api/signup', [AuthController::class, "signup"]);
Route::get('/api/users', [UserController::class, "users"]);
Route::get('/api/users/{id}', [UserController::class, "showuser"]);
Route::post('/api/users/register', [UserController::class, "insert"]);
Route::get('/api/tasks', [TasksController::class, "task"]);

// all approve task for home page
Route::get('/api/tasks/approved', [TasksController::class, "allApproveTask" ]);
// all comments 
Route::get('/api/comments', [CommentsController::class, "comments"]);
Route::get('/api/comments/{id}', [CommentsController::class, "showUserComment"]);
Route::get('/api/permissions', [PermissionController::class, "permission"]);
Route::get('/api/role-permissions', [RolePermissionsController::class, "userRolePermissions"]);
Route::get('/api/roles', [RoleController::class, "Roles"]);

