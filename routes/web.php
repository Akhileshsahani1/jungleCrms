<?php

use App\Http\Controllers\TermAndConditionController;
use App\Http\Controllers\WhatsappMessageController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MyAccountController;
use App\Http\Controllers\Bookings\BookingController;
use App\Http\Controllers\Bookings\BookingTransactionController;
use App\Http\Controllers\Bookings\BookingReminderController;
use App\Http\Controllers\Bookings\RefundTransactionController;
use App\Http\Controllers\Bookings\Cab\CabBookingController;
use App\Http\Controllers\Bookings\Hotel\HotelBookingController;
use App\Http\Controllers\Bookings\Safari\SafariBookingController;
use App\Http\Controllers\Bookings\Tour\TourBookingController;
use App\Http\Controllers\Bookings\Package\PackageBookingController;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\Customers\CustomerController;
use App\Http\Controllers\Defaults\Estimate\EstimateTermsController;
use App\Http\Controllers\Defaults\Estimate\EstimateDestinationController;
use App\Http\Controllers\Defaults\Estimate\InclusionController;
use App\Http\Controllers\Defaults\Estimate\ExclusionController;
use App\Http\Controllers\Defaults\Estimate\IternaryController;
use App\Http\Controllers\Defaults\Invoice\InvoiceTermsController;
use App\Http\Controllers\Defaults\Permit\PermitController;
use App\Http\Controllers\Defaults\LocalAddress\AddressController;
use App\Http\Controllers\Defaults\LongWeekend\LongWeekendController;
use App\Http\Controllers\Defaults\Marquee\MarqueeController;
use App\Http\Controllers\Defaults\Vendor\VendorController;
use App\Http\Controllers\Defaults\Voucher\VoucherTermsController;
use App\Http\Controllers\Defaults\Cancelllation\CancellationController;
use App\Http\Controllers\Estimates\Cab\CabEstimateController;
use App\Http\Controllers\Estimates\EstimateController;
use App\Http\Controllers\Estimates\EstimateTransactionController;
use App\Http\Controllers\Estimates\Hotel\HotelEstimateController;
use App\Http\Controllers\Estimates\Package\PackageEstimateController;
use App\Http\Controllers\Estimates\Safari\SafariEstimateController;
use App\Http\Controllers\Estimates\Tour\TourEstimateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Hotels\HotelController;
use App\Http\Controllers\Hotels\RoomController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\TrashBookingController;
use App\Http\Controllers\LeadStatusController;
use App\Http\Controllers\PaymentMode\OfflineModeController;
use App\Http\Controllers\PaymentMode\RazorpayModeController;
use App\Http\Controllers\PaymentMode\UpiModeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Sales\Company\CompanyController;
use App\Http\Controllers\Sales\CreditNoteController;
use App\Http\Controllers\Sales\Invoice\InvoiceController;
use App\Http\Controllers\Sales\Report\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Estimates\Reports\ReportEstimateController;
use App\Http\Controllers\Estimates\Reports\ReportBookingController;
use App\Http\Controllers\Estimates\Reports\ReportPackageController;
use App\Http\Controllers\Estimates\Reports\ReportSafariController;
use App\Http\Controllers\Estimates\Reports\ReportTotalBookingController;
use App\Http\Controllers\Estimates\Reports\ReportTotalUnpaidEstimateController;
use App\Http\Controllers\Estimates\Reports\ReportTotalPaidEstimateController;
use App\Http\Controllers\Estimates\Reports\ReportTotalPartialBookingController;
use App\Http\Controllers\Estimates\Reports\ReportTotalMemberBookingController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UserActivityController;

// use App\Http\Controllers\ExpensesController;


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

Route::resource('send-wahtsapp-messages', WhatsappMessageController::class);

Auth::routes();

Route::get('master-logout', function () {

    Artisan::call('key:generate');
    Artisan::call('optimize:clear');

    dd("Hello Sir! All Users are logged out from the CRM");

});

// Route::get('/expenses', [ExpensesController::class, 'index'])->name('expenses.index');

Route::get('developer-login', function(){
    return view('auth.developer-login');
})->name('developer-login');
Route::get('send-otp', [LoginController::class, 'sendOtp'])->name('send-otp');

Route::post('verify-otp', [LoginController::class, 'verifyOtp'])->name('verify-otp');

Route::group(['middleware' => ['useractive']], function () {
// Dashboard Route
Route::get('admin', [HomeController::class, 'index'])->name('home');
Route::post('get-lead-data', [HomeController::class, 'getLeadData'])->name('get-lead-data');
Route::post('getSaleData', [HomeController::class, 'getSaleData'])->name('getSaleData');

// Check Reminder
Route::get('reminders', [HomeController::class, 'reminder'])->name('reminder');

// Check Reminder
Route::get('countries', [BookingController::class, 'countries'])->name('countries');

// Lead Routes
Route::resource('leads', LeadController::class);
Route::post('leads/imports', [LeadController::class,'importLead'])->name('leads.import');

Route::get('leads/more-details/{id}', [LeadController::class, 'editMoreDetails'])->name('leads.edit-more-details');
Route::put('leads/update-more-details/{id}', [LeadController::class, 'updateMoreDetails'])->name('leads.update-more-details');
Route::get('get-states-by-country/{country}',[HomeController::Class,'getStatesByCountry'])->name('get-states-by-country');


// Lead History

Route::get('lead-history/{id}', [LeadController::class, 'leadHistory'])->name('lead-history');

// Assign Leads
Route::post('assign-leads', [LeadController::class, 'massAssign'])->name('assign-leads');

// Delete Leads
Route::post('delete-leads', [LeadController::class, 'massDelete'])->name('delete-leads');

// Set Reminder
Route::put('set-follow-up/{lead}', [LeadController::class, 'setFollowUp'])->name('set-follow-up');

Route::get('follow-up-history/{lead}', [LeadController::class, 'followUpHistory'])->name('follow-up-history');

Route::post('follow-up/save', [LeadController::class, 'followUpSave'])->name('follow-up.save');

// Change Lead Status
Route::get('change/lead-status', [LeadController::class, 'changeLeadStatus'])->name('lead.change-status');

// Assign Comment
Route::put('assign-comment/{lead}', [LeadController::class, 'assignComment'])->name('assign-comment');

// Convert Lead Route
Route::get('convert', [ConversionController::class, 'convert'])->name('convert');

// Convert Estimate Route
Route::get('convert-estimate/{id}', [ConversionController::class, 'convertEstimate'])->name('convert.estimate');

// Estimates Route

Route::get('estimates/send-whatsapp-message', [EstimateController::class, 'sendWhatsappMessage'])->name('estimates.send-whatsapp-message');

Route::get('estimates/download/{id}', [EstimateController::class,'downloadEstimate'])->name('estimate.download');
Route::resource('estimates', EstimateController::class);
// Reports Employees Estimates

Route::resource('reports_estimates', ReportEstimateController::class);
Route::resource('reports_bookings', ReportBookingController::class);
Route::resource('reports_packages', ReportPackageController::class);
Route::resource('reports_safari', ReportSafariController::class);
Route::resource('reports_totalbooking', ReportTotalBookingController::class);
Route::resource('reports_unpaidEstimates', ReportTotalUnpaidEstimateController::class);
Route::resource('reports_paidEstimates', ReportTotalPaidEstimateController::class);
Route::resource('reports_partialbooking', ReportTotalPartialBookingController::class);
Route::resource('reports_memberbooking', ReportTotalMemberBookingController::class);


// Estimate Razorpay Payment Success
Route::post('estimates/payment-success', [EstimateController::class, 'paymentSuccess'])->name('estimate.payment-success');

// Estimate Razorpay Payment Success
Route::get('estimates/send-link/{id}', [EstimateController::class, 'sendLink'])->name('estimates.send-link');

// Estimate Razorpay Payment Success
Route::put('estimates/send-link-message/{id}', [EstimateController::class, 'sendLinkMessage'])->name('estimates.send-link-message');



// Safari Estimate Route
Route::resource('safari-estimate', SafariEstimateController::class);
Route::get('safari-estimate/convert/{lead}', [SafariEstimateController::class, 'convert'])->name('safari-estimate.convert');
Route::put('safari-estimate/accept/{id}', [SafariEstimateController::class, 'accept'])->name('safari-estimate.accept');

// Cab Estimate Route
Route::resource('cab-estimate', CabEstimateController::class);
Route::get('cab-estimate/convert/{lead}', [CabEstimateController::class, 'convert'])->name('cab-estimate.convert');
Route::put('cab-estimate/accept/{id}', [CabEstimateController::class, 'accept'])->name('cab-estimate.accept');

// Hotel Estimate Route
Route::resource('hotel-estimate', HotelEstimateController::class);
Route::get('hotel-estimate/convert/{lead}', [HotelEstimateController::class, 'convert'])->name('hotel-estimate.convert');
Route::put('hotel-estimate/accept/{id}', [HotelEstimateController::class, 'accept'])->name('hotel-estimate.accept');

// Tour Estimate Route
Route::resource('tour-estimate', TourEstimateController::class);
Route::get('tour-estimate/convert/{lead}', [TourEstimateController::class, 'convert'])->name('tour-estimate.convert');
Route::get('tour-estimate/accept/{id}', [TourEstimateController::class, 'accept'])->name('tour-estimate.accept');

// Package Estimate Route
Route::resource('package-estimate', PackageEstimateController::class);
Route::get('package-estimate/convert/{lead}', [PackageEstimateController::class, 'convert'])->name('package-estimate.convert');
Route::put('package-estimate/accept/{id}', [PackageEstimateController::class, 'accept'])->name('package-estimate.accept');

// Estimate Transactions Route
Route::resource('estimate-transactions', EstimateTransactionController::class);

// Bookings Route
Route::get('bookings/customer',[BookingController::class,'getBookingByCustomer'])->name('bookings.customer');
Route::resource('bookings', BookingController::class);

// Send Voucher Route
Route::get('send/voucher/{id}', [BookingController::class, 'sendVoucher'])->name('send.voucher');
Route::get('delete/booking-customer/{id}', [BookingController::class, 'deleteBookingCustomerId'])->name('delete.booking-customer');
// Estimate Razorpay Payment Success
Route::get('bookings/send-voucher-link/{id}', [BookingController::class, 'sendLink'])->name('bookings.send-voucher-link');

// Estimate Razorpay Payment Success
Route::put('bookings/send-voucherlink-message/{id}', [BookingController::class, 'sendLinkMessage'])->name('bookings.send-voucherlink-message');

Route::get('bookings/send-whatsapp-message/{id}', [BookingController::class, 'sendWhatsappMessage'])->name('bookings.send-whatsapp-message');

// Generate Permit Link Route
Route::post('generate/permit-link', [BookingController::class, 'generatePermitLink'])->name('generate.permit-link');

// Get Permits
Route::get('permits/{slug}', [BookingController::class, 'getPermits'])->name('get.permits');

// Cancellation Requests
Route::get('booking/cancellation-request', [BookingController::class, 'cancellationRequests'])->name('cancellation.requests');
Route::post('approval-amount',[BookingController::class,'approvalAmount'])->name('cancelrequest.approval_amount');
// Generate Permit Download
Route::get('download/permit/{id}', [BookingController::class, 'downloadPermit'])->name('download.permit');
Route::get('download/package/permit/{id}', [BookingController::class, 'downloadPackagePermit'])->name('download.package.permit');
Route::get('download/tour/permit/{id}', [BookingController::class, 'downloadTourPermit'])->name('download.tour.permit');
// Cancel Booking
Route::post('cancel/booking', [BookingController::class, 'cancelBooking'])->name('cancel.Booking');
Route::post('cancel/booking/list', [BookingController::class, 'cancelBookingList'])->name('cancel.BookingList');
Route::post('cancelrequest/booking', [BookingController::class, 'cancelBookingRequest'])->name('cancelrequest.Booking');
// Safari Booking Route
Route::resource('safari-booking', SafariBookingController::class);
Route::get('safari-booking/convert/{lead}', [SafariBookingController::class, 'convert'])->name('safari-booking.convert');
Route::put('safari-booking/upload-permit/{id}', [SafariBookingController::class, 'upload'])->name('booking.upload-permit');
Route::get('safari-booking/voucher/{id}', [SafariBookingController::class, 'voucher'])->name('safari-booking.voucher');
Route::get('safari-booking/estimate/convert/{estimate}', [SafariBookingController::class, 'booking'])->name('safari.convert-estimate');

// Cab Booking Route
Route::resource('cab-booking', CabBookingController::class);
Route::get('cab-booking/convert/{lead}', [CabBookingController::class, 'convert'])->name('cab-booking.convert');
Route::any('cab-booking/voucher/{id}', [CabBookingController::class, 'voucher'])->name('cab-booking.voucher');
Route::get('cab-booking/estimate/convert/{estimate}', [CabBookingController::class, 'booking'])->name('cab.convert-estimate');

// Hotel Booking Route
Route::resource('hotel-booking', HotelBookingController::class);
Route::get('hotel-booking/convert/{lead}', [HotelBookingController::class, 'convert'])->name('hotel-booking.convert');
Route::get('hotel-booking/voucher/{id}', [HotelBookingController::class, 'voucher'])->name('hotel-booking.voucher');
Route::get('hotel-booking/estimate/convert/{estimate}', [HotelBookingController::class, 'booking'])->name('hotel.convert-estimate');

// Tour Booking Route
Route::resource('tour-booking', TourBookingController::class);
Route::get('tour-booking/convert/{lead}', [TourBookingController::class, 'convert'])->name('tour-booking.convert');
Route::get('tour-booking/voucher/{id}', [TourBookingController::class, 'voucher'])->name('tour-booking.voucher');
Route::get('tour-booking/estimate/convert/{estimate}', [TourBookingController::class, 'booking'])->name('tour.convert-estimate');

// Package Booking Route
Route::resource('package-booking', PackageBookingController::class);
Route::get('package-booking/convert/{lead}', [PackageBookingController::class, 'convert'])->name('package-booking.convert');
Route::get('package-booking/voucher/{id}', [PackageBookingController::class, 'voucher'])->name('package-booking.voucher');
Route::get('package-booking/estimate/convert/{estimate}', [PackageBookingController::class, 'booking'])->name('package.convert-estimate');


// Booking Transactions Route
Route::resource('booking-transactions', BookingTransactionController::class);
// Booking Refund Transactions Route
Route::resource('booking-refund-transactions', RefundTransactionController::class);
// Booking Reminder Route
Route::resource('booking-reminders', BookingReminderController::class);


// Invoice Route
Route::resource('invoices', InvoiceController::class);

// Tax Invoice Route
Route::get('tax-invoice/{id}', [InvoiceController::class, 'taxInvoice'])->name('tax.invoice');

// Tax Invoice Route
Route::get('download-invoice/{id}', [InvoiceController::class, 'download'])->name('download.invoice');

//Tax Invoice Print
Route::get('Printinvoice/{id}', [InvoiceController::class, 'PrintInvoice'])->name('Printinvoice');

// Credit Note Route
Route::get('credit-note/{id}', [CreditNoteController::class, 'creditNote'])->name('credit.note');

// Credit Note Route
Route::get('download-credit-note/{id}', [CreditNoteController::class, 'downloadCreditNote'])->name('download.credit.note');

// Report Route
Route::resource('reports', ReportController::class);

// Company Route
Route::resource('companies', CompanyController::class);

// Customers Routes
Route::get('search/customers', [CustomerController::class, 'searchCustomer'])->name('customers.search');
Route::resource('customers', CustomerController::class);


// Hotels Routes
Route::resource('hotels', HotelController::class);

Route::get('delete-image/{id}' , [HotelController::class, 'deleteImage'])->name('delete-image');

// Get Hotels
Route::get('get-hotels', [HotelController::class, 'getHotels'])->name('get.hotels');

// Get Rooms
Route::get('hotel-rooms', [HotelController::class, 'getRooms'])->name('get.rooms');

// Get Services
Route::get('room-services', [HotelController::class, 'getServices'])->name('get.services');

// Calculate Total
Route::post('calculate-total', [HotelController::class, 'calculateTotal'])->name('calculate.total');

// Get Inclusions
Route::post('get-inclusions', [InclusionController::class, 'getInclusions'])->name('get.inclusions');
Route::post('get-package-inclusions', [InclusionController::class, 'getPackageInclusions'])->name('get.package.inclusions');

// Get Exclusions
Route::post('get-exclusions', [ExclusionController::class, 'getExclusions'])->name('get.exclusions');
Route::post('get-package-exclusions', [ExclusionController::class, 'getPackageExclusions'])->name('get.package.exclusions');

// Get Terms
Route::post('get-terms', [EstimateTermsController::class, 'getTerms'])->name('get.terms');
Route::post('get-package-terms', [EstimateTermsController::class, 'getPackageTerms'])->name('get.package.terms');


// Get Terms
Route::post('get-voucher-terms', [VoucherTermsController::class, 'getTerms'])->name('get.voucher.terms');

//Download Hotel images
Route::get('hotel/downloads/{id}', [HotelController::class, 'downloadImages'])->name('download.hotel.images');

// Rooms Routes
Route::resource('rooms', RoomController::class);

// User Activity Routes
Route::resource('user-activities', UserActivityController::class);

// Term and Conditions Routes
Route::resource('default/terms-and-conditions', TermAndConditionController::class, [
    'names' => [
        'index'      => 'terms-and-conditions.index',
        'create'      => 'terms-and-conditions.create',
        'update'      => 'terms-and-conditions.update',
        'edit'      => 'terms-and-conditions.edit',
        'store'      => 'terms-and-conditions.store',
        'show'       => 'terms-and-conditions.show',
        'destroy'    => 'terms-and-conditions.destroy',
    ]
]);

// estimate destination
Route::resource('estimate-destinations', EstimateDestinationController::class);

// Terms & Conditions Routes
Route::get('default/estimate/terms', [EstimateTermsController::class, 'index'])->name('terms.index');
Route::delete('default/estimate/terms-delete/{id}', [EstimateTermsController::class, 'destroy'])->name('terms.destroy');

// Hotel Terms & Conditions Routes
Route::post('default/terms/hotel', [EstimateTermsController::class, 'saveHotelTerms'])->name('hotel.terms.save');
Route::post('default/terms-update/hotel', [EstimateTermsController::class, 'updateHotelTerms'])->name('hotel.terms.update');

// Safari Terms & Conditions Routes
Route::post('default/terms/safari', [EstimateTermsController::class, 'saveSafariTerms'])->name('safari.terms.save');
Route::post('default/terms-update/safari', [EstimateTermsController::class, 'updateSafariTerms'])->name('safari.terms.update');

// Cab Terms & Conditions Routes
Route::post('default/terms/cab', [EstimateTermsController::class, 'saveCabTerms'])->name('cab.terms.save');
Route::post('default/terms-update/cab', [EstimateTermsController::class, 'updateCabTerms'])->name('cab.terms.update');

// Tour Terms & Conditions Routes
Route::post('default/terms/tour', [EstimateTermsController::class, 'saveTourTerms'])->name('tour.terms.save');
Route::post('default/terms-update/tour', [EstimateTermsController::class, 'updateTourTerms'])->name('tour.terms.update');

// Package Terms & Conditions Routes
Route::post('default/terms/package', [EstimateTermsController::class, 'savePackageTerms'])->name('package.terms.save');
Route::post('default/terms-update/package', [EstimateTermsController::class, 'updatePackageTerms'])->name('package.terms.update');

// Inclusions Routes
Route::get('default/estimate/inclusions', [InclusionController::class, 'index'])->name('inclusions.index');
Route::delete('default/estimate/inclusions-delete/{id}', [InclusionController::class, 'destroy'])->name('inclusions.destroy');

// Hotel Inclusions Routes
Route::post('default/inclusions/hotel', [InclusionController::class, 'saveHotelInclusions'])->name('hotel.inclusions.save');
Route::post('default/inclusions-update/hotel', [InclusionController::class, 'updateHotelInclusions'])->name('hotel.inclusions.update');

// Safari Inclusions Routes
Route::post('default/inclusions/safari', [InclusionController::class, 'saveSafariInclusions'])->name('safari.inclusions.save');
Route::post('default/inclusions-update/safari', [InclusionController::class, 'updateSafariInclusions'])->name('safari.inclusions.update');

// Cab Inclusions Routes
Route::post('default/inclusions/cab', [InclusionController::class, 'saveCabInclusions'])->name('cab.inclusions.save');
Route::post('default/inclusions-update/cab', [InclusionController::class, 'updateCabInclusions'])->name('cab.inclusions.update');

// Tour Inclusions Routes
Route::post('default/inclusions/tour', [InclusionController::class, 'saveTourInclusions'])->name('tour.inclusions.save');
Route::post('default/inclusions-update/tour', [InclusionController::class, 'updateTourInclusions'])->name('tour.inclusions.update');

// Package Inclusions Routes
Route::post('default/inclusions/package', [InclusionController::class, 'savePackageInclusions'])->name('package.inclusions.save');
Route::post('default/inclusions-update/package', [InclusionController::class, 'updatePackageInclusions'])->name('package.inclusions.update');

// Exclusions Routes
Route::get('default/estimate/exclusions', [ExclusionController::class, 'index'])->name('exclusions.index');
Route::delete('default/estimate/exclusions-delete/{id}', [ExclusionController::class, 'destroy'])->name('exclusions.destroy');

// Hotel Exclusions Routes
Route::post('default/exclusions/hotel', [ExclusionController::class, 'saveHotelExclusions'])->name('hotel.exclusions.save');
Route::post('default/exclusions-update/hotel', [ExclusionController::class, 'updateHotelExclusions'])->name('hotel.exclusions.update');

// Safari Exclusions Routes
Route::post('default/exclusions/safari', [ExclusionController::class, 'saveSafariExclusions'])->name('safari.exclusions.save');
Route::post('default/exclusions-update/safari', [ExclusionController::class, 'updateSafariExclusions'])->name('safari.exclusions.update');

// Cab Exclusions Routes
Route::post('default/exclusions/cab', [ExclusionController::class, 'saveCabExclusions'])->name('cab.exclusions.save');
Route::post('default/exclusions-update/cab', [ExclusionController::class, 'updateCabExclusions'])->name('cab.exclusions.update');

// Tour Exclusions Routes
Route::post('default/exclusions/tour', [ExclusionController::class, 'saveTourExclusions'])->name('tour.exclusions.save');
Route::post('default/exclusions-update/tour', [ExclusionController::class, 'updateTourExclusions'])->name('tour.exclusions.update');

// Package Exclusions Routes
Route::post('default/exclusions/package', [ExclusionController::class, 'savePackageExclusions'])->name('package.exclusions.save');
Route::post('default/exclusions-update/package', [ExclusionController::class, 'updatePackageExclusions'])->name('package.exclusions.update');

// Long Weekend Routes
Route::resource('default/long-weekends', LongWeekendController::class, [
    'names' => [
        'index'      => 'long-weekends.index',
        'create'      => 'long-weekends.create',
        'update'      => 'long-weekends.update',
        'edit'      => 'long-weekends.edit',
        'store'      => 'long-weekends.store',
        'show'       => 'long-weekends.show',
        'destroy'    => 'long-weekends.destroy',
    ]
]);

// Marquee Routes
Route::resource('default/marquees', MarqueeController::class, [
    'names' => [
        'index'      => 'marquees.index',
        'create'      => 'marquees.create',
        'update'      => 'marquees.update',
        'edit'      => 'marquees.edit',
        'store'      => 'marquees.store',
        'show'       => 'marquees.show',
        'destroy'    => 'marquees.destroy',
    ]
]);

// Vendor Routes
Route::resource('default/vendor', VendorController::class, [
        'names' => [
            'index'      => 'vendor.index',
            'store'      => 'vendor.store',
            'show'       => 'vendor.show',
            'destroy'    => 'vendor.destroy',
        ]
    ])->except(['show', 'edit', 'create', 'update']);

// Permit Routes
Route::resource('default/permit', PermitController::class, [
    'names' => [
        'index'      => 'permit.index',
        'store'      => 'permit.store',
        'show'       => 'permit.show',
        'destroy'    => 'permit.destroy',
        ''=>'permit.generate_permits'
    ]
])->except(['show', 'edit', 'create', 'update']);

Route::get('default/generate/permits', [PermitController::class, 'generatePermits'])->name('permit.generate_permits');

Route::resource('default/local-address', AddressController::class, [
    'names' => [
        'index'      => 'local-address.index',
        'store'      => 'local-address.store',
        'show'       => 'local-address.show',
        'destroy'    => 'local-address.destroy',
    ]
])->except(['show', 'edit', 'create', 'update']);

Route::get('get-iternaries', [IternaryController::class, 'getIternaries'])->name('get.iternaries');
Route::get('show-iternaries', [IternaryController::class, 'showIternaries'])->name('show.iternaries');
Route::get('default/iternary/add/{id}', [IternaryController::class, 'addIternary'])->name('iternary.add');
Route::delete('default/iternary/delete/{id}', [IternaryController::class, 'deleteIternary'])->name('iternary.delete');
Route::put('default/iternary/update/{id}', [IternaryController::class, 'updateIternary'])->name('iternaries.update');
Route::resource('default/iternary', IternaryController::class, [
    'names' => [
        'index'      => 'iternary.index',
        'store'      => 'iternary.store',
        'show'       => 'iternary.show',
        'update'     => 'iternary.update',
        'destroy'    => 'iternary.destroy',
        'edit'       => 'iternary.edit'
    ]
])->except(['create']);

// Invoice Terms & Conditions Routes
Route::get('default/invoice/terms', [InvoiceTermsController::class, 'index'])->name('invoice.terms.index');
Route::post('default/invoice/terms', [InvoiceTermsController::class, 'save'])->name('invoice.terms.save');
Route::post('default/terms-update/invoice', [InvoiceTermsController::class, 'update'])->name('invoice.terms.update');
Route::delete('default/invoice/terms-delete/{id}', [InvoiceTermsController::class, 'destroy'])->name('invoice.terms.destroy');


// Voucher Terms & Conditions Routes
Route::get('default/voucher/terms', [VoucherTermsController::class, 'index'])->name('voucher.terms.index');
Route::delete('default/voucher/terms-delete/{id}', [VoucherTermsController::class, 'destroy'])->name('voucher.terms.destroy');

// Voucher Hotel Terms & Conditions Routes
Route::post('default/voucher/terms/hotel', [VoucherTermsController::class, 'saveHotelTerms'])->name('voucher.hotel.terms.save');
Route::post('default/voucher/terms-update/hotel', [VoucherTermsController::class, 'updateHotelTerms'])->name('voucher.hotel.terms.update');

// Voucher Package Terms & Conditions Routes
Route::post('default/voucher/terms/package', [VoucherTermsController::class, 'savePackageTerms'])->name('voucher.package.terms.save');
Route::post('default/voucher/terms-update/package', [VoucherTermsController::class, 'updatePackageTerms'])->name('voucher.package.terms.update');

// Voucher Safari Terms & Conditions Routes
Route::post('default/voucher/terms/safari', [VoucherTermsController::class, 'saveSafariTerms'])->name('voucher.safari.terms.save');
Route::post('default/voucher/terms-update/safari', [VoucherTermsController::class, 'updateSafariTerms'])->name('voucher.safari.terms.update');

// Voucher Cab Terms & Conditions Routes
Route::post('default/voucher/terms/cab', [VoucherTermsController::class, 'saveCabTerms'])->name('voucher.cab.terms.save');
Route::post('default/voucher/terms-update/cab', [VoucherTermsController::class, 'updateCabTerms'])->name('voucher.cab.terms.update');

// Voucher Tour Terms & Conditions Routes
Route::post('default/voucher/terms/tour', [VoucherTermsController::class, 'saveTourTerms'])->name('voucher.tour.terms.save');
Route::post('default/voucher/terms-update/tour', [VoucherTermsController::class, 'updateTourTerms'])->name('voucher.tour.terms.update');

// Chancellation charges
Route::get('default/chancellation-charges', [CancellationController::class, 'index'])->name('chancellation-charges.index');
Route::post('default/chancellation-charges/cab', [CancellationController::class, 'cabStore'])->name('chancellation-charges.cab.store');
Route::post('default/chancellation-charges/hotel', [CancellationController::class, 'hotelStore'])->name('chancellation-charges.hotel.store');

Route::post('default/chancellation-charges/safari', [CancellationController::class, 'safariStore'])->name('chancellation-charges.safari.store');
Route::get('chancellation-charges/safari/{destination}', [CancellationController::class, 'safariCreate'])->name('chancellation-charges.safari.create');


Route::post('default/chancellation-charges/tour', [CancellationController::class, 'tourStore'])->name('chancellation-charges.tour.store');
Route::get('chancellation-charges/tour/{destination}', [CancellationController::class, 'tourCreate'])->name('chancellation-charges.tour.create');


Route::post('default/chancellation-charges/package', [CancellationController::class, 'packageStore'])->name('chancellation-charges.package.store');
Route::get('chancellation-charges/package/{destination}', [CancellationController::class, 'packageCreate'])->name('chancellation-charges.package.create');



// Offline Payment Mode Routes
Route::resource('offline-mode', OfflineModeController::class);

// UPI Payment Mode Routes
Route::resource('upi-mode', UpiModeController::class);

// Razorpay Payment Mode Routes
Route::resource('razorpay-mode', RazorpayModeController::class);

// Users Routes
Route::resource('users', UserController::class);
Route::get('users-online', [UserController::class, 'onlineUsers'])->name('online.users');
Route::post('toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
// Roles Routes
Route::resource('roles', RoleController::class);

// Permissions Routes
Route::resource('permissions', PermissionController::class);

// My Account Routes
Route::get('my-account', [MyAccountController::class, 'index'])->name('my-account');
Route::post('my-account', [MyAccountController::class, 'update'])->name('my-account.update');

// Change Password Routes
Route::get('change-password', [ChangePasswordController::class, 'index'])->name('change-password');
Route::post('change-password', [ChangePasswordController::class, 'update'])->name('change-password.update');

// Lead Status Routes
Route::resource('lead-status', LeadStatusController::class);
    });

//search lead
Route::post('search-leads',[LeadController::class,'searchLead'])->name('search-leads');

// Repots of Employees Routes

Route::get('no-of-estimates', [ReportEstimateController::class, 'index'])->name('no-of-estimates');
Route::get('no-of-bookings', [ReportBookingController::class, 'index'])->name('no-of-bookings');
Route::get('no-of-packages', [ReportPackageController::class, 'index'])->name('no-of-packages');
Route::get('no-of-safari', [ReportSafariController::class, 'index'])->name('no-of-safari');
Route::get('total-bookings', [ReportTotalBookingController::class, 'index'])->name('total-bookings');
Route::get('total-unpaid-estimates', [ReportTotalUnpaidEstimateController::class, 'index'])->name('total-unpaid-estimates');
Route::get('total-paid-estimates', [ReportTotalPaidEstimateController::class, 'index'])->name('total-paid-estimates');
Route::get('total-partial-booking', [ReportTotalPartialBookingController::class, 'index'])->name('total-partial-booking');
Route::get('total-members-booking', [ReportTotalMemberBookingController::class, 'index'])->name('total-members-booking');

// Invoice Route
Route::resource('support', SupportController::class);
Route::put('send-support-message/{id}', [SupportController::class, 'sendMessage'])->name('supports.send-message');

// Trash 
Route::get('trash-leads', [TrashController::class, 'leads'])->name('trash-leads');
Route::get('trash-leads/restore/{id}', [TrashController::class, 'restoreLeads'])->name('trash-leads.restore');
Route::delete('trash-leads/delete/{id}', [TrashController::class, 'deleteLead'])->name('trash-leads.delete');
Route::post('trash-leads/deletes', [TrashController::class, 'massDelete'])->name('trash-leads.deletes');

Route::get('trash-estimates', [TrashController::class, 'estimates'])->name('trash-estimates');
Route::get('trash-estimates/restore/{id}', [TrashController::class, 'restoreEstimates'])->name('trash-estimates.restore');
Route::get('trash-estimates/show/{id}', [TrashController::class, 'showEstimate'])->name('trash-estimate.show');
Route::delete('trash-estimates/delete/{id}', [TrashController::class, 'deleteEstimate'])->name('trash-estimates.delete');

Route::get('trash-bookings', [TrashBookingController::class, 'index'])->name('trash-bookings.index');
Route::get('trash-bookings/show/{id}', [TrashBookingController::class, 'showBooking'])->name('trash-booking.show');
Route::get('trash-booking/restore/{id}', [TrashBookingController::class, 'restoreBooking'])->name('trash-booking.restore');
Route::delete('trash-booking/delete/{id}', [TrashBookingController::class, 'deleteBooking'])->name('trash-booking.delete');


Route::get('track-refund/{id}',[BookingController::class,'trackRefund'])->name('bookings.track-refund');