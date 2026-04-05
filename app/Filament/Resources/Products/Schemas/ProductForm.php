<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Support\Str;

class ProductForm // product feature
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Grid::make(2)->schema([

                // ✅ CATEGORY (FIX LỖI CHÍNH)
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable(),

                // ✅ NAME + AUTO SLUG
                TextInput::make('name')
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn ($state, $set) =>
                        $set('slug', Str::slug($state))
                    ),

                TextInput::make('slug')
                    ->required(),

                // ✅ PRICE
                TextInput::make('price')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                // ✅ STOCK
                TextInput::make('stock_quantity')
                    ->numeric()
                    ->integer()
                    ->required(),

                // ⭐ FIELD SÁNG TẠO
                TextInput::make('discount_percent')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(0),

                // ✅ STATUS
                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'out_of_stock' => 'Out of Stock',
                    ])
                    ->required(),

                // ✅ IMAGE
                FileUpload::make('image_path')
                    ->image()
                    ->directory('products')
                    ->maxFiles(1),

                // ✅ DESCRIPTION
                RichEditor::make('description')
                    ->columnSpanFull(),

            ])

        ]);
    }
}