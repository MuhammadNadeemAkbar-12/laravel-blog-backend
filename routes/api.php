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
use App\Http\Controllers\User\CommentController;

// Auth routes
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, "login"]);

// Protected routes (require token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, "logout"]);

    // user
    Route::prefix('/user')->group(function () {
        Route::get('/notifications', [NotificationController::class, 'userNotification']);
        Route::get('/profile', [UserController::class, 'userProfile']);
        Route::get('/owntaskpagination', [UserController::class, "userOwnTaskPagination"]);
        Route::post('/delete-task/{id}', [UserController::class, 'deleteTask']);
        Route::post('/add-task', [UserController::class, 'addNewTask']);
        Route::get('/own-task', [UserController::class, 'userOwnTask']);
        Route::post('/task-edit/{id}', [UserController::class, 'editTask']);
        Route::get('/get/all-comments', [CommentController::class, 'getallComments']);
        Route::get('/single-task/{id}', [CommentController::class, 'getCommentsByTaskId']);
        Route::get('/all-tasks-comments', [CommentController::class, 'getUserComments']);
        Route::post('/add-comment', [CommentController::class, 'addComment']);
        Route::delete('/comments/{id}', [CommentController::class, 'deleteComment']);

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














// Route::get('/tasks', [TasksController::class, "task"]);
// Route::get('/tasks/approved', [TasksController::class, "allApproveTask"]);
// Route::get('/comments', [CommentsController::class, "comments"]);
// Route::get('/comments/{id}', [CommentsController::class, "showUserComment"]);
// Route::get('/permissions', [PermissionController::class, "permission"]);
// Route::get('/role-permissions', [RolePermissionsController::class, "userRolePermissions"]);
// Route::get('/roles', [RoleController::class, "Roles"]);
