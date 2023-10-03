<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Blog;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $blog_id = $request->blog_id;
        $comment = $request->comment;
        $user_id = $request->user_id;
        $parent_id = $request->parent_id;

        $created = Comment::create([
            "blog_id"=>$blog_id,
            "user_id"=>auth()->user()->id,
            "comment"=>$comment,
            "parent_id"=>$parent_id
        ]);

        return response($created->fresh());
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //

        $blog = Blog::findOrFail($id);

        $blog_comments = $blog->comments()->get();

        return response($blog_comments);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
