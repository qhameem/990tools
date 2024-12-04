<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Product;


class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $categories = $data['categories'] ?? [];
        unset($data['categories']);
        return $data + ['categories' => $categories];

        if (empty($data['tag'])) {
            $data['tag'] = null; // Explicitly set to null if empty
        }

        return $data;
    }

    protected function afterCreate($record): void
    {
        $record->categories()->sync(request()->input('categories', []));
    }
}