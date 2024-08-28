<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;

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
    public function store(Request $request)
    {
        //
        $created = DB::transaction(function () use ($request){
            $created = Post::create([
                'title' => $request->title ,
                'body' => $request->body ,
            ]);
            // pivot table for
            $created->users()->sync($request->user_ids);
            return $created;
        });

        return new PostResource($post);
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
        return new PostResource($post);
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
