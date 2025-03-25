<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with([
            'labels:id,name'
            ,'files:id,path,post_id'
        ])
        ->latest()
        ->paginate(5);

        return response()->json($posts);
    }
    
    
    
    public function relatedPosts($id){
        $post = Post::findOrFail($id);

        $labelIds = $post->labels->pluck('id');

        $relatedPosts = Post::whereHas('labels', function ($query) use ($labelIds) {
            $query->whereIn('labels.id', $labelIds);
        })
        ->where('id', '!=', $id)->with([
            'labels:id,name'
            ,'files:id,path,post_id'
        ])
        ->latest()
        ->paginate(5);

        return response()->json($relatedPosts);
    }
}
