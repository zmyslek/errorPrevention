<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;


// Home route
Route::get('/', fn() => view('welcome'))->name ('dashboard');

// Registration form - use instead of standard Laravel auth
Route::get('/register', fn() => view('form'))->name('register.form');

// Form submission with validation
Route::post('/register',[RegisterController::class, 'store'])->name('register.submit');



// Simulate 500 error
Route::get('/trigger-500', fn() => abort(500));
//NOTE: routes to login, register, and password reset are defined in routes/auth.php and added in app.php !

Route::resource('users', UserController::class)->middleware('can:manage_users');

Route::fallback(function () {
    return Auth::check()
        ? redirect('/dashboard')
        : redirect('/login'); // or wherever your guest landing page is
});
?>
