@extends('boards.layout')

@section('content')

    <h1>{{ $board->title }}</h1>

    <div class="mb-3">
        <a href="{{ route('boards.index') }}" class="btn btn-dark">Back</a>

        {{-- 글 수정 --}}
        <a href="{{ route('boards.edit', $board->idx) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('boards.destroy', $board->idx) }}" method="POST" style="display: inline-block;">
            {{-- csrf 보호기능을 사용할때 쓰는것 일반적으로 POST방식으로 전송하는 폼에는 사용해야한다. --}}
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
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
    </div>
@endsection
