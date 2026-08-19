<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeContoller;
use App\Http\Controllers\HotelRoomsContoller;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\RoomContoller;
use App\Http\Controllers\AiAssistantController;

use Illuminate\Support\Facades\Route;


Route::get('/', [HomeContoller::class, 'index'])->name('home');
Route::get('/hotel/{slug}', [HomeContoller::class, 'show'])->name('hotel');
Route::get('/hotel/{hotel:slug}/room/{room:slug}', [RoomContoller::class, 'index'])->name('room.show');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/ai-test', [AiAssistantController::class, 'test']);
Route::post('/ai-assistant', [AiAssistantController::class, 'ask'])->name('ai.assistant');

Route::redirect('/dashboard', '/admin')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('booking.index');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    Route::patch('/bookings/{booking}/pay', [PaymentController::class, 'pay'])->name('bookings.pay');
});

// Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/', [AdminController::class, 'index'])->name('index');

//     Route::get('/hotels/basket', [HotelController::class, 'basket'])->name('hotels.basket');
//     Route::patch('/hotels/{hotel}/restore', [HotelController::class, 'restore'])->name('hotels.restore');
//     Route::delete('/hotels/{hotel}/force-delete', [HotelController::class, 'basketRemove'])->name('hotels.basketRemove');

//     Route::patch('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
//     Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus',])->name('bookings.update-status');

//     Route::resource('/hotels', HotelController::class);
//     Route::resource('/rooms', RoomController::class);
//     Route::resource('/bookings', AdminBookingController::class);
// });

Route::middleware(['auth', 'admin.owner'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])
            ->name('index');

        Route::get('/hotels/basket', [HotelController::class, 'basket'])
            ->name('hotels.basket');

        Route::patch('/hotels/{hotel}/restore', [HotelController::class, 'restore'])
            ->name('hotels.restore');

        Route::delete('/hotels/{hotel}/force-delete', [HotelController::class, 'basketRemove'])
            ->name('hotels.basketRemove');

        Route::patch('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])
            ->name('bookings.cancel');

        Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])
            ->name('bookings.update-status');

        Route::resource('categories', CategoryController::class);
        Route::resource('users', AdminUserController::class)->except('show');
        Route::resource('hotels', HotelController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('bookings', AdminBookingController::class);
    });

require __DIR__ . '/auth.php';
