<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/boards');
});


// boards 로 get 요청이 올 경우 boardController 의 index 함수를 실행한다.
// name 은 별명으로 ->name('board.index') 를 작성 시 나중에 route('board.index')로 쉽게 주소 출력이 가능하다.

// 각각의 메소드를 통한 Route지정도 가능 하지만 이런식으로 한번에 처리 할 시 라우팅에 대한 규칙을 일괄적으로 생성 할 수 있다.
// resource 사용 시 자동으로 GET, POST, PUT/PATCH, DELETE 등 HTTP 요청에 따른 메소드가 호출된다. API 할 때 사용한다.
// Route::resource('/boards', BoardController::class);

Route::get('/boards', [BoardController::class, 'index'])->name('boards.index');
// create가 밑으로 가면 동작을 안한다.
Route::get('/boards/create', [BoardController::class, 'create'])->name('boards.create');
Route::get('/boards/{board}', [BoardController::class, 'show'])->name('boards.show');
Route::post('/boards/{board}/edit', [BoardController::class, 'edit'])->name('boards.edit');
Route::put('/boards/{board}/update', [BoardController::class, 'update'])->name('boards.update');
Route::delete('/boards/{board}/destroy', [BoardController::class, 'destroy'])->name('boards.destroy');
Route::post('/boards/store', [BoardController::class, 'store'])->name('boards.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// 10분에 5번 시도
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// 이메일 검증 링크 발송
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// 이메일 검증 핸들러
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/login');
})->middleware(['auth', 'signed'])->name('verification.verify');


// 이메일 검증 재발송
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
