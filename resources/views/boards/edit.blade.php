@extends('boards.layout')

@section('content')

    <h3>Edit</h3>

    <form action="{{ route('boards.update', $board->idx) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value ="{{ $board->title }}">
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" rows="5" class="form-control" style="resize: none";>{{ $board->content }}</textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

    </form>
    <a href="{{ route('boards.index') }}">
        <button type="button" class="btn btn-dark" style="float: right;">Back</button>
    </a>
@endsection
