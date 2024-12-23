<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(User $user)
    {
        return view('users.profile', compact('user'));
    }

    public function edit(User $user)
    {
        //        if (auth()->id() !== $user->id) {
        //            abort(403, 'You are not authorized to see this page');
        //        }

        //        abort_if(auth()->id() !== $user->id, 403, 'You are not authorized to see this page');
        //        abort_if(auth()->user()->cannot('edit-update-profile', $user), 403);
        //        $this->authorize('edit-update-profile', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, UpdateUserProfileRequest $request)
    {
        /* The line `         = ->safe()->collect();` in the `update` method of the
        `UserController` is creating a new collection of input data from the request object after applying a safety filter. */
        $data = $request->safe()->collect();

        if ($data['password'] == '') {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        // if ($data->has('image')) {
        //     $path = $request->file('image')->store('users', 'public');
        //     $data['image'] = '/' . $path;
        // }
        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('users', 'public'); // Save to storage/app/public/users
            $fullUrl = url('storage/' . $path); // Generate full HTTP URL
            $data['image'] = $fullUrl; // Save the URL in the database
        }

        $data['private_account'] = $request->has('private_account');

        $user->update($data->toArray());

        session()->flash('success', __('You profile has been updated successfully!', [], $data['lang']));
        return redirect()->route('user_profile', $user);
    }

    public function follow(User $user)
    {
        auth()->user()->follow($user);
        return back();
    }

    public function unfollow(User $user)
    {
        auth()->user()->unfollow($user);
        return back();
    }
}
