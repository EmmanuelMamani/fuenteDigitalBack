<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function subsections(){
        return $this->hasMany(Section::class, 'parent_id');
    }

    public function parent(){
        return $this->belongsTo(Section::class, 'parent_id');
    }

    public function scopeMainSections($query){
        return $query->whereNull('parent_id');
    }

    public function scopeUsableSections($query){
        return $query->whereDoesntHave('subsections');
    }

}
