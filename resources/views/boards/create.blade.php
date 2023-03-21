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
            <textarea name="content" id="content" rows="5" cols="20" wrap="hard" class="form-control" style="resize: none";></textarea>
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

    <script>
        $(document).ready(function() {
            //enter => <br>
            var text = document.getElementById("content").value;
            text = text.replace(/(?:\r\n|\r|\n)/g, '<br>');

            //<br> => enter
            var text = document.getElementById("content").value;
            text = text.replaceAll("<br>", "\r\n");
        });
    </script>
@endsection
