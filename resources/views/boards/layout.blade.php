<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Board</title>
</head>
    <body>
        <div class="container">

            @auth
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    {{ Auth::user()->name }} 님
                    <button type="submit" class="btn btn-sm btn-secondary">로그아웃</button>
                </form>
            @else
                <a href="{{ route('login') }}">로그인 / </a>
                {{-- <a href="{{ route('register') }}">회원가입</a> --}}
            @endauth

            @yield('content')
            @yield('modal')
            @yield('script')
        </div>
    </body>
</html>
