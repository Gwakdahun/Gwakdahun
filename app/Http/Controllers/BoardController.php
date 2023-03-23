<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BoardController extends Controller {

    public function index() {

        $boards = Board::orderBy('created_at', 'desc')->paginate(10); // Board 모델에서 생성일자를 기준으로 정렬

        $total_count = $boards->total(); // boards에 포함된 전체 게시물 수
        $current_page = $boards->currentPage(); // 현재 페이지 번호

        // 현재 페이지에서 첫 번째로 출력되는 게시글의 번호를 start_id에 저장한다.
        // ex) 전체 게시글이 100개이며 한 페이지에 10개씩 출력한다면
        // 100 - (1 - 1) * 10 = 100 이다.
        $start_id = $total_count - ($current_page - 1) * $boards->perPage(); // 시작 번호

        // $boards에 포함된 게시물들에 대해 클로저 호출 및 정의 $start_id를 참조한다.
        // &:
        $boards->each(function ($board) use (&$start_id) {
            $board->index = $start_id--;
        });

        return view('boards.index', compact('boards'));
    }


    public function create() {

        return view ('boards.create');
    }


    public function store(Request $request) {

        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $user = Auth::user();

        $board = new Board;
        $board->title = $request->title;
        $board->content = $request->content;

        if (!$user) {
            if(empty($request->user_idx)) {
                $board->user_idx = $request->user_idx;
                $board->boardPw = Hash::make($request->boardPw);  // 비밀번호 해쉬화
            }
        } else {
            $board->user_idx = $user->idx;
        }

        $board->save();

        return redirect()->route('boards.index')
            ->with('success', '게시글이 등록되었습니다.');
    }


    public function show(Board $board) {

        return view('boards.show', compact('board'));
    }

    public function edit(Request $request, Board $board) {
        $boardPw = $request->input('password');

        // dd(Auth::id()); : PHP 값 확인하는 방법

        // 유저아이디 체크
        if ($board->user_idx == Auth::id() && !empty($board->user_idx))  {
            return view('boards.edit', compact('board'));
        // 유저 아이디가 맞지 않을 경우
        } elseif ($board->user_idx != Auth::id()) {

            return redirect()->route('boards.index')
                ->with('error', '해당 사용자만 수정할 수 있습니다.');
        } else {

            // 게시물 비밀번호 체크
            if (Hash::check($boardPw, $board->boardPw)) {

                return view('boards.edit', compact('board'));

            } else {

                return redirect()->route('boards.index')
                    ->with('error', '비밀번호가 일치하지 않습니다.');
            }
        }

        // 게시물 번호가 비어있을 경우
        if (isset($board->idx)) {

            return redirect()->route('boards.index')
                ->with('error', '해당 게시물을 찾을 수 없습니다.');
        };
    }


    public function update(Request $request, Board $board) {

        if ($board->user_idx != Auth::id()) {
            return redirect()->route('boards.index')
                ->with('error', '해당 사용자만 수정할 수 있습니다.');
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $board->update($request->all());

        return redirect()->route('boards.index')
            ->with('success', '수정이 완료되었습니다.');
    }


    public function destroy(Request $request, Board $board) {
        $boardPw = $request->input('password');

        if ($board->user_idx == Auth::id() && !empty($board->user_idx))  {

            $board->delete();

            return redirect()->route('boards.index')
                ->with('success', '게시글이 삭제되었습니다.');

        } elseif($board->user_idx != Auth::id()) {

            return redirect()->route('boards.index')
            ->with('error', '해당 사용자만 삭제할 수 있습니다.');

        } else {

            if (Hash::check($boardPw, $board->boardPw)) {

                $board->delete();

                return redirect()->route('boards.index')
                    ->with('success', '게시글이 삭제되었습니다.');

            } else {
                return redirect()->route('boards.index')
                    ->with('error', '비밀번호가 일치하지 않습니다.');
            }
        }

        if (isset($board->idx)) {
            return redirect()->route('boards.index')
            ->with('error', '해당 게시물을 찾을 수 없습니다.');
        };

    }

}
