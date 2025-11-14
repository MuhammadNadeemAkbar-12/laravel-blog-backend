<?php

use App\Http\Controllers\Admin\AdminController;
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
Route::post('/login', [AuthController::class, "login"]);

// Protected routes (require token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, "logout"]);

    // user
    Route::prefix('/user')->group(function () {
        Route::get('/notifications', [NotificationController::class, 'userNotification']);
        Route::get('/profile', [UserController::class, 'userProfile']);
        Route::post('/owntaskpagination', [UserController::class, "userOwnTaskPagination"]);
        Route::post('/delete-task/{id}', [UserController::class, 'deleteTask']);
        Route::post('/add-task', [UserController::class, 'addnewTask']);
        Route::get('/own-task', [UserController::class, 'userOwnTask']);
        Route::put('/task-edit/{id}', [UserController::class, 'editTask']);
    });
    
    // admin 
    Route::prefix('/admin')->group(function () {
        Route::get('/allpendingtasks', [AdminController::class, "allPendingTask"]);
        Route::post('/logintaks', [AdminController::class, "currentUserTask"]);
        Route::post('/admintaskpagination', [AdminController::class, "adminLoginPagination"]);
        Route::post('/addtask', [AdminController::class, "addTask"]);
        Route::get('/profile', [AdminController::class, "AdminProfile"]);
        Route::post('/delete/{id}', [AdminController::class, "deletePost"]);
        Route::get('/users', [AdminController::class, "allUsers"]);
        Route::post('/user/{id}', [AdminController::class, "singleUser"]);
        Route::get('/tasks', [AdminController::class, "allTask"]);
        Route::post('/task/{id}', [AdminController::class, "oneTask"]);
        Route::get('/allapprovetasks', [AdminController::class, "allApproveTask"]);
        Route::get('/allrejectedtasks', [AdminController::class, "allRejectTask"]);
    });
});














Route::get('/tasks', [TasksController::class, "task"]);
Route::get('/tasks/approved', [TasksController::class, "allApproveTask"]);
Route::get('/comments', [CommentsController::class, "comments"]);
Route::get('/comments/{id}', [CommentsController::class, "showUserComment"]);
Route::get('/permissions', [PermissionController::class, "permission"]);
Route::get('/role-permissions', [RolePermissionsController::class, "userRolePermissions"]);
Route::get('/roles', [RoleController::class, "Roles"]);
