<?php

use App\Http\Controllers\Api\CheckinController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\DepController;
use App\Http\Controllers\Api\EditController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\AddController;
use App\Http\Controllers\Api\RecordController;
use App\Http\Controllers\Api\TimerController;

use App\Http\Controllers\Api\AddOtController;
use App\Http\Controllers\Api\EditOtController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('guest')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () { 
    Route::get('user', UserController::class);
    Route::post('reportDay', [ReportController::class, 'reportDay']);
    Route::resource('dep', DepController::class);
    Route::resource('edit', EditController::class);
    Route::resource('member', MemberController::class);
    Route::post('reportMember', [ReportController::class, 'reportMember']);
    Route::get('showname/{uid}', [AddController::class, 'showname']);
    Route::resource('add', AddController::class);
    Route::resource('timer', TimerController::class);
    Route::resource('record', RecordController::class);
    Route::get('otRecord', [RecordController::class, 'otRecord']);
    Route::get('otMember', [MemberController::class, 'otMember']);

    Route::post('reportDayOt', [ReportController::class, 'reportDayOt']);
    Route::resource('addOt', AddOtController::class);
    Route::resource('editOt', EditOtController::class);
    Route::post('reportOtMember', [ReportController::class, 'reportOtMember']);
});
