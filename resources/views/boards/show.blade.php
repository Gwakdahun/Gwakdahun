@extends('boards.layout')

@section('content')

    <h1>{{ $board->title }}</h1>

    <div class="mb-3">
        <a href="{{ route('boards.index') }}" class="btn btn-dark">Back</a>

        {{-- 글 수정 --}}
        <form action="{{ route('boards.edit', $board->idx) }}" method="POST" id="editForm" style="display: inline-block;">
            @csrf
            <input type="hidden" name="boardIdx" id="boardIdx" value="{{ $board->idx }}">
            <input type="hidden" name="password" id="edit-password">
            <button type="submit" class="btn btn-primary" id="edit-btn">Edit</button>
        </form>

        <form action="{{ route('boards.destroy', $board->idx) }}" id="deleteForm" method="POST" style="display: inline-block;">
            {{-- csrf 보호기능을 사용할때 쓰는것 일반적으로 POST방식으로 전송하는 폼에는 사용해야한다. --}}
            @csrf
            @method('DELETE')
            <input type="hidden" name="boardIdx" id="boardIdx" value="{{ $board->idx }}">
            <input type="hidden" name="password" id="delete-password">
            <button type="submit" class="btn btn-danger" id="del-btn">Delete</button>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            {{ $board->content }}
        </div>

        <div class="card-footer text-muted">
            @if($board->user)
                {{ $board->user->name }}
            @else
                비회원
            @endif
        </div>

        <div class="card-footer text-muted">
            {{ $board->created_at->format('Y-m-d, H:i') }}
        </div>
    </div> {{-- card end --}}

    <div class="password-body">
        @if (empty($board->user_idx))
            <form action="#" method="POST" id="passwordForm">
                <div class="form-group">
                    <label for="password-input">Password:</label>
                    <input type="password" class="form-control" id="password-input" name="password" style="width: 30%";>
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
                $('#passwordForm').submit(function(e) {
                    $('#editForm #edit-password').val($('#password-input').val());
                    return true;
                }).submit();
            });

            // Delete 버튼을 클릭하면, passwordForm을 제출하고 deleteForm을 제출합니다.
            $('#del-btn').on('click', function() {
                $('#passwordForm').submit(function(e) {
                    $('#deleteForm #delete-password').val($('#password-input').val());
                    return true;
                }).submit();
            });
        });
    </script>
@endsection
