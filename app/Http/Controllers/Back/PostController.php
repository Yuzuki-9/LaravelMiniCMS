<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * 一覧画面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest('id')->paginate(20);  //latest()で最新のものから降順で並び替え
        return view('back,posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     * 新規登録画面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 新規登録画面は入力フォームを登録するだけなので、コントローラーの処理はない
        return view('back.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     * 登録処理
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)  //PostRequestをインポートして引数にすることでバリデーションエラーが有った場合入力画面に戻る処理を自動的にしてくれる
    {
        $post = Post::create($request->all());  //createメソッド

        if ($post) {  //createに成功すると、trueが返ってくるので成功したら編集画面にリダイレクト、ソレ以外は登録画面にリダイレクト
            return redirect()
            ->route('back.posts.edit', $post)
            ->withSuccess('データを登録しました。');
        } else {
            return redirect()
            ->route('back.posts.create')
            ->withError('データの登録に失敗しました。');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
