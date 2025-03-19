@php
    $record = $getRecord();
    $files = $record?->files ?? collect();
@endphp

@if($files->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($files as $file)
            <div class="border rounded-lg overflow-hidden shadow p-3">
                <div class="aspect-square overflow-hidden">
                    <img src="{{ asset('storage/' . $file->path) }}" 
                         alt="{{ basename($file->path) }}" 
                         class="w-full h-full object-cover rounded">
                </div>
            </div>
        @endforeach
    </div>
@endif
