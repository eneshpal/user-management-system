<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleAssignmentController;
use App\Http\Controllers\AuthController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::middleware('auth:api')->post('/assign-role', [RoleAssignmentController::class, 'assignRole']);

// Route::middleware(['auth:api', 'role:SuperAdmin'])->get('/admin-area', function () {
//     return 'Welcome Super Admin!';
// });

// Route::middleware(['auth:api', 'role:Admin'])->get('/manage-users', function () {
//     return 'Hello Admin!';
// });

// Route::middleware(['auth:api', 'role:User'])->get('/profile', function () {
//     return auth()->user();
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);