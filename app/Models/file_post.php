<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class file_post extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    
    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function($filePost) {
            if ($filePost->path) {
                try {
                    if (Storage::disk('public')->exists($filePost->path)) {
                        Storage::disk('public')->delete($filePost->path);
                        return;
                    }
                } catch (\Exception $e) {
                    Log::error('Error al eliminar archivo: ' . $e->getMessage());
                }
            }
        });
    }
}