<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BoardController extends Controller {

    public function index() {

        $boards = Board::latest()->paginate(10);
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
            ->with('success', 'Board created successfully');
    }


    public function show(Board $board) {

        return view('boards.show', compact('board'));
    }


    public function edit(Board $board) {

        if ($board->user_idx != Auth::id()) {
            return redirect()->route('boards.index')
                ->with('error', '해당 사용자만 수정할 수 있습니다.');
        }

        return view('boards.edit', compact('board'));
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
            ->with('success', 'Board updated successfully');
    }


    public function destroy(Board $board) {

        if ($board->user_idx != Auth::id()) {
            return redirect()->route('boards.index')
            ->with('error', '해당 사용자만 삭제할 수 있습니다.');
        }

        $board->delete();

        return redirect()->route('boards.index')
            ->with('success', '삭제되었습니다.');
    }

    public function checkPassword(Request $request) {
        $boardPw = $request->input('password');
        $board = Board::find($request->input('board_idx'));
        // if (!$board) {
        if (isset($board)) {
            return response()->json(['result' => 'fail', 'message' => '해당 게시물을 찾을 수 없습니다.']);
        };

        if (Hash::check($boardPw, $board->boardPw)) {
            return response()->json(['result' => 'success']);
        } else {
            return response()->json(['result' => 'fail', 'message' => '비밀번호가 일치하지 않습니다.']);
        }
    }

}
