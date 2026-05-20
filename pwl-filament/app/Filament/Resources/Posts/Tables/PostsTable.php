<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('tags')
                    ->label('Tags')
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\ColorColumn::make('color')
                    ->toggleable(),
                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->toggleable(),
                \Filament\Tables\Columns\IconColumn::make('published')
                    ->boolean()
                    ->label('Published')
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                \Filament\Tables\Filters\Filter::make('created_at')
                    ->label('Creation Date')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('created_at')
                            ->label('Select Date'),
                    ])
                    ->query(function ($query, $data) {
                        return $query->when(
                            $data['created_at'],
                            fn ($query, $date) => $query->whereDate('created_at', $date)
                        );
                    }),
                \Filament\Tables\Filters\SelectFilter::make('category_id')
                    ->label('Select Category')
                    ->relationship('category', 'name')
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ReplicateAction::make(),
                Action::make('status')
                    ->label('Status Change')
                    ->icon('heroicon-o-check-circle')
                    ->schema([
                        Checkbox::make('published')
                            ->default(fn ($record): bool => $record->published),
                    ])
                    ->action(function ($record, $data) {
                        $record->update(['published' => $data['published']]);
                    })
                    ->requiresConfirmation(false),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
