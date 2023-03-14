<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use APP\Models\User;

class RegisterController extends Controller {
    protected $redirect = RouteServiceProvider::HOME;

    public function __construct() {
        $this->middleware('guest');
    }

    protected function validator (array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'], // cofirmed 는 검증하는 필드
        ]);
    }

    protected function create(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        // 이메일 인증 이메일 전송
        $user->sendEmailVerificationNotification();
    }



}
