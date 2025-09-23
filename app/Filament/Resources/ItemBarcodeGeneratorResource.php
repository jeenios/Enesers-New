<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemBarcodeGeneratorResource\Pages;
use App\Filament\Resources\ItemBarcodeGeneratorResource\RelationManagers;
use App\Models\Item;
use App\Models\ItemBarcodeGenerator;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use ZipArchive;
use Illuminate\Support\Str;

class ItemBarcodeGeneratorResource extends Resource
{
    protected static ?string $model = ItemBarcodeGenerator::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('Admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Item Barcode Generator Information')
                    ->schema([
                        Grid::make(1)->schema([
                            TextInput::make('code')
                                ->label('Code')
                                ->inlineLabel()
                                ->extraAttributes(['class' => 'max-w-sm'])
                                ->required()
                                ->unique(ignoreRecord: true),

                            Textarea::make('description')
                                ->rows(5)
                                ->cols(20)
                                ->label('Description')
                                ->inlineLabel()
                                ->extraAttributes(['class' => 'max-w-sm']),

                            Select::make('sales_pricelist_id')
                                ->label('Sales Pricelist')
                                ->inlineLabel()
                                ->extraAttributes(['class' => 'max-w-sm'])
                                ->relationship('salesPricelist', 'name')
                                ->preload()
                                ->searchable()
                                ->placeholder('')
                                ->nullable(),

                            TextInput::make('quntity_modifier')
                                ->label('Quantity Modifier')
                                ->numeric()
                                ->inlineLabel()
                                ->extraAttributes(['class' => 'max-w-sm']),

                            TextInput::make('price_format')
                                ->label('Price Format')
                                ->inlineLabel()
                                ->extraAttributes(['class' => 'max-w-sm']),

                            Repeater::make('barcodeMultiples')
                                ->relationship('barcodeMultiples')
                                ->schema([
                                    Select::make('item_id')
                                        ->label('Item')
                                        ->relationship('item', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->placeholder('')
                                        ->nullable(),

                                    TextInput::make('description_barcode')
                                        ->label('Description'),

                                    TextInput::make('quantity_barcode')
                                        ->numeric()
                                        ->label('Quantity'),

                                    TextInput::make('price_barcode')
                                        ->numeric()
                                        ->label('Price'),
                                ])
                                ->columns(4)
                                ->collapsible()
                                ->addActionLabel('Add Barcode Detail'),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('state')
                    ->colors([
                        'success' => 'Active',
                        'danger' => 'Inactive',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sales_pricelist_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('item_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description_barcode')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_barcode')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_barcode')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                // ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                // ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date) => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date) => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])

            ->filtersTriggerAction(
                fn(Tables\Actions\Action $action) => $action
                    ->button() // supaya tampil sebagai tombol
                    ->label('Filter') // label tombol
                    ->icon('heroicon-m-funnel') // icon
                // ->color('primary') // warna tombol (opsional)
            )
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('downloadImages')
                        ->label('Download Images')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->visible(fn($record) => !empty($record->image))
                        ->action(function ($record) {
                            $images = is_array($record->image) ? $record->image : [$record->image];

                            if (empty($images)) {
                                Notification::make()
                                    ->title('Tidak ada file untuk diunduh')
                                    ->danger()
                                    ->send();
                                return;
                            }

                            // Buat nama zip
                            $zipFileName = 'images-' . Str::random(8) . '.zip';
                            $zipPath = storage_path("app/public/{$zipFileName}");

                            $zip = new ZipArchive;
                            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                                foreach ($images as $img) {
                                    $filePath = storage_path('app/public/' . $img);
                                    if (file_exists($filePath)) {
                                        $zip->addFile($filePath, basename($img));
                                    }
                                }
                                $zip->close();
                            }

                            if (file_exists($zipPath)) {
                                return response()->download($zipPath)->deleteFileAfterSend(true);
                            }

                            Notification::make()
                                ->title('Gagal membuat ZIP')
                                ->danger()
                                ->send();
                        }),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItemBarcodeGenerators::route('/'),
            'create' => Pages\CreateItemBarcodeGenerator::route('/create'),
            'edit' => Pages\EditItemBarcodeGenerator::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Items';
    }

    public static function getNavigationSort(): ?int
    {
        return 4;
    }
}
