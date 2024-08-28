<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title' , 'body'
    ];

    protected $casts =[
        'body' => 'array'
    ];

    // protected $appends = [
    //     'title_upper_case'
    // ];
    // title accessor
    public function getTitleUpperCaseAttribute()
    {
        return strtoupper($this->title);
    }

    // mutator
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtolower($value);
    }
    /**
     * Get all of the comments for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    /**
     * The user that belong to the Post
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_user', 'post_id' , 'user_id');
    }
}
