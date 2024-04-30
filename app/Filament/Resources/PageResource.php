<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages\CreatePage;
use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\PageResource\Pages\ListPages;
use App\Models\Page;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\AuthorField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\ContentBlocksField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\HeroImageField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\IntroField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\OverviewDescriptionField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\OverviewImageField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\OverviewTitleField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\PublishingBeginsAtField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\SlugField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\TitleField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Table\Actions\PublishAction;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Table\Columns\PublishedColumn;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Table\Columns\TitleColumn;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Table\Filters\PublishedFilter;
use Statikbe\FilamentFlexibleContentBlocks\FilamentFlexibleBlocksConfig;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-text';

    public static function form(Form $form): Form {
        return $form
            ->schema([
                Tabs::make()
                    ->columnSpan(2)
                    ->tabs([
                        Tab::make('Général')
                            ->schema([
                                Grid::make()
                                    ->columns()
                                    ->schema([
                                        Section::make('Informations')
                                            ->columnSpan(1)
                                            ->schema([
                                                TitleField::create(true)
                                                    ->label('Titre'),
                                                TextInput::make('slug')
                                                    ->label('Slug')
                                                    ->required(fn(?Model $record): bool => $record && $record->id > 0)
                                                    ->hidden(fn(?Model $record): bool => is_null($record))
                                                    ->prefix(url('/') . '/'),
                                            ]),
                                        Section::make('Publication')
                                            ->columnSpan(1)
                                            ->schema([
                                                AuthorField::create()
                                                    ->label('Auteur'),
                                                DatePicker::make('publishing_begins_at')
                                                    ->label('Date de publication')
                                                    ->seconds(false)
                                                    ->displayFormat('d/m/Y'),
                                            ]),
                                    ]),
                                Section::make('Image de couverture')
                                    ->schema([
                                        HeroImageField::create()
                                            ->label('Image de couverture'),
                                    ]),
                                IntroField::create(),
                            ]),
                        Tab::make('Contenu')
                            ->schema([
                                ContentBlocksField::create(),
                            ]),
                        Tab::make('Vignette')
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        OverviewTitleField::create()
                                            ->label('Titre de la vignette'),
                                        OverviewDescriptionField::create()
                                            ->label('Description de la vignette'),
                                        OverviewImageField::create()
                                            ->label('Image de la vignette'),
                                    ]),
                            ]),
                    ]),

            ]);
    }

    public static function table(Table $table): Table {
        return $table
            ->columns([
                TitleColumn::create()
                    ->label('Titre'),
                Tables\Columns\TextColumn::make('slug'),
                PublishedColumn::create()
                    ->label('Status'),
            ])
            ->filters([
                PublishedFilter::create(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                PublishAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index'  => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit'   => EditPage::route('/{record}/edit'),
        ];
    }
}
