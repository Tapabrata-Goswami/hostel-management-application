<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\admin\AdminDashboard;
use App\Http\Controllers\LogoutController;

use App\Http\Middleware\AdminLogin;
// Login Route


Route::get('/', [AuthController::class,'loginView'])->name('loginViewDashboard');
Route::post('/',[AuthController::class,'login'])->name('loginDashboard');

Route::middleware([AdminLogin::class])->prefix('/auth')->group(function () {

    Route::get('/dashboard', [AdminDashboard::class, 'dashboardView'])->name('adminDashboardView');

    // Guest
    Route::get('/add-guest', [AdminDashboard::class, 'addGuestView'])->name('guestAddView');
    Route::post('/add-guest',[AdminDashboard::class, 'addGuest'])->name('guestAdd');
    Route::get('/list-guest', [AdminDashboard::class, 'listGuestView'])->name('guestListGuestView');
    Route::get('/edit-guest/{guestId}', [AdminDashboard::class, 'editGuestView'])->name('guestEditView');
    Route::post('/update-guest/{guestId}', [AdminDashboard::class, 'updateGuest'])->name('updateGuest');
    Route::get('/archive-list',[AdminDashboard::class,'archiveGuestShow'])->name('archiveListShow');
    Route::get('/archive-guest',[AdminDashboard::class, 'archiveGuest'])->name('archiveGuest');
    Route::get('/delete-guest/{guestId}',[AdminDashboard::class, 'deleteGuest'])->name('deleteGuest');
    Route::get('/add-comment',[AdminDashboard::class,'addComment'])->name('addComment');
    Route::get('/view-comment',[AdminDashboard::class,'viewComment'])->name('viewComment');
    // Route::get('/count-comment/{guestId}',[AdminDashboard::class,'countComment'])->name('countComment');
    Route::get('/delete-comment',[AdminDashboard::class,'deleteComment'])->name('deleteComment');
    Route::get('/paymet/{guestId}', [AdminDashboard::class,'viewPayment'])->name('viewPayment');
    Route::post('/paymet/{guestId}', [AdminDashboard::class,'updatePayment'])->name('updatePayment');
    Route::get('/debt-list', [AdminDashboard::class,'debetsGuest'])->name('debtList');
    Route::get('/cash-register',[AdminDashboard::class,'cashRegister'])->name('cashRegister');
    Route::get('/cash-register-out-flow',[AdminDashboard::class,'cashRegisterOutFlow'])->name('cashRegisterOutFlow');
    Route::get('/cash-register-delete/{crId}', [AdminDashboard::class,'deleteCashRegister'])->name('deleteCashRegister');

    Route::get('/list-user',[AdminDashboard::class, 'listUserView'])->name('userList');
});

Route::get('/auth/logout', [LogoutController::class,'logout'])->name('logout');

