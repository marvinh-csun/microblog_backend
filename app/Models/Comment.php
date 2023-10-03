<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//./vendor/bin/sail artisan make:model Comment --api

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['comment', 'user_id', 'blog_id', 'parent_id'];

    public function author() {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function inReplyTo() {
        return $this->belongsTo(Comment::class,'parent_id', 'id');
    }
}
