<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(){
        $sections = Section::mainSections()->with('subsections')->get();
    
        return response()->json($sections);
    }
    

    public function Posts($id){
        $posts = Post::where('section_id', $id)
                ->latest()->paginate(5);
                $posts->getCollection()->transform(function ($post) {
                    $post->portada = $post->portada();
                    return $post;
                });       
        return response()->json($posts);
    }
}
