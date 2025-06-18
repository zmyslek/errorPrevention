<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Home route
Route::get('/', fn() => view('welcome'));

// Registration form
Route::get('/register', fn() => view('form'))->name('register.form');

// Form submission with validation
Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|min:2|max:50',
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);
    return redirect('/register')->with('success', 'Registration successful!');
})->name('register.submit');

// Simulate 500 error
Route::get('/trigger-500', fn() => abort(500));

?>
