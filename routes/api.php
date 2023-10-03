<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Blog;
use App\Models\User;
use App\Models\BlogRecommendation;
use App\Models\Comment;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Contracts\Database\Eloquent\Builder;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:api'])->group(function() {
    Route::post('/blog', [BlogController::class, 'store']);
    Route::get('/blog/{id}',[BlogController::class,'show']);
    Route::post('/blog/{id}/recommendations',[BlogController::class,'store_recommendations']);
    Route::get('/blog/{id}/recommendations',[BlogController::class,'show_recommendations']);
    Route::post('/blog/{id}/comments', [CommentController::class, 'store']);
    Route::get('/blog/{id}/comments', [CommentController::class, 'show']);
    Route::get('/user', function() {
        return response(Auth::user());
    });
    Route::post('/logout', [UserAuthController::class,'logout']);
});


Route::get('/login_redirect', function() {
    return response(["logged_in"=>false]);
})->name("login_redirect");

Route::get('/public/blog',function() {
    return response(
        [
            "total"=>Blog::count(),
            "page"=>Blog::with('author')->orderBy('created_at','desc')->simplePaginate(25)
        ]
    );
});

Route::get('/public/blog/{user}/{title_slug}', function($user, $title_slug) {
    $author = User::where('name','=',$user)->first();
    $blog = Blog::where([
        ["user_id", '=', $author->id],
        ["slug",'=',$title_slug]
    ])
    ->with('author')->first();
    return response([
        "blog" => $blog
    ]);
});

Route::get('/public/blog/{user}/{title_slug}/recommendations', function($user, $title_slug) {
    $author = User::where('name','=',$user)->first();
    $blog = Blog::where([
        ["user_id", '=', $author->id],
        ["slug",'=',$title_slug]
    ])->first();

    $rec = BlogRecommendation::where('parent_blog_id','=', $blog->id)
    ->with('blog', function($q) {
        return $q->select('id', 'title', 'slug','user_id')->with('author');
    })->simplePaginate(15);

    return response([
        "recommendations" => $rec
    ]);
});

Route::get('/public/blog/{user}/{title_slug}/comments', function($user, $title_slug) {
    $author = User::where('name','=',$user)->first();
    $blog = Blog::where([
        ["user_id", '=', $author->id],
        ["slug",'=',$title_slug]
    ])->first();

    $comments = Comment::where([['blog_id','=', $blog->id]])->with('inReplyTo', function($q){
        $q->with('author');
    })->with('author')->orderBy('created_at','desc')->simplePaginate(5);

    return response([
        "page" => $comments
    ]);

});

// Route::get('/public/blog/{user}/{title_slug}/comments/{comment_id}/replies', function($user, $title_slug, $comment_id) {
//     $author = User::where('name','=',$user)->first();
//     $blog = Blog::where([
//         ["user_id", '=', $author->id],
//         ["slug",'=',$title_slug]
//     ])->first();

//     $comments = Comment::where([['parent_id','=', $comment_id]])->with('author')->simplePaginate(5);

//     return response([
//         "page" => $comments
//     ]);

// });

Route::post('/register', [UserAuthController::class,'register']);

Route::post('/login', [UserAuthController::class,'login']);






