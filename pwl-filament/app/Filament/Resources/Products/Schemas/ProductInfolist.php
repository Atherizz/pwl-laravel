<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Infolists\Components\Tabs::make('Product Details')
                    ->tabs([
                        \Filament\Infolists\Components\Tabs\Tab::make('Product Info')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->color('primary'),
                                \Filament\Infolists\Components\TextEntry::make('sku')
                                    ->label('SKU')
                                    ->badge()
                                    ->color('success'),
                                \Filament\Infolists\Components\TextEntry::make('description')
                                    ->label('Description')
                                    ->markdown()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        \Filament\Infolists\Components\Tabs\Tab::make('Pricing & Stock')
                            ->icon('heroicon-o-currency-dollar')
                            ->badge(fn ($record): string => (string) $record->stock)
                            ->badgeColor('info')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('price')
                                    ->label('Price')
                                    ->formatStateUsing(fn (int $state): string => 'Rp ' . number_format($state, 0, ',', '.'))
                                    ->icon('heroicon-o-currency-dollar'),
                                \Filament\Infolists\Components\TextEntry::make('stock')
                                    ->label('Stock')
                                    ->icon('heroicon-o-circle-stack'),
                            ])
                            ->columns(2),

                        \Filament\Infolists\Components\Tabs\Tab::make('Media & Status')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                \Filament\Infolists\Components\ImageEntry::make('image')
                                    ->label('Product Image')
                                    ->disk('public'),
                                \Filament\Infolists\Components\Group::make([
                                    \Filament\Infolists\Components\IconEntry::make('is_active')
                                        ->label('Active')
                                        ->boolean(),
                                    \Filament\Infolists\Components\IconEntry::make('is_featured')
                                        ->label('Featured')
                                        ->boolean(),
                                    \Filament\Infolists\Components\TextEntry::make('created_at')
                                        ->label('Created At')
                                        ->date('d M Y')
                                        ->color('info'),
                                ]),
                            ])
                            ->columns(2),
                    ])
                    ->vertical()
                    ->columnSpanFull(),
            ]);
    }
}
