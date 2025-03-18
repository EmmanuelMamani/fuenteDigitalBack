<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Label;
use App\Models\Label_post;
class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
    
    protected function afterCreate(): void{

        $post = $this->record;
        $labelNames = $this->data['labels'] ?? [];
        
        $labelIds = [];
        foreach ($labelNames as $name) {
            $label = Label::firstOrCreate(['name' => $name]);
            $labelIds[] = $label->id;
        }
        $post->labels()->sync($labelIds);
    }

}
