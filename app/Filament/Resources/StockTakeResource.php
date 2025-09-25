<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockTakeResource\Pages;
use App\Filament\Resources\StockTakeResource\RelationManagers;
use App\Models\StockTake;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use ZipArchive;
use Illuminate\Support\Str;

class StockTakeResource extends Resource
{
    protected static ?string $model = StockTake::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['Admin', 'Warehouse']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Stock Take Information')
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

                                        Select::make('company_id')
                                            ->label('Company')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('company', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('bussiness_unit_id')
                                            ->label('Bussiness Unit Type')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('bussinessUnit', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('project_input')
                                            ->label('Project Input Type')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->options([
                                                'Project' => 'Project',
                                                'Non Project' => 'Non Project',
                                            ])
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('warehouse_id')
                                            ->label('Source Warehouse')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('warehouse', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->placeholder('')
                                            ->nullable(),

                                        Select::make('user_id')
                                            ->label('Document Owner')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('user', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->employee_name}")
                                            ->preload()
                                            ->searchable()
                                            ->placeholder('')
                                            ->nullable(),

                                        TextInput::make('reference')
                                            ->label('Reference')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->nullable(),

                                        Textarea::make('description')
                                            ->rows(5)
                                            ->cols(20)
                                            ->label('Description')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        DateTimePicker::make('transaction_at')
                                            ->label('Transaction At')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->required()
                                            ->seconds(false)
                                            ->default(now()),

                                        DateTimePicker::make('stock_at')
                                            ->label('Stocktake At')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->required()
                                            ->seconds(false)
                                            ->default(now()),

                                        Repeater::make('stockTakeMultiple')
                                            ->relationship('stockTakeMultiple')
                                            ->schema([
                                                Select::make('item_id')
                                                    ->label('Item')
                                                    ->relationship('item', 'name')
                                                    ->preload()
                                                    ->searchable()
                                                    ->placeholder('')
                                                    ->required(),
                                                TextInput::make('quantity')
                                                    ->numeric()
                                                    ->required()
                                                    ->default(1)
                                                    ->required()
                                                    ->label('Quantity'),
                                                Select::make('unit_id')
                                                    ->label('Unit')
                                                    ->relationship('unit', 'name')
                                                    ->preload()
                                                    ->searchable()
                                                    ->placeholder('')
                                                    ->required(),
                                            ])
                                            ->columns(3)
                                            ->collapsible()
                                            ->addActionLabel('Add Line')
                                            ->extraAttributes([
                                                'class' => 'overflow-x-auto w-full'
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tabs\Tab::make('Attachment')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Image')
                                    ->directory('stocktransfers')
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
                    // ->action(
                    //     // Gatau cara ngehandle bugnya
                    //     ViewAction::make('view_from_column')
                    //         ->label(fn($record) => '')
                    // )
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('state')
                    ->colors([
                        'success' => 'Completed',
                        'danger' => 'Pending',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Warehouse Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.employee_name')
                    ->label('Employee Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('transaction_at')
                    ->label('Transaction At')
                    ->dateTime('d/m/Y H:i')
                    ->searchable(),

                Tables\Columns\TextColumn::make('stock_at')
                    ->label('Stocktake At')
                    ->dateTime('d/m/Y H:i')
                    ->searchable(),

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
            'index' => Pages\ListStockTakes::route('/'),
            'create' => Pages\CreateStockTake::route('/create'),
            'edit' => Pages\EditStockTake::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Inventories';
    }

    public static function getNavigationSort(): ?int
    {
        return 4;
    }
}
