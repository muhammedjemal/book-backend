<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



use App\Models\User;

Route::get('/get-admin', function () {
    $user = User::first(); // This grabs the first user (YOU)
    if($user) {
        $user->is_admin = true;
        $user->save();
        return "Success! User " . $user->name . " is now an Admin. email: " . $user->email ;
    }
    return "No users found.";
});  





use Illuminate\Support\Facades\Artisan;

// This is your emergency button
Route::get('/fix-cache', function () {
    try {
        Artisan::call('optimize:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        
        return '<h1>✅ FIXED!</h1> <p>Cache, Config, Routes, and Views have been cleared.</p>';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});


Route::get('/make-me-admin', function () {
    // 1. Get the latest created user
    $user = User::latest()->first();

    if (!$user) {
        return "No users found in the database.";
    }

    // 2. Make them Admin
    $user->is_admin = true;
    $user->save();

    return "Success! The latest user: <b>" . $user->name . "</b> (" . $user->email . ") is now an Admin.";
});