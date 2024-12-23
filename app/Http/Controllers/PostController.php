<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ids = auth()->user()->following()->wherePivot('confirmed', true)->get()->pluck('id');
        $posts = Post::whereIn('user_id', $ids)->latest()->get();
        $suggested_users = auth()->user()->suggested_users();
        return view('posts.index', compact(['posts', 'suggested_users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required',
            'image' => ['required', 'mimes:jpeg,jpg,png,gif']
        ]);

        // Store the image and generate the full URL
        $image = $request->file('image')->store('posts', 'public');
        $data['image'] = asset('storage/' . $image);

        // $path = $request->file('image')->store('posts', 'public'); // Save to storage/app/public/posts
        // $fullUrl = url('storage/' . $path); // Generate full HTTP URL
        // $data['image'] = $fullUrl; // Save the URL in the database

        $data['slug'] = Str::random(10);
        auth()->user()->posts()->create($data);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->validate([
            'description' => 'required',
            'image' => ['nullable', 'mimes:jpeg,jpg,png,gif']
        ]);

        if ($request->has('image')) {
           $image = $request['image']->store('posts', 'public');
           $data['image'] = '/' . $image;
        }

        $post->update($data);

        return redirect('/p/' . $post->slug);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        Storage::delete('public/' . $post->image);
        $post->delete();
        return redirect(url('home'));
    }

    public function explore()
    {
        $posts = Post::whereRelation('owner', 'private_account', '=', 0)
            ->whereNot('user_id', auth()->id())
            ->simplePaginate(12);
        return view('posts.explore', compact('posts'));
   }

}
