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

        $imagePaths = $this->data['images'] ?? [];

        if (!empty($imagePaths)) {
            foreach ($imagePaths as $imagePath) {
                File_post::create([
                    'post_id' => $post->id,
                    'path' => $imagePath,
                ]);
            }
        }
    }

}
