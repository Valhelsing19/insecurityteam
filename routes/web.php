<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/login/official', function () {
    return view('login_official');
});

Route::get('/register', function () {
    return view('create_account');
});

Route::get('/dashboard/official', function () {
    return view('dashboard_official');
});

Route::get('/all-requests', function () {
    return view('all_requests_official');
});

Route::get('/all-requests/official', function () {
    return view('all_requests_official');
});

Route::get('/forgot-password', function () {
    return view('forgot_password');
});

Route::get('/reset-password', function () {
    return view('new_password');
});

Route::get('/submit-request', function () {
    return view('submit_request');
});

Route::get('/my-requests', function () {
    return view('request_management');
});

Route::get('/settings', function () {
    return view('settings');
});

Route::get('/settings/official', function () {
    return view('settings_official');
});

Route::get('/reports', function () {
    return view('reports');
});

Route::get('/official/page', function () {
    return view('official_page');
});

Route::get('/resident/page', function () {
    return view('resident_page');
});
