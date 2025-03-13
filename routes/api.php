<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Models\OutletRevenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


/** AUTH ROUTE */
Route::prefix("/auth")->group(function () {
    Route::post("/signin", [AuthController::class, 'login']);
    Route::post("/signup", [AuthController::class, 'signup']);
    Route::post("/phone", [AuthController::class, 'checkPhone']);
    Route::post("/email", [AuthController::class, 'checkEmail']);

    Route::get("/user", [AuthController::class, 'user']);
});

Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, 'index']);

    Route::prefix("/transaction")->group(function () {
        Route::get("", [TransactionController::class, 'index']);
    });

    Route::prefix("/merchant")->group(function () {
        Route::post("/verify", [MerchantController::class, 'verify']);
        Route::get("/", [MerchantController::class, 'show']);
    });

    Route::prefix("/outlet")->group(function () {
        Route::get("/revenue", [OutletController::class, 'revenue']);

        Route::get("/", [OutletController::class, 'index']);
        Route::get("/{idOutlet}", [OutletController::class, 'show']);
        Route::post("/", [OutletController::class, 'create']);
        Route::put("/{idOutlet}", [OutletController::class, 'update']);
        Route::delete("/{idOutlet}", [OutletController::class, 'delete']);
    });
});

Route::get("/", function () {
    $dummyTransactions = json_decode(file_get_contents(storage_path('app/public/dummy_transactions.json')), true);
    $selectedTransactions = $dummyTransactions[array_rand($dummyTransactions)];

    // Replace placeholder with the actual user's ID
    foreach ($selectedTransactions as &$transaction) {
        $transaction['id_user'] = 5;
        $randomDaysAgo = random_int(0, 2); // Random number from 0 to 3
        $transaction['date'] = now()->subDays($randomDaysAgo);
    }

    return $selectedTransactions;
});
