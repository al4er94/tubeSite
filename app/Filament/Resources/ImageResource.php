<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageResource\Pages;
use App\Http\Enums\Language;
use App\Models\Image;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ImageResource extends Resource
{
    protected static ?string $model = Image::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Images';

    public static function form(Form $form): Form
    {
        $localeOptions = collect(Language::cases())
            ->mapWithKeys(fn($lang) => [$lang->value => $lang->label()])
            ->toArray();

        return $form->schema([
            FileUpload::make('path')
                ->disk('public')
                ->directory('images')
                ->image()
                ->imageEditor()
                ->required()
                ->columnSpanFull(),

            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            TextInput::make('link')
                ->url()
                ->maxLength(500)
                ->nullable(),

            TextInput::make('views')
                ->numeric()
                ->default(0)
                ->readOnly(),

            TextInput::make('likes')
                ->numeric()
                ->default(0)
                ->readOnly(),

            Select::make('categories')
                ->relationship(
                    name: 'categories',
                    titleAttribute: 'slug',
                    modifyQueryUsing: fn($query) => $query->with('translations'),
                )
                ->multiple()
                ->preload()
                ->getOptionLabelFromRecordUsing(fn($record) => $record->translation()?->title ?? $record->slug)
                ->columnSpanFull(),

            Repeater::make('translations')
                ->relationship()
                ->schema([
                    Select::make('locale')
                        ->options($localeOptions)
                        ->required()
                        ->distinct(),
                    TextInput::make('title')
                        ->maxLength(255),
                    Textarea::make('description')
                        ->rows(3),
                    TagsInput::make('keywords')
                        ->separator(','),
                ])
                ->itemLabel(fn(array $state) => $localeOptions[$state['locale'] ?? ''] ?? 'New translation')
                ->collapsible()
                ->defaultItems(0)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('path')
                    ->disk('public')
                    ->square()
                    ->size(60),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->getStateUsing(fn($record) => $record->translation()?->title ?? '—')
                    ->label('Title'),

                TextColumn::make('views')
                    ->sortable(),

                TextColumn::make('likes')
                    ->sortable(),

                TextColumn::make('categories_count')
                    ->counts('categories')
                    ->label('Categories'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categories')
                    ->relationship('categories', 'slug')
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListImages::route('/'),
            'create' => Pages\CreateImage::route('/create'),
            'edit' => Pages\EditImage::route('/{record}/edit'),
        ];
    }
}
