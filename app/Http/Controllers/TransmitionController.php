<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transmition;

class TransmitionController extends Controller
{
    public function online(){
        $facebook = Transmition::where('type', 'facebook')
            ->where('online', true) ->latest()->first();

        $tiktok = Transmition::where('type', 'tik tok') 
            ->where('online', true)->latest()->first();

        return response()->json([
            'facebook' => $facebook,
            'tiktok' => $tiktok
        ]);
    }
}
