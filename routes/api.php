<?php

use App\Http\Controllers\Api\LeadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 1. Save Lead

Route::post('save-lead', [LeadController::class, 'store']);

// 2. Update Lead Status
Route::post('update-lead-status', [LeadController::class, 'updateLeadStatus']);

// 3. Update Lead Data
Route::post('update-lead-data', [LeadController::class, 'updateLeadData']);

// 4. Save Address
Route::post('save-address', [LeadController::class, 'saveAddress']);

// 5. Direct Booking
Route::post('direct-booking', [LeadController::class, 'directBooking']);

// 6. Ranthambore Booking API
Route::post('ranthambore-booking', [LeadController::class, 'ranthamboreBooking']);
