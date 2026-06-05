<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Group::make([
                    \Filament\Forms\Components\Section::make('Post Details')
                        ->description('Write the title, slug, and content of your post.')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            \Filament\Forms\Components\Group::make([
                                \Filament\Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->minLength(5)
                                    ->rules(['max:100']),
                                \Filament\Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->minLength(3)
                                    ->unique(ignoreRecord: true)
                                    ->validationMessages([
                                        'unique' => 'Slug harus unik dan tidak boleh sama.',
                                    ]),
                                \Filament\Forms\Components\Select::make('category_id')
                                    ->label('Category')
                                    // ->preload()
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->required(),
                                \Filament\Forms\Components\ColorPicker::make('color'),
                            ])->columns(2),
                            \Filament\Forms\Components\MarkdownEditor::make('body')
                                ->columnSpanFull(),
                        ]),
                ])->columnSpan(2),

                \Filament\Forms\Components\Group::make([
                    \Filament\Forms\Components\Section::make('Image Upload')
                        ->description('Upload the featured image for your post.')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            \Filament\Forms\Components\FileUpload::make('image')
                                ->disk('public')
                                ->directory('post')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Gambar utama wajib diupload.',
                                ]),
                        ]),
                    \Filament\Forms\Components\Section::make('Meta')
                        ->description('Additional information about the post.')
                        ->icon('heroicon-o-tag')
                        ->schema([
                            \Filament\Forms\Components\TagsInput::make('tags'),
                            \Filament\Forms\Components\Checkbox::make('published'),
                            \Filament\Forms\Components\DatePicker::make('published_at'),
                        ]),
                ])->columnSpan(1),
            ])
            ->columns(3);
    }
}
