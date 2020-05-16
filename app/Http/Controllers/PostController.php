<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Cadastrar artigo')){
            throw new UnauthorizedException('403', 'You do not have permission to access this function');
        }

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Cadastrar artigo')){
            throw new UnauthorizedException('403', 'You do not have permission to access this function');
        }

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;

        if(!empty($request->published)) {
            $post->published = $request->published;
        }

        $post->save();

        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (!Auth::user()->hasPermissionTo('Editar artigo')){
            throw new UnauthorizedException('403', 'You do not have permission to access this function');
        }

        return view('posts.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if (!Auth::user()->hasPermissionTo('Editar artigo')){
            throw new UnauthorizedException('403', 'You do not have permission to access this function');
        }

        $post->title = $request->title;
        $post->content = $request->content;

        if(isset($request->published)) {
            $post->published = $request->published;
        }

        $post->save();
        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (!Auth::user()->hasPermissionTo('Remover artigo')){
            throw new UnauthorizedException('403', 'You do not have permission to access this function');
        }

        $post->delete();
        return redirect()->route('post.index');
    }
}
