<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<style>
    .container {
        margin-top: 10%
    }

    .row>* {
        width: 40%;
    }
    .btn-group {
        margin-top: 30px;
        width: 100%;
    }
</style>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">로그인</div>

                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-0 col-form-label text-md-right">이메일</label>
                            <div class="col-md-6">
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-0 col-form-label text-md-right">비밀번호</label>
                            <div class="col-md-6">
                                <input type="password" name="password" id="password" required>
                            </div>
                        </div>

                        <div>
                            <label for="remember">로그인 기억하기</label>
                            <input class="form-check-input col-md-2" type="checkbox" name="remember" id="remember">
                        </div>

                        <div>
                            <div class="btn-group" role="group">
                                <a class="btn btn btn-outline-primary" href="{{ route('register') }}">회원가입</a>
                                <a class="btn btn btn-outline-primary" href="{{ route('boards.index') }}">비회원</a>
                            </div>
                            <button class="btn btn btn-outline-primary" style="width: 100%; margin-top: 5px;" type="submit">로그인</button>
                        </div>
                    </form>
                </div> {{-- card-body end --}}
            </div> {{-- card end --}}
        </div> {{-- col-md-8 end --}}
    </div> {{-- row justify-content-center end --}}
</div> {{-- container end --}}

