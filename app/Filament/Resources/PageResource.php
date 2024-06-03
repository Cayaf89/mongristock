<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages\CreatePage;
use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\PageResource\Pages\ListPages;
use App\Models\Page;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
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
use FilamentTiptapEditor\Enums\TiptapOutput;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\AuthorField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\ContentBlocksField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\HeroImageField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\IntroField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\OverviewDescriptionField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\OverviewImageField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\OverviewTitleField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Form\Fields\TitleField;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Table\Actions\PublishAction;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Table\Columns\PublishedColumn;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Table\Columns\TitleColumn;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Table\Filters\PublishedFilter;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-text';

    public static function form(Form $form): Form {
        return $form
            ->schema([
                Grid::make()
                    ->columns()
                    ->schema([
                        Section::make('Publication')
                            ->collapsible()
                            ->compact()
                            ->columns()
                            ->columnSpanFull()
                            ->schema([
                                Grid::make()
                                    ->columns(1)
                                    ->columnSpan(1)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nom de la page')
                                            ->required(),
                                        TextInput::make('slug')
                                            ->label('URL de la page')
                                            ->required(fn(?Model $record): bool => $record && $record->id > 0)
                                            ->hidden(fn(?Model $record): bool => is_null($record))
                                            ->prefix(url('/') . '/')
                                            ->suffixAction(
                                                Action::make('see-page')
                                                    ->icon('gmdi-open-in-new-o')
                                                    ->extraAttributes(['target' => '_blank'])
                                                    ->url(fn($state) => url('/') . '/' . $state)
                                            ),
                                        Checkbox::make('is_homepage')
                                            ->label("Page d'accueil ?"),
                                    ]),
                                Grid::make()
                                    ->columns(1)
                                    ->columnSpan(1)
                                    ->schema([
                                        AuthorField::create()
                                            ->label('Auteur'),
                                        DatePicker::make('publishing_begins_at')
                                            ->label('Date de publication')
                                            ->native(false)
                                            ->seconds(false)
                                            ->displayFormat('d/m/Y'),
                                    ]),
                            ]),
                    ]),
                Grid::make()
                    ->columns()
                    ->schema([
                        Section::make('Bloc de couverture')
                            ->collapsible()
                            ->compact()
                            ->columnSpan(1)
                            ->schema([
                                TitleField::create(true)
                                    ->label('Titre'),
                                IntroField::create()
                                    ->label('Introduction'),
                                HeroImageField::create()
                                    ->columnSpan(1)
                                    ->label('Image de fond'),
                            ]),
                        Section::make("Vignette")
                            ->collapsible()
                            ->compact()
                            ->columnSpan(1)
                            ->schema([
                                OverviewTitleField::create()
                                    ->label('Titre'),
                                OverviewDescriptionField::create()
                                    ->label('Description courte'),
                                OverviewImageField::create()
                                    ->label('Image'),
                            ]),
                    ]),
                TiptapEditor::make('content')
                    ->profile('default')
                    ->output(TiptapOutput::Json)
                    ->columnSpanFull()
                    ->maxContentWidth('5xl'),
            ]);
    }

    public static function table(Table $table): Table {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->orderBy('is_homepage', 'desc')
                ->orderBy('title'))
            ->columns([
                Tables\Columns\IconColumn::make('is_homepage')
                    ->label(false)
                    ->trueIcon('heroicon-s-home')
                    ->falseIcon(false)
                    ->boolean(),
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
