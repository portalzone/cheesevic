<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
         $posts = Post::select('posts.id', 'posts.name', 'posts.image', 'posts.body', 'posts.user_id', 'posts.category_id', 'categories.name as category')
             ->join('categories', 'categories.id', '=', 'posts.category_id')
             ->with('user')
             ->paginate(10);
         
         $categories = Category::all();
         
         // Map through each post to append the full image URL
         $posts->map(function ($post) {
             $post->image = asset('storage/' . $post->image);
             return $post;
         });
     
         return Inertia::render('Posts/Index', [
             'posts' => $posts,
             'categories' => $categories
         ]);
     }
     

    // public function index()
    // {
    //     $posts = Post::select('posts.id', 'posts.name', 'image', 'body', 'user_id', 'category_id', 'categories.name as category')
    //     ->join('categories', 'categories.id', '=', 'posts.category_id')
    //     ->with('user')
    //     ->paginate(10);
    //     $categories = Category::all();
    //     return Inertia::render('Posts/Index', ['posts' => $posts, 'categories' =>$categories]);
    // }

public function latestPosts()
    {
        $posts = Post::latest()->take(5)->get(); // Example: Get the 5 latest posts
        return response()->json($posts);
    }
public function trending()
    {
        $posts = Post::where('trending', '1')->latest()->take(10)->get(); // Example: Get the 10 trending posts
        return response()->json($posts);
    }
    public function entertainment()
    {
        $posts = Post::where('category_id', '1')->latest()->take(5)->get();
        return response()->json($posts);
    }
    public function sport()
    {
        $posts = Post::where('category_id', '2')->latest()->take(5)->get();
        return response()->json($posts);
    }
    public function religion()
    {
        $posts = Post::where('category_id', '3')->latest()->take(5)->get();
        return response()->json($posts);
    }
    public function politics()
    {
        $posts = Post::where('category_id', '4')->latest()->take(5)->get();
        return response()->json($posts);
    }
    public function education()
    {
        $posts = Post::where('category_id', '5')->latest()->take(5)->get();
        return response()->json($posts);
    }
    public function finance()
    {
        $posts = Post::where('category_id', '6')->latest()->take(5)->get();
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

// public function store(Request $request)
// {
//     // Validate the request data
//     $validator = Validator::make($request->all(), [
//         'name' => 'required|string|max:255',
//         'body' => 'required|string',
//         'category_id' => 'required|exists:categories,id',
//         'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
//     ]);

//     // Check if the validation fails
//     if ($validator->fails()) {
//         return redirect()->back()->withErrors($validator)->withInput();
//     }

//     // Store the post data
//     $post = new Post();
//     $post->name = $request->name;
//     $post->body = $request->body;
//     $post->category_id = $request->category_id;

//     // Upload the image
//     $image = $request->file('image');
//     $imageName = time().'.'.$image->getClientOriginalExtension(); // Get the extension of the uploaded file
//     $image->move(public_path('images'), $imageName); // Move the uploaded file to the public/images directory

//     $post->image = $imageName;

//     // Save the post
//     $post->save();

//     return redirect('posts');
// }

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

     

    // public function update(Request $request, Post $post)
    // {
    //     $request->validate([
    //         'name' => 'required|min:10|max:150',
    //         'body' => 'required|min:50',
    //         'category_id' => 'required|numeric',
    //     ]);
    //     $post->update($request->input());
    //     return redirect('posts');
        
    // }
    // public function update(Request $request, Post $post)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|min:10|max:150',
    //         'body' => 'required|min:50',
    //         'category_id' => 'required|numeric',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

    //     ]);

    //     if ($request->file('image')) {
    //         if ($post->image) {
    //             Storage::disk('public')->delete($post->image);
    //         }
    //         $imagePath = $request->file('image')->store('images', 'public');
    //     } else {
    //         $imagePath = $post->image;
    //     }

    //     $post->update([
    //         'name' => $validated['name'],
    //         'body' => $validated['body'],
    //         'category_id' => $validated['category_id'],
    //         'image' => $imagePath,
    //     ]);

    //     return redirect('posts');
    // }    
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'name' => 'required|min:10|max:150',
            'body' => 'required|min:50',
            'category_id' => 'required|numeric',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image' => ['required', 'image', 'max:5500'],
        ]);

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
        
        return redirect('posts');
    }


//     public function update(Request $request, Post $post)
// {
//     $request->validate([
//         'name' => 'required|min:10|max:150',
//         'body' => 'required|min:50',
//         'category_id' => 'required|numeric',
//         'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
//     ]);    

//     // Update post fields
//     $post->name = $request->name;
//     $post->body = $request->body;
//     $post->category_id = $request->category_id;


//     // Check if a new image has been uploaded
    
//     if ($request->hasFile('image')) {
//         // Delete previous image if it exists
//         if ($post->image) {
//             Storage::disk('public')->delete($post->image);
//         }
//         // Store new image
//         $image_path = $request->file('image')->store('image', 'public');
//         $post->image = $image_path;
//     }
    

//     // Save the updated post
//     $post->save();

//     return redirect('posts');
// }

// public function update(Request $request, Post $post)
//     {
        
//         // if ($request->hasFile('image')) {
            
//         $request->validate([
//             'name' => ['required', 'string', 'max:255'],
//             'body' => ['required', 'string'],
//             'category_id' => ['required', 'exists:categories,id'],
//             'image' => ['nullable', 'image', 'max:2048'], // assuming maximum file size is 2MB
//         ]);

//         $post->update([
//             'name' => $request->name,
//             'body' => $request->body,
//             'category_id' => $request->category_id,
//         ]);
//         if ($request->file('image')) {
//             // Handle image upload here
//             $imagePath = $request->file('image')->store('images/posts');
//             // Update post image path in the database
//             $post->image = $imagePath;
//             $post->save();
//         }

//         return redirect('posts');
//     }


// public function update(Request $request, Post $post)
// {
//     $request->validate([
//         'name' => 'required|min:10|max:150',
//         'body' => 'required|min:50',
//         'category_id' => 'required|numeric',
//         'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
//     ]);

//     try {
//         // Update post fields
//         $post->name = $request->name;
//         $post->body = $request->body;
//         $post->category_id = $request->category_id;

//         // Check if a new image has been uploaded
//         if ($request->hasFile('image')) {
//             // Delete previous image if it exists
//             if ($post->image) {
//                 Storage::disk('public')->delete($post->image);
//             }
//             // Store new image
//             $image_path = $request->file('image')->store('image', 'public');
//             $post->image = $image_path;
//         }

//         // Save the updated post
//         $post->save();

//         return redirect('posts')->with('success', 'Post updated successfully.');
//     } catch (\Exception $e) {
//         return redirect()->back()->with('error', 'Error updating post: ' . $e->getMessage())->withInput();
//     }
// }


    // public function update(Request $request, $id)
    // {
    //     // Validate the request data
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'body' => 'required|string',
    //         'category_id' => 'required|exists:categories,id',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);
    
    //     // Check if the validation fails
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }
    
    //     // Find the post by id
    //     $post = Post::findOrFail($id);
    
    //     // Update the post data
    //     $post->name = $request->name;
    //     $post->body = $request->body;
    //     $post->category_id = $request->category_id;
    
    //     // Check if there's a new image uploaded
    //     if ($request->hasFile('image')) {
    //         // Upload the new image
    //         $image = $request->file('image');
    //         $imageName = time().'.'.$image->getClientOriginalExtension();
    //         $image->move(public_path('images'), $imageName);
    
    //         // Delete the old image if it exists
    //         if ($post->image) {
    //             unlink(public_path('images').'/'.$post->image);
    //         }
    
    //         $post->image = $imageName;
    //     }
    
    //     // Save the updated post
    //     $post->save();
    
    //     return redirect('posts');
    // }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('posts');
    }
}
