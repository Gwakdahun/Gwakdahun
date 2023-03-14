@extends('boards.layout')

@section('content')

    <h3>Create</h3>

    <form action="{{ route('boards.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" rows="5" class="form-control" style="resize: none";></textarea>
        </div>

        @if (empty(auth()->user()))
            <div class="form-group">
                <label for="boardPw">Password</label>
                <input type="password" class="form-control" id="boardPw" name="boardPw" required>
            </div>
        @endif

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
