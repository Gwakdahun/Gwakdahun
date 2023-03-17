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

    <a href="{{ route('boards.create') }}">
        <button type="button" class="btn btn-dark" style="float: right;">Create</button>
    </a>


    <table class="table table-striped table-hover">
        <colgroup>
            <col width="15%"/>
            <col width="45%"/>
            <col width="15%"/>
            <col width="15%"/>
        </colgroup>
        <thead>
            <tr>
                <th scope="col">제목</th>
                <th scope="col">내용</th>
                <th scope="col">작성자</th>
                <th scope="col">작성일</th>
                <th scope="col">Action</th>
            </tr>
        </thead>

         <tbody>
        {{-- blade 에서는 아래 방식으로 반복문을 처리합니다. --}}
        {{-- board Controller의 index에서 넘긴 $boards(board 데이터 리스트)를 출력해줍니다. --}}
            @foreach ($boards as $board)
                <tr id="{{ $board->idx }}">
                    {{-- 아래 코드는 좋지 않은 예시 html에서 값을 유추해서 의도하지 않은 페이지로 들어갈 수 있다. --}}
                    <td onclick="window.location.href='{{ route('boards.show', $board->idx) }}'">{{ $board->title }}</td>
                    <td onclick="window.location.href='{{ route('boards.show', $board->idx) }}'">{{ Str::limit($board->content, 50) }}</td>

                    {{-- 해당 코드처럼 <a>태그를 작성하면 좋지만 td 적용 어떻게하는지 모르겠음 --}}
                    {{-- <td><a href="{{ route('boards.show', $board->idx) }}">{{ Str::limit($board->content, 50) }}</a></td> --}}

                    <td onclick="window.location.href='{{ route('boards.show', $board->idx) }}'">
                        @if($board->user)
                            {{ $board->user->name }}
                        @else
                            비회원
                        @endif
                    </td>
                    <td onclick="window.location.href='{{ route('boards.show', $board->idx) }}'">{{ $board->created_at ? $board->created_at->format('Y-m-d') : "" }}</td>
                    <td>
                        @if ($board->user)
                            <a href="{{ route('boards.edit', $board->idx) }}" class="btn btn-sm btn-primary">수정</a>
                        @else
                            <a href="{{ route('boards.edit', $board->idx) }}" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#password-modal" id="edit-btn">수정</a>
                        @endif

                        <form action="{{ route('boards.destroy', $board->idx) }}" method="POST" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            @if ($board->user)
                                <button type="submit" class="btn btn-sm btn-danger">삭제</button>
                            @else
                                <button type="submit" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#password-modal" name="del-btn">삭제</button>
                            @endif
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- 라라벨 기본 지원 페이지네이션 --}}
    {{-- 라라벨의 지원 스타일을 적용해야 함 --}}
    {!! $boards->links() !!}
@endsection

@section('modal')

        <div class="modal" tabindex="-1" role="dialog" id="password-modal">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Enter Password</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" aria-hidden="true">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
                </div>

                <div class="modal-body">
                <!-- 패스워드 입력 부분 -->
                <form id="password-form">
                    <div class="form-group">
                        <label for="password-input">Password:</label>
                        <input type="password" class="form-control" id="password-input">
                    </div>
                </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close-btn">Close</button>
                    <button type="button" class="btn btn-primary" id="confirm-btn">Submit</button>
                </div>
            </div>
            </div>
        </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var actionType;
            var actionUrl;
            var board_idx;

            $('a#edit-btn', 'tr').on('click', function(e) {
                // e.preventDefault() : 해당 이벤트의 기본 동작을 중지하는 역할을 한다.
                e.preventDefault();

                board_idx = $(this).parents('tr').attr('id');

                // 수정 버튼 클릭 시, actionType 변수에 'edit' 값을 저장한다.
                actionType = 'edit';
                actionUrl = $(this).attr('href');
                console.log(actionUrl);
                $('#password-modal').modal('show');
            });

            $('button[name="del-btn"]', 'tr').on('click', function(e) {
                e.preventDefault();

                board_idx = $(this).parents('tr').attr('id');
                console.log(board_idx);

                // 삭제 버튼 클릭 시, actionType 변수에 'delete' 값을 저장한다.
                actionType = 'delete';
                actionUrl = $(this).parent('form').attr('action');

                console.log(actionUrl);

                $('#password-modal').modal('show');

            });

            // 확인 버튼 클릭 시, 서버로 비밀번호 검증 요청을 보내고, 결과에 따라 작업을 수행합니다.
            $('#confirm-btn').on('click', function() {
                var password = $('#password-input').val();

            // $.post() : jQuery 에서 제공하는 Ajax 메소드 중 하나이다. 해당 메소드는 서버에 데이터를 보내고
            // 서버에서 반환하는 응답 데이터를 받아올 수 있다. 얘는 비밀번호 검증 결과를 받아온다.
            $.post('{{ route('boards.checkPassword') }}', {
                _token: '{{ csrf_token() }}',
                password: password,
                board_idx: board_idx,
            }).done(function(response) {
                // console.log(password);
                // console.log(board_idx);
                // console.log(response);
                if (response.result == 'success') {
                    if (actionType == 'edit') {
                        window.location.href = actionUrl;

                    } else if (actionType == 'delete') {
                        if (confirm('삭제하겠습니까?')) {
                            // console.log(actionUrl);
                            // window.location.href = actionUrl;

                            $.ajax ({
                                type: 'post',
                                url: '{{ route('boards.destroy') }}',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-HTTP-Method-Override': 'DELETE',
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                data: {
                                    board_idx: board_idx,
                                },
                                success: function(response) {
                                    console.log(response);
                                    console.log('성공');
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log(jqXHR.responseText);
                                    console.log(textStatus);
                                    console.log(errorThrown);
                                    console.log(actionUrl);
                                }
                            });
                        }
                    }
                } else {
                    alert('비밀번호가 일치하지 않습니다.');
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                console.log(textStatus);
                console.log(errorThrown);
            });
        });

        $('#password-modal').click(function(event) {
            if ($(event.target).hasClass('modal') || $(event.target).hasClass('btn-close') || $(event.target).attr('id') == 'close-btn') {
                $(this).modal('hide');
            }
        });

    });

</script>
@endsection
