<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class label extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function posts(): BelongsToMany{
        return $this->belongsToMany(Post::class, 'label_posts', 'label_id', 'post_id')
            ->withTimestamps();
    }
}
