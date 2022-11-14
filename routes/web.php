<?php

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

use App\Http\Requests\EditUserRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/publish', function () {
    if(! Auth::check()) {
        return redirect()->route('home');
    }

    return view('publish', ['user' => Auth::user()]);
})->name('publish');

Route::get('/settings', function () {
    if(! Auth::check()) {
        return redirect()->route('home');
    }

    return view('setting');
})->name('settings');

Route::get('/users', function () {
    if(! Auth::check() && Auth::user()->name === 'admin') {
        return redirect()->route('home');
    }

    return view('users');
})->name('users');

Route::get('/history', function () {
    if(! Auth::check() && Auth::user()->name === 'admin') {
        return redirect()->route('home');
    }

    return view('history');
})->name('history');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/register', function () {
    if(!(Auth::check() && Auth::user()->name === 'admin')) {
        return redirect()->route('home');
    }

    return view('auth.register');
})->name('register');

Route::get('/edit-user', function (EditUserRequest $request) {
    $data = $request->validated();
    if(count($data) == 0) {
        $user = Auth::user();
    } else {
        $user = User::find($data['id']);
    }
    if(!(Auth::check() && (Auth::user()->name === 'admin' || Auth::user()->id === $user->id))) {
        return redirect()->route('home');
    }

    return view('EditUser', ['user' => $user]);
})->name('editUser');