<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::select('posts.id', 'posts.name', 'body', 'user_id', 'category_id', 'categories.name as category')
        ->join('categories', 'categories.id', '=', 'posts.category_id')
        ->with('user')
        ->paginate(10);
        $categories = Category::all();
        return Inertia::render('Posts/Index', ['posts' => $posts, 'categories' =>$categories]);
    }

    public function latest()
{
    $latest = Post::select('posts.id', 'posts.name', 'body', 'user_id', 'category_id', 'categories.name as category')
    ->join('categories', 'categories.id', '=', 'posts.category_id')
    ->with('user')
    ->paginate(10);
    $categories = Category::all();
    return Inertia::render('Latest', ['latest' => $latest, 'categories' =>$categories]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:10|max:150',
            'body' => 'required|min:50',
            'category_id' => 'required|numeric',
        ]);
        // $post = new Post($request->input());
  // Create a new post instance
        $post = new Post();
        $post->name = $request->name;
        $post->body = $request->body;
        $post->category_id = $request->category_id;

        // Assign the authenticated user's ID to the user_id field
        $post->user_id = Auth::id();

        $post->save();
        return redirect('posts');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name' => 'required|min:10|max:150',
            'body' => 'required|min:50',
            'category_id' => 'required|numeric',
        ]);
        $post->update($request->input());
        return redirect('posts');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('posts');
    }
}
