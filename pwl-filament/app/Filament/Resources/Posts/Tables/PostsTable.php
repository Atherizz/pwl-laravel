<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('category.name')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\ColorColumn::make('color'),
                \Filament\Tables\Columns\ImageColumn::make('image')->disk('public'),
                \Filament\Tables\Columns\IconColumn::make('published')->boolean(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
