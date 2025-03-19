<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
class commercial extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function($file) {
            if ($file->path) {
                try {
                    if (Storage::disk('public')->exists($file->path)) {
                        Storage::disk('public')->delete($file->path);
                        return;
                    }
                } catch (\Exception $e) {
                    Log::error('Error al eliminar archivo: ' . $e->getMessage());
                }
            }
        });
    }
   
}
