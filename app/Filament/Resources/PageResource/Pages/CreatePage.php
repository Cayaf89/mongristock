<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Models\Page;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array {
        return [
            parent::getCreateFormAction()
                ->submit(null)
                ->action('create'),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array {
        if (!empty($data['is_homepage'])) {
            $oldHomepage = Page::where('is_homepage', true)->first();
            $oldHomepage->is_homepage = false;
            $oldHomepage->save();
        }
        $data['slug'] = Str::slug($data['name']);
        return $data;
    }
}
