<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionsController;

// Auth routes
Route::post('/signup', [AuthController::class, "signup"]);
Route::post('/login', [AuthController::class, "login"]  );

// Protected routes (require token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, "logout"]);
    Route::get('/users/notifications/{id}', [NotificationController::class, 'userNotification']);
    Route::get('/user/profile/{id}', [UserController::class, 'userProfile']);
});

// Users routes
Route::get('/users', [UserController::class, "users"]);
Route::get('/users/{id}', [UserController::class, "showuser"]);
Route::post('/users/add-task', [UserController::class, 'addnewTask']);
Route::post('/users/delete-task/{id}', [UserController::class, 'deleteTask']);
Route::get('/users/own-task/{id}', [UserController::class, 'userOwnTask']);
Route::put('/users/task-edit/{id}', [UserController::class, 'editTask']);
 


Route::get('/tasks', [TasksController::class, "task"]);
Route::get('/tasks/approved', [TasksController::class, "allApproveTask"]);
Route::get('/comments', [CommentsController::class, "comments"]);
Route::get('/comments/{id}', [CommentsController::class, "showUserComment"]);
Route::get('/permissions', [PermissionController::class, "permission"]);
Route::get('/role-permissions', [RolePermissionsController::class, "userRolePermissions"]);
Route::get('/roles', [RoleController::class, "Roles"]);

