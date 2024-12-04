<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Group;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make() // Wraps the fields in a vertical layout
                    ->schema([
                        Forms\Components\TextInput::make('url')
                            ->label('URL')
                            ->required()
                            ->url(),

                        Forms\Components\TextInput::make('name')
                            ->label('Product Name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('tag')
                            ->label('Tag')

                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->label('Description')
                            ->maxLength(65535),

                        Select::make('category_id')
                            ->label('Categories')
                            ->multiple()
                            ->relationship('category', 'name')
                            ->searchable()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('Category Name')
                                    ->required()
                                    ->unique('categories', 'name')
                                    ->maxLength(255),
                            ])
                            ->createOptionUsing(function (array $data) {
                                return \App\Models\Category::create($data);
                            })
                            ->required(),
                    ])
                    ->columns(1), // Ensures all fields stack vertically
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name'),
                Tables\Columns\TextColumn::make('url')->label('URL')
                    ->url(fn($record) => $record->url)
                    ->openUrlInNewTab() // Optional: Opens the link in a new tab

                ,
                TextColumn::make('category.name')->label('Category'),
                Tables\Columns\TextColumn::make('tag')->label('Tag')
                    ->size(TextColumn\TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('description')->label('Description')
                    ->wrap() // Ensures the text wraps to the next line
                    ->size(TextColumn\TextColumnSize::ExtraSmall)
                    ->limit(100) // Optional: Limits the text displayed (with "..." for overflow)
                    ->tooltip(fn($record) => $record->description) // Optional: Full description in a tooltip on hover


            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('toggleStatus')
                    ->label(fn($record) => $record->status ? 'Disapprove' : 'Approve') // Dynamic label
                    ->color(fn($record) => $record->status ? 'danger' : 'success') // Dynamic color
                    ->action(function ($record) {
                        $record->status = !$record->status; // Toggle status
                        $record->save();
                    })
                    ->requiresConfirmation() // Optional: Add a confirmation dialog

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}