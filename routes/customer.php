<?php

use App\Http\Controllers\Front\BookingController;
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\EstimateController;
use App\Http\Controllers\Front\InvoiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\PeopleController;
use App\Http\Controllers\Front\SupportController;

Route::get('dashboard/login', [PeopleController::class, 'viewLogin'])->name('dashboard.login');

Route::post('dashboard/login', [PeopleController::class, 'login'])->name('dashboard.login.post');

Route::get('send-customer-otp', [PeopleController::class, 'sendOtp'])->name('send-customer-otp');

Route::post('verify-customer-otp', [PeopleController::class, 'verifyOtp'])->name('verify-customer-otp');

Route::post('dashboard/logout', [PeopleController::class, 'logout'])->name('dashboard.logout');

Route::redirect('/', '/dashboard');
// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    // My Account Routes
    Route::get('my-account', [DashboardController::class, 'myAccountForm'])->name('my-account');
    Route::put('my-account/{id}', [DashboardController::class, 'myAccount'])->name('my-account.update');

    Route::get('estimates', [EstimateController::class, 'index'])->name('estimates');

    Route::get('bookings', [BookingController::class, 'index'])->name('bookings');

    Route::get('bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('booking/refund/{id}', [BookingController::class, 'refund'])->name('booking.refund');
    Route::get('bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    Route::put('cancel/booking/{id}', [BookingController::class, 'cancelBooking'])->name('cancel.booking');

    Route::get('bookings/cab-booking/{id}', [BookingController::class, 'cabBooking'])->name('cab-booking');

    Route::get('bookings/hotel-booking/{id}', [BookingController::class, 'hotelBooking'])->name('hotel-booking');

    Route::get('bookings/safari-booking/{id}', [BookingController::class, 'safariBooking'])->name('safari-booking');

    Route::get('bookings/tour-booking/{id}', [BookingController::class, 'tourBooking'])->name('tour-booking');

    Route::get('bookings/package-booking/{id}', [BookingController::class, 'packageBooking'])->name('package-booking');

    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices');

    Route::get('invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');

    Route::get('invoices/{id}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');

    // Tax Invoice Route
    Route::get('tax-invoice/{id}', [InvoiceController::class, 'taxInvoice'])->name('tax.invoice');

    // Tax Invoice Route
    Route::get('download-invoice/{id}', [InvoiceController::class, 'download'])->name('download.invoice');

    // Credit Note Route
    Route::get('credit-note/{id}', [InvoiceController::class, 'creditNote'])->name('credit.note');

    // Credit Note Route
    Route::get('download-credit-note/{id}', [InvoiceController::class, 'downloadCreditNote'])->name('download.credit.note');

    Route::resource('supports', SupportController::class);

    Route::put('send-support-message/{id}', [SupportController::class, 'sendMessage'])->name('supports.send-message');


    Route::get('cancel-bookings',[BookingController::class,'cancelBookingList'])->name('cancel-bookings');

    Route::post('refund-accept',[BookingController::class,'refundAccept'])->name('refund-accept');

    Route::get('approval-history/{id}',[BookingController::class,'refundApprovalHistory'])->name('approval-history');


});
