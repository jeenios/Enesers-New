<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillOfMaterialResource\Pages;
use App\Filament\Resources\BillOfMaterialResource\RelationManagers;
use App\Models\BillOfMaterial;
use Filament\Forms;
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

class BillOfMaterialResource extends Resource
{
    protected static ?string $model = BillOfMaterial::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['Admin', 'Warehouse', 'Accounting']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Bill Of Material Information')
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

                                        TextInput::make('name')
                                            ->label('Name')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->required(),

                                        Textarea::make('description')
                                            ->rows(5)
                                            ->cols(20)
                                            ->label('Description')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Select::make('item_category_id')
                                            ->label('Manufacture Item')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('itemCategory', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder('')
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, callable $set) {
                                                if ($state) {
                                                    $items = \App\Models\Item::where('item_category_id', $state)->get();

                                                    $set('billOfMaterialMultiple', $items->map(function ($item) {
                                                        return [
                                                            'item_id'    => $item->id,
                                                            'description' => $item->description ?? '',
                                                            'quantity'   => 1, // default quantity 1
                                                            'unit_id'    => $item->unit_id ?? null,
                                                        ];
                                                    })->toArray());
                                                } else {
                                                    // reset repeater kalau tidak ada kategori
                                                    $set('billOfMaterialMultiple', []);
                                                }
                                            }),


                                        TextInput::make('manufacture_quantity')
                                            ->label('Manufacture Quantity')
                                            ->inlineLabel()
                                            ->default(0)
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->numeric()
                                            ->required(),

                                        Select::make('unit_id')
                                            ->label('Manufacture Unit')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('unit', 'name')
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Toggle::make('toggle_default')
                                            ->label('Default')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Repeater::make('billOfMaterialMultiple')
                                            ->relationship('billOfMaterialMultiple')
                                            ->schema([
                                                Select::make('item_id')
                                                    ->label('Item')
                                                    ->relationship('item', 'name')
                                                    ->preload()
                                                    ->searchable()
                                                    ->placeholder('')
                                                    ->required(),
                                                TextInput::make('description')
                                                    ->label('Description'),
                                                TextInput::make('quantity')
                                                    ->numeric()
                                                    ->required()
                                                    ->default(0)
                                                    ->label('Quantity'),
                                                Select::make('unit_id')
                                                    ->label('Unit')
                                                    ->relationship('unit', 'name')
                                                    ->preload()
                                                    ->searchable()
                                                    ->placeholder('')
                                                    ->required(),
                                            ])
                                            ->columns(4)
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

                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('itemCategory.name')
                    ->label('Manufacture Item')
                    ->searchable(),

                Tables\Columns\TextColumn::make('manufacture_quantity')
                    ->label('Manufacture Quantity')
                    ->searchable(),

                Tables\Columns\TextColumn::make('unit.name')
                    ->label('Manufacture Unit Name')
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('toggle_default')
                    ->label('Default')
                    ->formatStateUsing(fn($state) => $state ? 'true' : 'false')
                    ->colors([
                        'success' => fn($state) => $state == 1,
                        'danger' => fn($state) => $state == 0,
                    ])
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
            'index' => Pages\ListBillOfMaterials::route('/'),
            'create' => Pages\CreateBillOfMaterial::route('/create'),
            'edit' => Pages\EditBillOfMaterial::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Manufacture';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }
}
