<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        // If user is already logged in, go to dashboard
        return redirect('/admin');
    }
    
    // If not logged in, show a custom landing page for your school
    return view('welcome'); // Or create a school landing page
});