<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepositories;

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
        $pageSizes = $request->page_size ?? 20 ;
        $post = Post::query()->paginate($pageSizes);

        return PostResource::collection($post);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , PostRepositories $repositories)
    {
        //
        $created = $repositories->create($request->only([
            'title', 'body', 'user_ids'
        ]));

        if (!$created) {
            return response()->json(['error' => 'Post creation failed.'], 500);
        }

        return new PostResource($created);
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
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request ,Post $post ,PostRepositories $repositories)
    {
        //
        $updated = $repositories->update($post ,$request->only([
            'title' , 'body' , 'user_ids'
        ]));

        return new PostResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, PostRepositories $repositories)
    {
        //
        $repositories->forceDelete($post);

        return response()->json([
            'data' => 'success'
        ], 200);
    }
}
