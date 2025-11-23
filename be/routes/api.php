<?php

use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post("/register", RegisterController::class);
Route::post("/login", LoginController::class);

Route::middleware("auth:api")->group(function () {
    Route::get("/user", function (\Illuminate\Http\Request $request) {
        return $request->user();
    });

    Route::get("/products/all", [ProductController::class, "all"]);
    Route::get("/members/all", [MemberController::class, "all"]);
    Route::get("/inventories/all", [InventoryController::class, "all"]);

    Route::apiResource("/products", ProductController::class);
    Route::apiResource("/members", MemberController::class);
    Route::apiResource("/inventories", InventoryController::class);

    Route::post("/logout", LogoutController::class);
});
