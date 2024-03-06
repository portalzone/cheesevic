<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Initialize query
        $query = Post::select(
            'posts.id',
            'posts.name',
            'posts.body',
            'posts.user_id',
            'posts.category_id',
            'posts.image',
            'categories.name as category'
        )->join('categories', 'categories.id', '=', 'posts.category_id');

        // If user's power is 3, filter posts by user_id
        $query->where('posts.hidden', 0);

        if ($user && $user->power == 3) {
            $query->where('posts.user_id', $user->id);
        }

        // Retrieve paginated posts with associated user
        $posts = $query->with('user')->paginate(10);

        $categories = Category::all();

        return Inertia::render('Posts/Index', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    }


    // public function index()
    // {
    //     $posts = Post::select('posts.id', 'posts.name', 'body', 'user_id', 'category_id', 'categories.name as category')
    //     ->join('categories', 'categories.id', '=', 'posts.category_id')
    //     ->with('user')
    //     ->paginate(10);
    //     $categories = Category::all();
    //     return Inertia::render('Posts/Index', ['posts' => $posts, 'categories' =>$categories]);
    // }
    public function latestPosts()
    {
        $posts = Post::where('hidden', '0') // Select posts where 'hidden' column is '0'
                     ->latest()
                     ->take(5)
                     ->get(); // Example: Get the 5 latest posts
        
        return response()->json($posts);
    }
public function trending()
    {
        $posts = Post::where('trending', '1')->latest()->take(10)->get(); // Example: Get the 10 trending posts
        return response()->json($posts);
    }
    public function entertainment()
    {
        $posts = Post::where('category_id', '1')->where('hidden', '0')->latest()->take(5)->get();
        return response()->json($posts);
    }
    public function sport()
    {
        $posts = Post::where('category_id', '2')->where('hidden', '0')->latest()->take(5)->get();
        return response()->json($posts);
    }
    public function religion()
    {
        $posts = Post::where('category_id', '3')->where('hidden', '0')->latest()->take(5)->get();
        return response()->json($posts);
    }
    public function politics()
    {
        $posts = Post::where('category_id', '4')->where('hidden', '0')->latest()->take(5)->get();
        return response()->json($posts);
    }
    public function education()
    {
        $posts = Post::where('category_id', '5')->where('hidden', '0')->latest()->take(5)->get();
        return response()->json($posts);
    }
    public function finance()
    {
        $posts = Post::where('category_id', '6')->where('hidden', '0')->latest()->take(5)->get();
        return response()->json($posts);
    }
    public function business()
    {
        $posts = Post::where('category_id', '10')->where('hidden', '0')->latest()->take(5)->get();
        return response()->json($posts);
    }
    public function world()
    {
        $posts = Post::where('category_id', '11')->where('hidden', '0')->latest()->take(5)->get();
        return response()->json($posts);
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
//     public function store(Request $request)
//     {
//         $request->validate([
//             'name' => 'required|min:10|max:150',
//             'body' => 'required|min:50',
//             'category_id' => 'required|numeric',
//         ]);
//         // $post = new Post($request->input());
//   // Create a new post instance
//         $post = new Post();
//         $post->name = $request->name;
//         $post->body = $request->body;
//         $post->category_id = $request->category_id;

//         // Assign the authenticated user's ID to the user_id field
//         $post->user_id = Auth::id();

//         $post->save();
//         return redirect('posts');
//     }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:10|max:150',
            'body' => 'required|min:50',
            'category_id' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $image_path = '';
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('image', 'public');
        }
        
  // Create a new post instance
        $post = new Post();
        $post->name = $request->name;
        $post->body = $request->body;
        $post->category_id = $request->category_id;
        $post->image = $image_path;

        // Assign the authenticated user's ID to the user_id field
        $post->user_id = Auth::id();

        $post->save();

        sleep(1);
        return redirect('posts');
    }

    /**
     * Display the specified resource.
     */
    public function show($postId)
    {
        $post = Post::with('category')->findOrFail($postId);
    
        // Check if the 'hidden' column value is not equal to '0'
        if ($post->hidden !== 0) {
            // If the 'hidden' column value is not equal to '0', return an error response
            return response()->json(['error' => 'Post not found or access denied'], 404);
        }
    
        return Inertia::render('Posts/View', [
            'post' => $post,
            // 'categories' => $categories
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // // Assuming you have an 'edit' view for editing posts
        // return Inertia::render('Posts/Edit', [
        //     'posts' => $post,
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */

     public function updatePost(Request $request, Post $post)
     {
        // dd(Request::all());
        // dd($request->file('image'));
        $validated = $request->validate([
            'name' => 'required|min:10|max:150',
            'body' => 'required|min:50',
            
        ]);
        if ($request->file('image')) {
            $validated2 = $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                
            ]); 
        };
        if ($request->file('image')) {

            // Delete the previous image if it exists
            if ($post->image) {
                // Assuming 'public' is the disk where images are stored
                \Storage::disk('public')->delete($post->image);
            }
            // Store the new image
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            // If no new image is uploaded, keep the existing image path
            $imagePath = $post->image;
        }

        // Update post data
        $post->update([
            'name' => $validated['name'],
            'body' => $validated['body'],
            'image' => $imagePath,
        ]);

        // Redirect back to the posts index page after updating
        
        return redirect()->back()->withInput();
        // return redirect('posts');

        // $post = Post::with('category')->findOrFail($post);
        // return Inertia::render('Posts/View', [
        //     'post' => $post,
        //     // 'categories' => $categories
        // ]);

     }



    public function update(Request $request, Post $post)
    {
        // dd(Request::all());
        // dd($request->file('image'));
        $validated = $request->validate([
            'name' => 'required|min:10|max:150',
            'body' => 'required|min:50',
            'category_id' => 'required|numeric',
            
        ]);
        if ($request->file('image')) {
            $validated2 = $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                
            ]); 
        };
        if ($request->file('image')) {

            // Delete the previous image if it exists
            if ($post->image) {
                // Assuming 'public' is the disk where images are stored
                \Storage::disk('public')->delete($post->image);
            }
            // Store the new image
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            // If no new image is uploaded, keep the existing image path
            $imagePath = $post->image;
        }

        // Update post data
        $post->update([
            'name' => $validated['name'],
            'body' => $validated['body'],
            'category_id' => $validated['category_id'],
            'image' => $imagePath,
        ]);

        // Redirect back to the posts index page after updating
        
        return redirect()->back()->withInput();
        // return redirect('posts');
    }
    

    /**
     * Remove the specified resource from storage.
     */
 
     public function delete(Post $post)
{
    // Check if the user has the required permissions
    if (auth()->user()->power == 9) {
        // User has power of 9, see the posts deleted by the moderator
        $user = auth()->user();

        // Initialize query
        $query = Post::select(
            'posts.id',
            'posts.name',
            'posts.body',
            'posts.user_id',
            'posts.category_id',
            'posts.image',
            'categories.name as category'
        )->join('categories', 'categories.id', '=', 'posts.category_id');

        // If user's power is 3, filter posts by user_id
        $query->where('posts.hidden', 1);

        // Retrieve paginated posts with associated user
        $posts = $query->with('user')->paginate(10);

        $categories = Category::all();

        return Inertia::render('Posts/Delete', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    } else {
        // User does not have sufficient permissions, return unauthorized access error
        return response()->json(['error' => 'Unauthorized access'], 403);
    }

    // Redirect back to the previous page with input data
    
}

// public function restore(Request $request, Post $post)
// {
//     // Check if the user has the required permissions
//     if (auth()->user()->power == 9) {
        
//         $post->update(['hidden' => 0]);
//         if($post)
//         {
//             dd($post);
//         }
//     } else {
//         // User does not have sufficient permissions, return unauthorized access error
//         return response()->json(['error' => 'Unauthorized access'], 403);
//     }

//     // Redirect back to the previous page with input data
//     return redirect()->back()->withInput();
// }

public function restore(Request $request, Post $post)
{
    // Check if the user has the required permissions
    if (auth()->user()->power == 9) {
        // Update the 'hidden' attribute of the post
        $post->update(['hidden' => 0]);
        
        // Check if the post was updated successfully
        if($post->wasChanged()) {
            // Return a response indicating success
            return Redirect::back()->with(['success' => 'Post restored successfully']);
        } else {
            // Return a response indicating that the post was not updated
            return Redirect::back()->withErrors(['error' => 'Failed to restore post']);
        }
    } else {
        // User does not have sufficient permissions, return unauthorized access error
        return response()->json(['error' => 'Unauthorized access'], 403);
    }
}

public function destroy(Post $post)
{
    // Check if the user has the required permissions
    if (auth()->user()->power == 9) {
        // User has power of 9, delete the post
        $post->delete();
    } elseif (auth()->user()->power == 3) {
        // User has power of 3, change the 'hidden' column to 1
        $post->update(['hidden' => 1]);
    } else {
        // User does not have sufficient permissions, return unauthorized access error
        return response()->json(['error' => 'Unauthorized access'], 403);
    }

    // Redirect back to the previous page with input data
    return redirect()->back()->withInput();
}

}