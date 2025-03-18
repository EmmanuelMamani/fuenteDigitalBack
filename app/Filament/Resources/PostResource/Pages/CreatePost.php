<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Label;
use App\Models\Label_post;
use App\Models\File_post;
class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
    
    protected function afterCreate(): void
    {
        $post = $this->record;
        $labelNames = $this->data['labels'] ?? [];
        
        $labelIds = [];
        foreach ($labelNames as $name) {
            $label = Label::firstOrCreate(['name' => $name]);
            $labelIds[] = $label->id;
        }
        $post->labels()->sync($labelIds);
        
        $images = $this->data['images'] ?? []; 
        
        if (!empty($images)) {
            foreach ($images as $imagePath) {
                file_post::create([
                    'post_id' => $post->id,
                    'path' => $imagePath,
                    'type' => 'img',
                ]);
            }
        }
    }

}
