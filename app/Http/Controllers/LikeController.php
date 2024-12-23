<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __invoke(Post $post)
    {
        auth()->user()->likes()->toggle($post);
        return back();
    }
}
