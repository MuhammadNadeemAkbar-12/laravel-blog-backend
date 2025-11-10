<?php

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



// Simple routes 
// Route::prefix('admin')->group(function () {
// // home route 
// Route::get('/', function () {
//     return view('home');
// });
// // about route 
// Route::get('/about/{name}', function ($name) {
//     $name = "Nadeem AKBAR";
//     return view ('about', ['username'  => $name]);
// });
// // contact route  
// Route::get('/contact', function () {
//    return view('contact');
// });
// Route::prefix('setting')->group(function () {
//      Route::get('/profile', function () {
//         return view('profile');
//      });
// });
// });