<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


<form method="POST" action="{{ route('login.submit') }}">
    @csrf

    <div>
        <label for="email">이메일 : </label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
    </div>

    <div>
        <label for="password">비밀번호 : </label>
        <input type="password" name="password" id="password" required>
    </div>

    <div>
        <label for="remember">로그인 기억하기</label>
        <input type="checkbox" name="remember" id="remember">
    </div>

    <div>
        <button type="submit">로그인</button>
    </div>

</form>

