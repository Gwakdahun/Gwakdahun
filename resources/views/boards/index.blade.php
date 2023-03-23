@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Board;
    use App\Models\User;
@endphp
@extends('boards.layout')

@section('content')

    <h2 class="mt-4 mb-3">게시판</h2>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('message'))
        <div class="alert alert-secondary">
            {{ session('message') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('boards.create') }}">
        <button type="button" class="btn btn-dark" style="float: right;">등록</button>
    </a>


    <table class="table table-striped table-hover">
        <colgroup>
            <col width="10%"/>
            <col width="50%"/>
            <col width="20%"/>
            <col width="20%"/>
        </colgroup>
        <thead>
            <tr style="text-align: center">
                <th scope="col">번호</th>
                <th scope="col">제목</th>
                <th scope="col">작성자</th>
                <th scope="col">작성일</th>
            </tr>
        </thead>

         <tbody>
        {{-- blade 에서는 아래 방식으로 반복문을 처리합니다. --}}
        {{-- board Controller의 index에서 넘긴 $boards(board 데이터 리스트)를 출력해줍니다. --}}
            @foreach ($boards as $board)
                <tr id="{{ $board->idx }}" style="text-align: center">

                    <td>{{ $board->index }}</td>

                    {{-- 아래 코드는 좋지 않은 예시 html에서 값을 유추해서 의도하지 않은 페이지로 들어갈 수 있다. --}}
                    {{-- <td onclick="window.location.href='{{ route('boards.show', $board->idx) }}'">{{ Str::limit($board->content, 50) }}</td> --}}

                    <td style="text-align:left; padding-left:24%"><a href="{{ route('boards.show', $board->idx) }}">
                        @if ($board->created_at != $board->updated_at)
                            {{ Str::limit($board->title, 50) }}</a><span style="color:grey; font-size:60%;">(수정됨)</span></td>
                        @else
                            {{ Str::limit($board->title, 50) }}</a></td>
                        @endif
                    <td>

                        @if($board->user)
                            {{ Str::mask($board->user->name, '*', 1) }}
                        @else
                            비회원
                        @endif
                    </td>

                    <td>{{ $board->created_at ? $board->created_at->format('Y-m-d') : "" }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- 라라벨 기본 지원 페이지네이션 --}}
    {{-- 라라벨의 지원 스타일을 적용해야 함 --}}
    {!! $boards->links() !!}
@endsection


