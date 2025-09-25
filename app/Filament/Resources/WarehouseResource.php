<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarehouseResource\Pages;
use App\Filament\Resources\WarehouseResource\RelationManagers;
use App\Models\Warehouse;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use ZipArchive;
use Illuminate\Support\Str;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['Admin', 'Warehouse', 'Accounting']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Warehouse Information')
                    ->tabs([
                        Tabs\Tab::make('General')
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('code')
                                            ->label('Code')
                                            ->required()
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        // ->extraAttributes(['class' => 'max-w-lg']),

                                        TextInput::make('name')
                                            ->label('Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Select::make('warehouse_category_id')
                                            ->label('Warehouse Category')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('warehouseCategory', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->placeholder('')
                                            ->nullable(),

                                        Toggle::make('warehouse_allow')
                                            ->label('Allow Negative Inventory')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Textarea::make('description')
                                            ->rows(5)
                                            ->cols(20)
                                            ->label('Description')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Section::make('Address')
                                            ->schema([
                                                TextInput::make('address_type')
                                                    ->label('Address Type')
                                                    ->inlineLabel()
                                                    ->maxLength(255)
                                                    ->extraAttributes(['class' => 'max-w-sm']),

                                                TextInput::make('contact_person_name')
                                                    ->label('Contact Person Name')
                                                    ->inlineLabel()
                                                    ->maxLength(255)
                                                    ->extraAttributes(['class' => 'max-w-sm']),

                                                TextInput::make('contact_person_phone')
                                                    ->label('Contact Person Phone')
                                                    ->inlineLabel()
                                                    ->maxLength(255)
                                                    ->extraAttributes(['class' => 'max-w-sm']),

                                                TextInput::make('address')
                                                    ->label('Address')
                                                    ->inlineLabel()
                                                    ->maxLength(255)
                                                    ->extraAttributes(['class' => 'max-w-sm']),

                                                TextInput::make('country_code')
                                                    ->label('Country Code')
                                                    ->inlineLabel()
                                                    ->maxLength(255)
                                                    ->extraAttributes(['class' => 'max-w-sm']),

                                                TextInput::make('postcode')
                                                    ->label('Postcode')
                                                    ->inlineLabel()
                                                    ->maxLength(255)
                                                    ->extraAttributes(['class' => 'max-w-sm']),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Attachment')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Image')
                                    ->directory('warehouses')
                                    ->multiple()
                                    ->maxFiles(5)
                                    ->reorderable(),
                            ]),


                    ])
                    ->columnSpan('full')
                    ->extraAttributes(['class' => 'justify-end']), // CSS tambahan
                // ->extraAttributes(['class' => 'justify-start']),
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
                    ]),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('warehouse_allow')
                    ->label('Allow Negative Inventory')
                    ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No')
                    ->colors([
                        'success' => fn($state) => $state === true,
                        'secondary' => fn($state) => $state === false,
                    ])
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i'),
                // ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i'),
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
            'index' => Pages\ListWarehouses::route('/'),
            'create' => Pages\CreateWarehouse::route('/create'),
            'edit' => Pages\EditWarehouse::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Master';
    }

    public static function getNavigationSort(): ?int
    {
        return 6;
    }
}
