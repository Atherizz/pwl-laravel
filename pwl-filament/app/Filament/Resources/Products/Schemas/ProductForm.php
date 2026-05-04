<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Wizard::make([
                    \Filament\Forms\Components\Wizard\Step::make('Product Info')
                        ->description('Isi informasi dasar produk')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            \Filament\Forms\Components\Group::make([
                                \Filament\Forms\Components\TextInput::make('name')->required(),
                                \Filament\Forms\Components\TextInput::make('sku')->required()->unique(ignoreRecord: true),
                            ])->columns(2),
                            \Filament\Forms\Components\MarkdownEditor::make('description')
                                ->columnSpanFull(),
                        ]),
                    \Filament\Forms\Components\Wizard\Step::make('Pricing & Stock')
                        ->description('Isi harga dan jumlah stok')
                        ->icon('heroicon-o-currency-dollar')
                        ->schema([
                            \Filament\Forms\Components\TextInput::make('price')
                                ->numeric()
                                ->required()
                                ->minValue(1),
                            \Filament\Forms\Components\TextInput::make('stock')
                                ->numeric()
                                ->required()
                                ->minValue(0),
                        ])->columns(2),
                    \Filament\Forms\Components\Wizard\Step::make('Media & Status')
                        ->description('Upload gambar dan atur status')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            \Filament\Forms\Components\FileUpload::make('image')
                                ->disk('public')
                                ->directory('products')
                                ->required(),
                            \Filament\Forms\Components\Checkbox::make('is_active')
                                ->default(true),
                            \Filament\Forms\Components\Checkbox::make('is_featured')
                                ->default(false),
                        ]),
                ])
                ->submitAction(
                    \Filament\Forms\Components\Actions\Action::make('save')
                        ->label('Save Product')
                        ->color('primary')
                        ->submit('save')
                )
                ->columnSpanFull(),
            ]);
    }
}
