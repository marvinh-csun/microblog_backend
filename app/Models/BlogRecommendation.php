<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogRecommendation extends Model
{
    use HasFactory;

    protected $fillable = ['parent_blog_id', 'child_blog_id'];

    public function blog()
    {
        return $this->
        hasOne(Blog::class,'id','child_blog_id');
    }
}
