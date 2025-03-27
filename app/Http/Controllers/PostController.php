<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index() {
        $posts = Post::latest()->paginate(5);
    
        $posts->getCollection()->transform(function ($post) {
            $post->portada = $post->portada();
            return $post;
        });
    
        return response()->json($posts);
    }
    public function post($id){
        $post = Post::find($id);
        $labels = $post->labels->pluck('name');
        $files = $post->files->pluck('path');

        return response()->json([
            "post" => [
                "id" => $post->id,
                "title" => $post->title,
                "description" => $post->description,
                "visits" => $post->visits,
                "section_id" => $post->section_id,
                "created_at" => $post->created_at,
                "updated_at" => $post->updated_at,
            ],
            "labels" => $labels,
            "files" => $files     
        ]);
    }
    
    
    
    
    public function relatedPosts($id){
        $post = Post::findOrFail($id);
        $labelIds = $post->labels->pluck('id');

        $relatedPosts = Post::whereHas('labels', function ($query) use ($labelIds) {
                $query->whereIn('labels.id', $labelIds);
            })
            ->where('id', '!=', $id)
            ->latest()
            ->paginate(5);

        $relatedPosts->getCollection()->transform(function ($rel) {
            $rel->portada = $rel->portada();
            return $rel; 
        });

        return response()->json($relatedPosts);
    }

    
}
