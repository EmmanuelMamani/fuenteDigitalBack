<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Label;
use App\Models\Label_post;
use App\Models\File_post;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array{
        $data['labels'] = $this->record->labels->pluck('name')->toArray(); 
        $data['images'] = $this->record->files->pluck('path')->toArray();  
        return $data;
    }

    protected function afterSave(): void{
        $post = $this->record;
        $labelNames = $this->data['labels'] ?? [];
        
        $labelIds = [];
        foreach ($labelNames as $name) {
            $label = Label::firstOrCreate(['name' => strtolower($name)]);
            $labelIds[] = $label->id;
        }
        $post->labels()->sync($labelIds);

        $imagePaths = $this->data['images'] ?? []; 

        if (!empty($imagePaths)) {
            foreach ($imagePaths as $imagePath) {
                if (!File_Post::where('post_id', $post->id)->where('path', $imagePath)->exists()) {
                    File_Post::create([
                        'post_id' => $post->id,
                        'path' => $imagePath,
                    ]);
                }
            }
        }
    }
    
}
