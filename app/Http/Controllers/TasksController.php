<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            // （後のChapterで他ユーザの投稿も取得するように変更しますが、現時点ではこのユーザの投稿のみ取得します）
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(25);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
  
        return view("tasks.index",[
            "tasks" => $tasks,
            ]);
    }  
    
    else
    {
            // Welcomeビューでそれらを表示
            return view('welcome', $data);
    }
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $task = new Task;
        
        return view("tasks.create",[
            "task" => $task,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "status" =>"required|max:10",
            "content"=>'required|max:10',
            
            ]);

       
        $request->user()->tasks()->create([
         'status' => $request -> status,
        'content' => $request->content,
        ]);
              

        
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // idの値でメッセージを検索して取得
        $task = \App\Task::findOrFail($id);
       // メッセージ詳細ビューでそれを表示
         if (\Auth::id() === $task->user_id) {
            // 自分のタスクであればタスク編集ページを表示する。
            return view("tasks.show",['task' => $task]);
        }
        // 他人のタスク(それ以外)であればトップページへとリダイレクトさせる
        return redirect('/');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // idの値で投稿を検索して取得
        $task = \App\Task::findOrFail($id);
        
        
         if (\Auth::id() === $task->user_id) {
             
        return view('tasks.edit', ['task' => $task]);
        
         }
         return redirect('/');

    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
            $request->validate([
            "status" => 'required|max:10',     
            'content' => 'required|max:10',
        ]);
        
        
        
            
        $task = Task::findOrFail($id);
        // メッセージを更新
        $task ->status = $request->status;
        $task->content = $request->content;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // idの値で投稿を検索して取得
        $task = \App\Task::findOrFail($id);
        
        // メッセージを削除
         if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
     
        return redirect('/');
    }
}
