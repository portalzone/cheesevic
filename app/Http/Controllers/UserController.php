<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Power;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->power == 9) {
            // User has power of 9, see the posts deleted by the moderator
            $user = auth()->user();
    
        $users = User::all(); 
        // $users = User::select(
        //     'users.id',
        //     'users.name',
        //     'users.email',
        //     'powers.name as power'
        // )->join('powers', 'powers.post', '=', 'users.power');

        $powers = Power::all();

        return inertia('Power/Index', [
            'users' => $users,
            'powers' => $powers
        ]);
    }
    else {
        // User does not have sufficient permissions, return unauthorized access error
        return response()->json(['error' => 'Unauthorized access'], 403);
    }

    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function makeModerator($id)
    {
        $user = User::findOrFail($id);
        $user->power = 3; // Assuming power column in the users table
        $user->save();


        return redirect()->back()->with('success', 'User made moderator successfully');
    }
}
