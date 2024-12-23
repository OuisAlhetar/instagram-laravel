<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
       $data = $request->validate([
           'body' => 'required'
           ]
       );

       $post->comments()->create(
           [
               'body' => $request['body'],
               'user_id' => auth()->id()
           ]
       );
       return back();
    }
}
