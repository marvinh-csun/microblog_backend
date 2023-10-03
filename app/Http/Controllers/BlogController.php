<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogRecommendation;
use Illuminate\Http\Request;
//composer require laravel/helpers
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class BlogController extends Controller
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

        $request->validate([
            'title' => ['required', 'string', 'max:512', 'unique:blogs,title,user_id'.$request->user_id],
            'body' => ['required'],
            'description'=>['required', 'string', 'max:1024'],
        ]);

        $blog = Blog::create([
            'title'=> $request->title,
            'slug'=> str_slug($request->title, '-'),
            "description"=>$request->description,
            'body'=> $request->body,
            'user_id'=> Auth::user()->id,
        ]);

        return response($blog->fresh());

    }

    public function store_recommendations(Request $request, $id)
    {
        //
        //make sure user is author of 
        //parent blog for when you really try this.
        $user_id = $request->user_id;

        $parent_id = $request->parent_blog_id;

        $child_id = $request->child_blog_id;

        BlogRecommendation::create([
            "parent_blog_id"=>$parent_id,
            "child_blog_id"=>$child_id
        ]);

        $parent = Blog::findOrFail($parent_id);
        
        return response($parent->recommendations()->get());

    }
    public function show_recommendations(Request $request, $id)
    {
        

        $parent = Blog::findOrFail($id);
        
        return response($parent->recommendations()->get());

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //

        $blog = Blog::findOrFail($id);
        
        return response($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
