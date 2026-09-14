<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Http\Enums\Language;
use App\Models\Category;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Categories';

    public static function form(Form $form): Form
    {
        $localeOptions = collect(Language::cases())
            ->mapWithKeys(fn($lang) => [$lang->value => $lang->label()])
            ->toArray();

        return $form->schema([
            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

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
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->getStateUsing(fn($record) => $record->translation()?->title ?? '—')
                    ->label('Title'),

                TextColumn::make('images_count')
                    ->counts('images')
                    ->label('Images')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
