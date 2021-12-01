<?php

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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'api\UserApiController@login');
Route::post('/forgetpassword', 'api\UserApiController@forgetPassword');
Route::post('/register', 'api\UserApiController@register');
Route::post('/sendotp', 'api\UserApiController@sendotp');
Route::post('/resendotp', 'api\UserApiController@resendotp');
Route::post('/checkotp', 'api\UserApiController@checkotp');

Route::get('/settings','api\UserApiController@settings');
Route::get('/sharedSettings','api\UserApiController@sharedSettings');

Route::get('/salons', 'api\UserApiController@salons');
Route::get('/salon/{id}', 'api\UserApiController@singleSalon');
Route::get('/categories', 'api\UserApiController@categories');

Route::get('/coupon', 'api\UserApiController@allCoupon');

Route::get('/banners', 'api\UserApiController@banners');
Route::get('/offers', 'api\UserApiController@offers');

Route::post('/timeslot', 'api\UserApiController@timeSlot');
Route::post('/selectemp', 'api\UserApiController@selectEmp');

Route::get('/catsalon/{id}', 'api\UserApiController@catSalon');
Route::post('/nearbysalon', 'api\UserApiController@nearbySalon');

Route::post('/search', 'api\UserApiController@search');

Route::post('/bookingStatusPush', 'owner\BookingController@changeStatus');

/* Saloon Product*/
Route::get('/salon-product/{id}', 'admin\ProductController@apiProductList');
Route::get('/product-details/{id}', 'admin\ProductController@apiProductDetails');


Route::middleware('auth:api')->group(function()
{
    Route::get('/profile', 'api\UserApiController@showUser');
    Route::post('/profile/edit', 'api\UserApiController@editUser');
    Route::post('/profile/address/add', 'api\UserApiController@addUserAddress');
    Route::get('/profile/address/remove/{id}', 'api\UserApiController@removeUserAddress');

    Route::post('/checkcoupon', 'api\UserApiController@checkCoupon');

    Route::post('/booking', 'api\UserApiController@booking');

    Route::get('/appointment', 'api\UserApiController@showAppointment');
    Route::get('/appointment/{id}', 'api\UserApiController@singleAppointment');
    Route::get('/appointment/cancel/{id}', 'api\UserApiController@cancelAppointment');

    Route::post('/addreview','api\UserApiController@addReview');

    Route::post('/changepassword', 'api\UserApiController@changePassword');

    Route::get('/notification', 'api\UserApiController@notification');
    Route::get('/payment_gateway', 'api\UserApiController@payment_gateway');

    Route::post('/checkout/{amount}', 'api\OrderController@stripe_payment');
    Route::post('/order', 'api\OrderController@order');


});

// Owner ---------------------------
Route::post('/admin/login', 'api\AdminApiController@login');
Route::post('/admin/register', 'api\AdminApiController@register');
Route::post('/admin/forgetpassword', 'api\AdminApiController@forgetpassword');
Route::get('/admin/appSetting', 'api\AdminApiController@appSetting');
Route::post('/admin/addSalon', 'api\AdminApiController@addSalon');

Route::prefix('admin')->middleware(['auth:api'])->group(function()
{
    // Profile
    Route::get('/dashboard', 'api\AdminApiController@dashboard');
    Route::post('/editProfile', 'api\AdminApiController@editProfile');
    Route::get('/showProfile', 'api\AdminApiController@showProfile');
    Route::post('/changePassword', 'api\AdminApiController@changePassword');

    // Users
    Route::get('/clients', 'api\AdminApiController@clients');
    Route::get('/allClients', 'api\AdminApiController@allClients');
    Route::post('/addClient', 'api\AdminApiController@addClient');
    Route::get('/showClient/{id}', 'api\AdminApiController@showClient');
    Route::get('/clientAddress/{id}', 'api\AdminApiController@clientAddress');
    Route::post('/addAddress', 'api\AdminApiController@addAddress');

    // Salon
    Route::get('/showSalon', 'api\AdminApiController@showSalon');
    Route::post('/editSalon', 'api\AdminApiController@editSalon');

    // Employee
    Route::get('/employees', 'api\AdminApiController@employees');
    Route::get('/showEmployee/{id}', 'api\AdminApiController@showEmployee');
    Route::post('/addEmp', 'api\AdminApiController@addEmp');
    Route::post('/editEmployee', 'api\AdminApiController@editEmployee');
    Route::get('/deleteEmployee/{id}', 'api\AdminApiController@deleteEmployee');
    Route::get('/empAppointment/{id}', 'api\AdminApiController@empAppointment');


    // Service
    Route::get('/services', 'api\AdminApiController@services');
    Route::get('/allServices', 'api\AdminApiController@allServices');
    Route::get('/categories', 'api\AdminApiController@categories');
    Route::get('/showService/{id}', 'api\AdminApiController@showService');
    Route::post('/addService', 'api\AdminApiController@addService');
    Route::post('/editService', 'api\AdminApiController@editService');
    Route::get('/deleteService/{id}', 'api\AdminApiController@deleteService');

    // Gallery
    Route::get('/gallery', 'api\AdminApiController@gallery');
    Route::post('/addGallery', 'api\AdminApiController@addGallery');
    Route::get('/deleteGallery/{id}', 'api\AdminApiController@deleteGallery');

    // Review
    Route::get('/review', 'api\AdminApiController@review');
    Route::post('/reviewReport', 'api\AdminApiController@review_report');

    // Appointment
    Route::get('/allAppointments', 'api\AdminApiController@allAppointments');
    Route::get('/CalAppointments', 'api\AdminApiController@calAppointments');
    Route::get('/appointments', 'api\AdminApiController@appointments');
    Route::post('/addAppointment', 'api\AdminApiController@addAppointment');
    Route::get('/showAppointment/{id}', 'api\AdminApiController@showAppointment');
    Route::post('/changeStatus', 'api\AdminApiController@changeStatus');

    Route::post('/selectEmp', 'api\AdminApiController@selectEmp');
    Route::post('/timeslot', 'api\AdminApiController@timeslot');

    // Notification
    Route::get('/appNotification', 'api\AdminApiController@notification');
    Route::get('/clearNotification', 'api\AdminApiController@clearNotification');

    // Setting
    Route::post('/mail', 'api\AdminApiController@setting_mail');
    Route::post('/notification', 'api\AdminApiController@setting_notification');

});

Route::get('/employee/appSetting', 'api\EmployeeApiController@appSetting');
Route::post('/employee/login', 'api\EmployeeApiController@login');

Route::prefix('employee')->middleware(['auth:empApi'])->group(function()
{
    Route::get('/allAppointment', 'api\EmployeeApiController@allAppointment');
    Route::post('/editProfile', 'api\EmployeeApiController@editProfile');
    Route::get('/profile', 'api\EmployeeApiController@profile');
    Route::post('/changePassword', 'api\EmployeeApiController@changePassword');
    Route::get('/singleAppointment/{id}', 'api\EmployeeApiController@singleAppointment');
    Route::post('/statusChange', 'api\EmployeeApiController@statusChange');
    Route::get('/dashboard', 'api\EmployeeApiController@dashboard');
    Route::post('/dashboard_filter', 'api\EmployeeApiController@dashboard_filter');
    Route::get('/notification', 'api\EmployeeApiController@notification');
    Route::get('/clearNotification', 'api\EmployeeApiController@clearNotification');
});

