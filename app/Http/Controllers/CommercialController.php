<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commercial;

class CommercialController extends Controller
{
    public function index(){
        $commercials= Commercial::where('active',true)->get()->pluck('path');
        return response()->json($commercials);
    }
}
