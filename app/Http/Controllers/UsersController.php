<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
     public function index()
    {
        
         $users = User::orderBy('id', 'desc')->paginate(10);

       
        return view('users.index', [
            'users' => $users,
        ]);

    }
        public function show($id)
    {
    public function show($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // ユーザの投稿一覧を作成日時の降順で取得
        $tasks = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);

        // ユーザ詳細ビューでそれらを表示
        return view('users.show', [
            'user' => $user,
            'tasks' => $tasks,
        ]);
    }

}