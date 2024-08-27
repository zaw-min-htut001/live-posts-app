<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $post = Post::query()->get();
        return response()->json($post, 200 );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $created = Post::create([
            'title' => $request->title ,
            'body' => $request->body ,
        ]);

        return response()->json($created  , 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Post $post)
    {
        //
        $post->update([
            'title' => $request->title ?? $post->title ,
            'body' => $request->body ?? $post->body ,
        ]);

        if(!$post){
            return response()->json([
                'error' => 'Post cannot update'
            ], 400);
        }
        return response()->json([
            'data' => $post
        ], 200 );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $post->forceDelete();

        return response()->json([
            'data' => 'success'
        ], 200);
    }
}
