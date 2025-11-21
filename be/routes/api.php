<?php

use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user", function (Request $request) {
    return $request->user();
})->middleware("auth:sanctum");

Route::apiResource("/products", ProductController::class);
Route::apiResource("/members", MemberController::class);
Route::apiResource("/inventories", InventoryController::class);
