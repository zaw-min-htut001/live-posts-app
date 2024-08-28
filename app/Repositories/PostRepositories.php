<?php

namespace App\Repositories;

use Execption;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepositories;

class PostRepositories extends BaseRepositories
{
    public function create($attributes)
    {
        return DB::transaction(function () use ($attributes){
            $created = Post::create([
                'title' => data_get($attributes , 'title' , 'untitled') ,
                'body' => data_get($attributes , 'body' , 'untitled') ,
            ]);
            // pivot table for
            if($userIds = data_get($attributes , 'user_ids' )){
                $created->users()->sync($userIds);
            }
            return $created;
        });
    }

    public function update($post ,$attributes)
    {
        return DB::transaction(function () use ($attributes , $post){
            $updated = $post->update([
                'title' => data_get($attributes , 'title', $post->title)  ,
                'body' =>  data_get($attributes , 'body', $post->body ) ,
            ]);

            // pivot table for
            if($userIds = data_get($attributes , 'user_ids' )){
                $post->users()->sync($userIds);
            }

            return $post;
        });
    }

    public function forceDelete($post)
    {
        $deleted = $post->forceDelete();

        if(!$deleted){
            throw new Execption('Cannot Deleted ! ');
        }
        return $deleted;
    }
}
