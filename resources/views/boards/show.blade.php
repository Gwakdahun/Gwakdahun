@extends('boards.layout')

@section('content')

    <h1>{{ $board->title }}</h1>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('boards.index') }}" class="btn btn-dark">Back</a>

        {{-- 글 수정 --}}
        <form action="{{ route('boards.edit', $board->idx) }}" id="editForm" method="POST" style="display: inline-block;">
            @csrf
            <input type="hidden" name="board" id="board" value="{{ $board->idx }}">
            <input type="hidden" name="password" id="edit-password">
            <button type="submit" class="btn btn-primary" id="edit-btn">Edit</button>
        </form>

        <form action="{{ route('boards.destroy', $board->idx) }}" id="deleteForm" method="POST" style="display: inline-block;">
            {{-- csrf 보호기능을 사용할때 쓰는것 일반적으로 POST방식으로 전송하는 폼에는 사용해야한다. --}}
            @csrf
            {{-- HTML 양식은 PUT, PATCH, DELETE를 요청할 수 없다. 이러한 동작을 하려면 method 필드를 추가해야한다. --}}
            @method('DELETE')
            {{-- <input type="hidden" name="board" id="board" value="{{ $board->idx }}"> --}}
            <input type="hidden" name="password" id="delete-password">
            <button type="submit" class="btn btn-danger" id="del-btn">Delete</button>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            {{-- nl2br : 개행문자를 <br>태그로 변환해준다. --}}
            {{-- {!! !!} : HTML태그를 렌더링 하기 위해 사용하는 blade템플릿 엔진 표현 --}}
            {{-- e() : HTML 이스케이프하여 출력한다. XSS공격을 예방할 수 있다. --}}
            {{-- HTML이스케이프 : HTML 태그를 문자열로 처리하기 위해 태그 구분자 또는 특수문자를 특별한 형식으로 표현하는 것 --}}
            {{-- {{ nl2br(e($board->content)) }} 로도 출력이 가능하지만,
                입력 측에서 발생할 수 있는 태그문자 또는 스크립트 인젝션 등 보안이슈가 있다. --}}
            {!! nl2br(e($board->content)) !!}
        </div>

        <div class="card-footer text-muted">
            @if($board->user)
                {{ $board->user->name }}
            @else
                비회원
            @endif
        </div>

        <div class="card-footer text-muted">
            {{ $board->created_at ? $board->created_at->format('Y-m-d, H:i') : "" }}
        </div>

    </div> {{-- card end --}}

    <div class="password-body">
        @if (empty($board->user_idx))
            <form method="POST" id="passwordForm">
                <div class="form-group">
                    <label for="password-input">Password:</label>
                    <input type="password" class="form-control" id="password-input" name="password" style="width: 30%"; autofocus>
                </div>
            </form>
        @endif
    </div> {{-- password-body end --}}

    <script>
        $(document).ready(function() {
            // password 입력 요소의 값이 변경될 때마다 실행되는 이벤트 핸들러
            $('#password-input').on('input', function() {
                // hidden input 요소의 값을 변경
                $('#edit-password').val($(this).val());
                $('#delete-password').val($(this).val());
            });

            // Edit 버튼을 클릭하면, passwordForm을 제출하고 editForm을 제출합니다.
            $('#edit-btn').on('click', function() {
                // passwordForm을 editForm의 edit-password에 보내서 password-input 값을 담는다.
                $('#passwordForm').submit(function(e) {
                    $('#editForm #edit-password').val($('#password-input').val());
                }).submit();
            });

            // Delete 버튼을 클릭하면, passwordForm을 제출하고 deleteForm을 제출합니다.
            $('#del-btn').on('click', function() {
                $('#passwordForm').submit(function(e) {
                    $('#deleteForm #delete-password').val($('#password-input').val());
                }).submit();
            });
        });
    </script>
@endsection
