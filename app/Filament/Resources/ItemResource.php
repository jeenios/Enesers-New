<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ItemExporter;
use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use App\Models\Warehouse;
use Dom\Text;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use ZipArchive;
use Illuminate\Support\Str;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('Admin');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Item Information')
                    ->tabs([
                        Tabs\Tab::make('General')
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('code')
                                            ->label('Code')
                                            ->inlineLabel()
                                            ->required()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->unique(ignorable: fn($record) => $record)
                                            ->validationMessages([
                                                'unique' => 'Code sudah digunakan.',
                                                'required' => 'Code wajib diisi.',
                                            ])
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                                if ($get('toggle')) {
                                                    $set('barcode', $state);
                                                }
                                            }),

                                        Toggle::make('toggle')
                                            ->label('Use Code As Barcode')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                                if ($state) {
                                                    if (blank($get('code'))) {
                                                        $set('toggle', false);
                                                        Notification::make()
                                                            ->title('Code is required')
                                                            ->body('Please fill in the Code before enabling barcode identification.')
                                                            ->danger()
                                                            ->send();
                                                    } else {
                                                        $set('barcode', $get('code'));
                                                    }
                                                } else {
                                                    $set('barcode', null);
                                                }
                                            }),

                                        TextInput::make('barcode')
                                            ->label('Barcode')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->disabled(fn($get) => $get('toggle'))
                                            ->dehydrated(true),

                                        TextInput::make('name')
                                            ->label('Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Textarea::make('general_description')
                                            ->rows(5)
                                            ->cols(20)
                                            ->label('General Description')
                                            ->maxLength(255)
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Textarea::make('purchase_description')
                                            ->rows(5)
                                            ->cols(20)
                                            ->label('Purchase Description')
                                            ->maxLength(255)
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Textarea::make('sales_description')
                                            ->rows(5)
                                            ->cols(20)
                                            ->label('Sales Description')
                                            ->maxLength(255)
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Textarea::make('barcode_description')
                                            ->rows(5)
                                            ->cols(20)
                                            ->label('Barcode Description')
                                            ->maxLength(255)
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Select::make('item_type')
                                            ->label('Item Type')
                                            ->options([
                                                'Stockable' => 'Stockable',
                                                'Stockable Consumable' => 'Stockable Consumable',
                                                'Consumable' => 'Consumable',
                                                'Service' => 'Service',
                                                'Receipe' => 'Receipe',
                                            ])
                                            ->inlineLabel()
                                            ->preload()
                                            ->searchable()
                                            ->placeholder('')
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Select::make('unit_id')
                                            ->label('Unit')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('unit', 'name')
                                            ->preload()
                                            ->searchable()
                                            ->placeholder('')
                                            ->nullable(),

                                        TextInput::make('initial_buy')
                                            ->label('Initial Buy Price Amount')
                                            ->numeric()
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        TextInput::make('purchase_tax')
                                            ->label('Purchase Tax')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        TextInput::make('sales_tax')
                                            ->label('Sales Tax')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Select::make('item_category_id')
                                            ->label('Item Category')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('itemCategory', 'name')
                                            ->preload()
                                            ->searchable()
                                            ->placeholder('')
                                            ->nullable(),

                                        TextInput::make('weight')
                                            ->label('Weight')
                                            ->numeric()
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        TextInput::make('volume')
                                            ->label('Volume')
                                            ->numeric()
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Section::make('Dimension')
                                            ->schema([
                                                TextInput::make('length')
                                                    ->label('Length')
                                                    ->inlineLabel()
                                                    ->extraAttributes(['class' => 'max-w-sm']),
                                                TextInput::make('width')
                                                    ->label('Width')
                                                    ->inlineLabel()
                                                    ->extraAttributes(['class' => 'max-w-sm']),
                                                TextInput::make('height')
                                                    ->label('Height')
                                                    ->inlineLabel()
                                                    ->extraAttributes(['class' => 'max-w-sm'])
                                            ]),

                                        Toggle::make('sales_item')
                                            ->label('Sales Item')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Toggle::make('purchase_item')
                                            ->label('Purchase Item')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Section::make('Default Unit For')
                                            ->schema([
                                                Placeholder::make('note')
                                                    ->content(new HtmlString('
                                                        <div class="rounded-lg bg-yellow-100 p-4 text-yellow-800">
                                                            <strong>Note:</strong> This setting will be applied when Unit Setting is set to Allow Alternative Unit.<br>
                                                            Otherwise, system will use base unit.
                                                        </div>
                                                    ')),

                                                TextInput::make('inventory_document')
                                                    ->label('Inventory Document')
                                                    ->inlineLabel()
                                                    ->extraAttributes(['class' => 'max-w-sm']),

                                                TextInput::make('purchase_document')
                                                    ->label('Purchase Document')
                                                    ->inlineLabel()
                                                    ->extraAttributes(['class' => 'max-w-sm']),

                                                TextInput::make('sales_document')
                                                    ->label('Sales Document')
                                                    ->inlineLabel()
                                                    ->extraAttributes(['class' => 'max-w-sm']),
                                            ])
                                            ->columns(1),

                                        Section::make('Minimum & Maximum Quantity')
                                            ->schema([
                                                Placeholder::make('accumulated_quantity_for_all_warehouse'),

                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('accumulated_minimum_quantity')
                                                            ->label('Minimum Quantity')
                                                            ->numeric()
                                                            ->extraAttributes(['class' => 'max-w-sm']),

                                                        TextInput::make('accumulated_max_quantity')
                                                            ->label('Maximum Quantity')
                                                            ->numeric()
                                                            ->extraAttributes(['class' => 'max-w-sm']),
                                                    ]),

                                                Placeholder::make('default_quantity_for_all_warehouse'),

                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('default_minimum_quantity')
                                                            ->label('Minimum Quantity')
                                                            ->numeric()
                                                            ->extraAttributes(['class' => 'max-w-sm']),

                                                        TextInput::make('default_max_quantity')
                                                            ->label('Maximum Quantity')
                                                            ->numeric()
                                                            ->extraAttributes(['class' => 'max-w-sm']),
                                                    ]),
                                            ])
                                            ->columns(1),

                                        Section::make('Overwrite Quantity for Every Warehouse')
                                            ->schema([
                                                Placeholder::make('note')
                                                    ->content(new HtmlString('
                                                        <div class="rounded-lg bg-yellow-100 p-4 text-yellow-800">
                                                            <strong>Note:</strong> This will overwrite the default Minimum / Maximum Quantity.
                                                        </div>
                                                    ')),

                                                Repeater::make('itemWarehouses')
                                                    ->relationship('itemWarehouses')
                                                    ->schema([
                                                        Select::make('warehouse_id')
                                                            ->label('Warehouse')
                                                            ->options(Warehouse::pluck('name', 'id'))
                                                            ->searchable()
                                                            ->placeholder('')
                                                            ->nullable(),

                                                        TextInput::make('minimum_quantity')
                                                            ->numeric()
                                                            ->label('Minimum Quantity'),

                                                        TextInput::make('maximum_quantity')
                                                            ->numeric()
                                                            ->label('Maximum Quantity'),
                                                    ])
                                                    ->columns(3)
                                                    ->collapsible()
                                                    ->addActionLabel('Add Warehouse Quantity'),

                                            ])
                                            ->columns(1),

                                    ]),
                            ]),

                        Tabs\Tab::make('Accounting')
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('sales_account')
                                            ->label('Sales Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('sales_return_account')
                                            ->label('Sales Return Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('sales_discount_account')
                                            ->label('Sales Discount Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('sales_commission_account')
                                            ->label('Sales Commission Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('sales_gross_account')
                                            ->label('Sales Gross Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('purchase_account')
                                            ->label('Purchase Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('purchase_return_account')
                                            ->label('Purchase Return Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('inventory_account')
                                            ->label('Inventory Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('cos_account')
                                            ->label('Cos Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('adjustment_increase_account')
                                            ->label('Adjustment Increase Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('adjustment_decrease_account')
                                            ->label('Adjustment Decrease Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('inventory_usage_account')
                                            ->label('Inventory Usage Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('beginning_inventory_account')
                                            ->label('Beginning Inventory Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('ending_inventory_account')
                                            ->label('Ending Inventory Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('purchase_alocation_account')
                                            ->label('Purchase Alocation Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('work_inprogress_account')
                                            ->label('Work Inprogress Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('byproduct_account')
                                            ->label('Byproduct Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                    ]),
                            ]),

                        Tabs\Tab::make('Attachment')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Image')
                                    ->directory('partners')
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
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('unit.name')
                    ->label('Unit Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('item_type')
                    ->searchable(),

                Tables\Columns\TextColumn::make('item_type')
                    ->searchable(),

                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->stacked()
                    ->size(40),

                Tables\Columns\TextColumn::make('inventory_document')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sales_item')
                    ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No')
                    ->colors([
                        'success' => fn($state) => $state === true,
                        'danger' => fn($state) => $state === false,
                    ])
                    ->searchable(),

                Tables\Columns\TextColumn::make('purchase_item')
                    ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No')
                    ->colors([
                        'success' => fn($state) => $state === true,
                        'danger' => fn($state) => $state === false,
                    ])
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
                    // ExportAction::make()
                    //     ->exporter(ItemExporter::class)
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Items';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }
}
