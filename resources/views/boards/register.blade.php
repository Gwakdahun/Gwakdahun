<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<style type="text/css">
    .container {
        margin-top: 10%;
    }

    .col-md-6 {
        margin: 5px;
    }

    .btn-group {
        margin-top: 20px;
        width: 200%;
    }

</style>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">회원가입</div>

                        {{-- 이름 입력 --}}
                        <div class="card-body">
                            <form method="POST" action="{{ route('register.submit') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">이름</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> {{-- col-md-6 end --}}
                                </div> {{-- form-group row end --}}


                                {{-- 이메일 입력 --}}
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">이메일</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> {{-- col-md-6 end --}}
                                </div> {{-- form-group row end --}}


                                {{-- 비밀번호 입력 --}}
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">비밀번호</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> {{-- col-md-6 end --}}
                                </div> {{-- form-group row end --}}


                                {{-- 비밀번호 재확인 --}}
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">비밀번호 재입력</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                {{-- 보내기 --}}
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn btn-outline-primary" href="{{ route('login') }}">로그인</a>
                                            <a class="btn btn btn-outline-primary" href="{{ route('boards.index') }}">비회원</a>
                                        </div>

                                        <button type="submit" class="btn btn btn-outline-primary" style="width: 200%; margin-top: 5px;">회원가입</button>
                                    </div> {{-- col-md-6 offset-md-4 end --}}
                                </div> {{-- form-group row mb-0 end --}}

                            </form>
                        </div> {{-- card-body end --}}
                    </div> {{-- card end --}}
                </div> {{-- col-md-8 end --}}
            </div> {{-- row justify-content-center end --}}
        </div> {{-- container end --}}
    </body>
