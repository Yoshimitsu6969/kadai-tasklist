<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
     public function index()
    {
        
        $users = User;

       
        return view('users.index', [
            'users' => $users,
        ]);
    }
        public function show($id)
    {
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);

        // ユーザ詳細ビューでそれを表示
        return view('users.show', [
            'user' => $user,
        ]);
    }

 public function edit($id)
    {
                // idの値でメッセージを検索して取得
        $user = User::findOrFail($id);

        // メッセージ編集ビューでそれを表示
        return view('users.edit', [
            'users' => $users,
        ]);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // メッセージを削除
        $user->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
