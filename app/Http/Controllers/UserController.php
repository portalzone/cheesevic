<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Power;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->power == 9) {
            // User has power of 9, see the posts deleted by the moderator
        
            // Initialize query
            // $users = User::select(
            //     'users.id',
            //     'users.email',
            //     'users.name',
            //     'users.power'
            // );

            // $users = User::all();

            $users = User::select('users.id', 'users.name', 'users.email', 'users.power', 'powers.name as powered')->join('powers', 'powers.post', '=', 'users.power')->get();
        
        
            // Compare the power field to the powers.post field in the powers table
            // $users->leftJoin('powers', 'users.power', '=', 'powers.post');
            
            $powers = Power::all();
        
            return Inertia::render('Power/Index', [
                'users' => $users,
                'powers' => $powers
            ]);
    }
    else {
        // User does not have sufficient permissions, return unauthorized access error
        return response()->json(['error' => 'Unauthorized access'], 403);
    }

    }


    public function update(Request $request, User $user)
    {
        // dd(Request::all());
        // dd($request->file('image'));
        $validated = $request->validate([
            'name' => 'required|min:3|max:150',
            'email' => 'required|email',
            'power' => 'required|numeric',
        ]);
        
        if ($request->file('image')) {
            $validated2 = $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                
            ]); 
        };
        if ($request->file('image')) {

            // Delete the previous image if it exists
            if ($user->image) {
                // Assuming 'public' is the disk where images are stored
                \Storage::disk('public')->delete($user->image);
            }
            // Store the new image
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            // If no new image is uploaded, keep the existing image path
            $imagePath = $user->image;
        }

        // Update post data
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'power' => $validated['power'],
            // 'image' => $imagePath,
        ]);

        // Redirect back to the posts index page after updating
        
        return redirect()->back()->withInput();
        // return redirect('posts');
    }
    


    // public function destroy($id)
    // {
    //     $user = User::findOrFail($id);
    //     $user->delete();

    //     return redirect()->back()->with('success', 'User deleted successfully');
    // }

    public function destroy(User $user)
{
    // Check if the user has the required permissions
    if (auth()->user()->power == 9) {
        // User has power of 9, delete the post
        $user->delete();
    }else {
        // User does not have sufficient permissions, return unauthorized access error
        return response()->json(['error' => 'Unauthorized access'], 403);
    }

    // Redirect back to the previous page with input data
    return redirect()->back()->withInput();
}

    public function makeModerator($id)
    {
        $user = User::findOrFail($id);
        $user->power = 3; // Assuming power column in the users table
        $user->save();


        return redirect()->back()->with('success', 'User made moderator successfully');
    }
}
