<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm() {

        return view('boards.login');
    }

    public function login(Request $request) {
        // 사용자가 제출한 로그인 폼에서 'email'과 'password' 값을 가져온다.
        $credentials = $request->only('email', 'password');

        // Auth::attempt : 인증을 시도하며, 성공 시 true, 실패 시 false를 반환
        if(Auth::attempt($credentials)) {

            // 인증에 성공 시 세션을 다시 생성한다. 보안 상의 이유이며 하이재킹과 같은 공격을 방지하기 위함.
            $request->session()->regenerate();

            //현재 로그인된 사용자를 가져온다.
            // $user = Auth::user();

            // 사용자가 로그인을 시도하기 전에 원래의 목적지로 사용자를 다시 보낸다.
            // 사용자가 로그인 페이지가 아닌 다른 페이지에서 로그인 페이지로 리다이렉션되었을 경우 유용하다.
            return Redirect()->intended('/boards');
        }

        return back()->withErrors([
            'email' => '이메일 또는 비밀번호가 일치하지 않습니다.',
        ]);
    }

    public function logout(Request $request) {
        // 현재 인증된 사용자를 로그아웃한다.
        Auth::logout();

        // 현재 세션을 무효화한다. 이전 세션에 저장된 모든 데이터를 지우고 새로운 세션을 시작한다.
        $request->session()->invalidate();

        // 새로운 CSRF 토큰을 생성한다. 이전에 생성된 CSRF 토큰은 무효화 되므로 보안을 강화할 수 있다.
        $request->session()->regenerateToken();

        return redirect('/boards');
    }

}
