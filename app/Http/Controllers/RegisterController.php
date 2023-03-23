<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

// 라라벨에서 기본적으로 지원하는 회원가입 클래스
class RegisterController extends Controller {

    protected $redirect = RouteServiceProvider::HOME;

    public function showRegisterationForm() {
        return view('boards.register');
    }


    // 요청이 들어온 정보를 검사한다. 문제가 없을 시 다음단계로 넘어간다.
    // make 메소드는 첫 번째 인수로 전달된 데이터 $data 배열의 형식을 검증하는 인스턴스를 만든다.
    protected function validator (array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'], // cofirmed 는 검증하는 필드
        ]);
    }

    // 해당 내용은 제출한 데이터를 배열로 받아 사용자를 생성하고 DB에 저장한다.
    protected function create(array $data) {
        return User::create ([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request) {
        // this->validator 를 호출 시 validator 인스턴스가 반환된다.
        // 이후 validate() 메소드를 호출 후 입력 데이터를 검사한다.
        // validate() : validator(검증기) 가 만든 규칙에 따라 요청 데이터를 검증한다. 실패시 예외처리
        $this->validator($request->all())->validate();

        // registered 이벤트가 발생 시 해당 이벤트는 새로운 사용자가 등록되었을 경우 실행되며
        // 등록된 사용자의 정보를 담고있는 $user 객체를 전달한다.
        // EventServiceProvider : 모든 이벤트 리스너들을 등록하는 장소이다.
        // event(new Registered($user)) : 아래에 있는 SendEmailVerificationNotification 리스너를 가져온다. 해당 리스너는 이메일 검증 링크를 보낸다.
        event(new Registered($user = $this->create($request->all())));

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);

        // $user 객체를 받은 후 로그인
        // Auth::login($user);

        return redirect()->route('login')->with('message', '메일이 전송되었습니다. 인증 후 사용해주세요.');
    }

    protected function registered($user) {
        // 인증메일 전송
        // AuthServiceProvider 에서 메일에 담아 보낼 내용을 정의한다.
        $user->sendEmailVerificationNotification();
    }

}
