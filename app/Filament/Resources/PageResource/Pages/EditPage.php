<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Models\Page;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getActions(): array
    {
        return [
            parent::getSaveFormAction()
                ->submit(null)
                ->action('save'),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array {
        if (!empty($data['is_homepage'])) {
            $oldHomepage = Page::where('is_homepage', true)->first();
            if (!empty($oldHomepage)) {
                $oldHomepage->is_homepage = false;
                $oldHomepage->save();
            }
        }
        return $data;
    }
}
