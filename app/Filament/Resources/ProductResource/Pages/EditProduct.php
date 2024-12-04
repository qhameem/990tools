<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $categories = $data['categories'] ?? [];
        unset($data['categories']);
        return $data + ['categories' => $categories];

        // $this->record->categories()->sync($categories);

        if (empty($data['tag'])) {
            $data['tag'] = null; // Explicitly set to null if empty
        }

        return $data;
    }

    protected function afterSave($record): void
    {
        $record->categories()->sync(request()->input('categories', []));
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}