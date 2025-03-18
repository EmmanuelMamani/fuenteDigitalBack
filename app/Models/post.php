<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; 
class post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function labels(): BelongsToMany{
        return $this->belongsToMany(Label::class, 'label_posts', 'post_id', 'label_id');
    }
}
