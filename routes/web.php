<?php

Route::domain('studies-laravel-tenancy.test')->group(function () {

    // Landing Page Routes
    Route::get('/', function () {
        return view('welcome');
    });

    // Registration Routes
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    // Login Routes
    Route::get('login', 'Auth\LoginController@showDomainForm')->name('login.domain');
    Route::post('login', 'Auth\LoginController@routeToTenant');

    // Catch All Route
    Route::any('{any}', function () {
        abort(404);
    })->where('any', '.*');

});

// Ensure that the tenant exists with the tenant.exists middleware
Route::middleware('tenant.exists')->group(function () {
    // Not Logged In
    Route::get('/', function () {
        return view('tenant-welcome');
    });

    // Login Routes
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Password Reset Routes
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    // Email Verification Routes
    Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

    // Register Routes
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
});

// Logged in
Route::get('/home', 'HomeController@index')->name('home');
