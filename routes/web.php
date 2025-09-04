<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BugController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperadminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');




Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/addemployee', [AuthController::class, 'showSignupForm'])->name('addemployee')->middleware(['auth','permission:add_users']);
Route::post('/addemployeeform', [AuthController::class, 'signup'])->name('addemployeeform')->middleware(['auth','permission:add_users']);


Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('changePasswordForm');
Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('updatePassword');

Route::get('/employeelist', [EmployeeController::class, 'index'])->name('employeelist')->middleware('auth');

Route::get('/editemployee/{id}', [EmployeeController::class, 'edit'])->name('editemployee')->middleware(['auth','permission:edit_users']);
Route::put('/updateemployee/{id}', [EmployeeController::class, 'update'])->name('updateemployee')->middleware(['auth','permission:edit_users']);

Route::delete('/deleteemployee/{id}', [EmployeeController::class, 'destroy'])->name('deleteemployee')->middleware(['auth','permission:delete_users']);

Route::get('projectlist', [ProjectController::class, 'index'])->name('projectlist')->middleware('auth');

Route::get('storeproject', [ProjectController::class, 'create'])->name('storeproject')->middleware('auth');
Route::post('storeproject', [ProjectController::class, 'store'])->name('storeprojectform')->middleware('auth');

Route::get('editproject/{id}', [ProjectController::class, 'edit'])->name('editproject')->middleware('auth');
Route::put('editproject/{id}', [ProjectController::class, 'update'])->name('updateproject')->middleware('auth');

Route::delete('deleteproject/{id}', [ProjectController::class, 'destroy'])->name('deleteproject')->middleware('auth');

Route::get('/tasklist', [TaskController::class,'index'])->name('tasklist')->middleware('auth');

Route::get('/storetask', [TaskController::class,'create'])->name('storetask')->middleware('auth');
Route::post('/storetask', [TaskController::class,'store'])->name('storetaskform')->middleware('auth');

Route::get('/projects/{id}/members', [TaskController::class, 'getMembers'])->middleware('auth');

Route::get('edittask/{id}', [TaskController::class, 'edit'])->name('edittask')->middleware('auth');
Route::put('edittask/{id}', [TaskController::class, 'update'])->name('updatetask')->middleware('auth');

Route::delete('deletetask/{id}', [TaskController::class, 'destroy'])->name('deletetask')->middleware('auth');

Route::get('buglist',[BugController::class,'index'])->name('buglist')->middleware('auth');

Route::get('/tasks/{id}/members', [BugController::class, 'getAssignedUser'])->middleware('auth');

Route::get('storebug',[BugController::class,'create'])->name('storebug')->middleware(['auth','permission:add_bug']);
Route::post('storebug',[BugController::class,'store'])->name('storebugform')->middleware(['auth','permission:add_bug']);

Route::get('editbug/{id}',[BugController::class,'edit'])->name('editbug')->middleware(['auth','permission:edit_bug']);
Route::put('editbug/{id}',[BugController::class,'update'])->name('updatebug')->middleware(['auth','permission:edit_bug']);

Route::delete('deletebug/{id}',[BugController::class,'destroy'])->name('deletebug')->middleware(['auth','permission:delete_bug']);

Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgotPasswordForm');
Route::post('forgot-password', [AuthController::class, 'sendOtp'])->name('sendOtp');

Route::get('verify-otp', [AuthController::class, 'showVerifyOtpForm'])->name('verifyOtpForm');
Route::post('verify-otp', [AuthController::class, 'verifyOtp'])->name('verifyOtp');



