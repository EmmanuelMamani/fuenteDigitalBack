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
                ->with([
                    'labels:id,name'
                    ,'files:id,path,post_id'
                ])->latest()->paginate(5);
        return response()->json($posts);
    }
}
