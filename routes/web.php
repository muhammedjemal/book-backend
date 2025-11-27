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