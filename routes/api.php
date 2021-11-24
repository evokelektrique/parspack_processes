<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\FileController;

// Public
Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);

// Protected
Route::group(["middleware" => ["auth:sanctum"]], function() {
    // User
    Route::get("/user", function(Request $request) {
        return $request->user();
    });
    Route::delete('/logout', [AuthController::class, "logout"]);

    // Process
    Route::get("/process", [ProcessController::class, "index"]);
    Route::get("/process/get/{id}", [ProcessController::class, "get"]); // TODO:

    // Directory
    Route::get("/directory", [DirectoryController::class, "index"]);
    Route::post("/directory", [DirectoryController::class, "store"]);

    // Files
    Route::get("/directory/files", [FileController::class, "index"]);
    Route::post("/directory/files", [FileController::class, "store"]);
});
