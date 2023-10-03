<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//./vendor/bin/sail artisan make:model Blog --api

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug','description','body','user_id'];
    
    public function recommendations()
    {
        return $this->
        belongsToMany(Blog::class,'blog_recommendations','parent_blog_id','child_blog_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function author() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
