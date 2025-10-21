<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API routes
Route::get('/users', function () {
    $users = User::select('id', 'name', 'email', 'created_at')->get();
    return response()->json([
        'success' => true,
        'data' => $users
    ]);
});

Route::get('/users/{id}', function ($id) {
    $user = User::select('id', 'name', 'email', 'created_at')->find($id);
    
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found'
        ], 404);
    }
    
    return response()->json([
        'success' => true,
        'data' => $user
    ]);
});
