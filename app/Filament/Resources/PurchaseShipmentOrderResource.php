<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseShipmentOrderResource\Pages;
use App\Filament\Resources\PurchaseShipmentOrderResource\RelationManagers;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseShipmentOrder;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
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

class PurchaseShipmentOrderResource extends Resource
{
    protected static ?string $model = PurchaseShipmentOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('Admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Purchase Shipment Order Information')
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
                                                'Non Project' => 'Non Project',
                                                'Single Project' => 'Single Project',
                                                'Multiple Project' => 'Multiple Project',
                                            ])
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('item_type')
                                            ->label('Item Type')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->options([
                                                'Item' => 'Item',
                                                'Vendor' => 'Vendor',
                                            ])
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('tax_calculation')
                                            ->label('Tax Calculation Type')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->options([
                                                'Item' => 'Item',
                                                'Vendor' => 'Vendor',
                                            ])
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('warehouse_id')
                                            ->label('Warehouse')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('warehouse', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('vendor_id')
                                            ->label('Vendor')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('vendor', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('user_id')
                                            ->label('Document Owner')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('user', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->employee_name}")
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('currency_id')
                                            ->label('Currency')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('currency', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('exchange_rate_id')
                                            ->label('Exchange Rate')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('exchangeRate', 'rate')
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('discount_calculation')
                                            ->label('Discount Calculation Type')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->options([
                                                'Item' => 'Item',
                                                'Vendor' => 'Vendor',
                                            ])
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        TextInput::make('rounding_amount')
                                            ->numeric()
                                            ->required()
                                            ->default(0)
                                            ->required()
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->label('Rounding Amount'),

                                        TextInput::make('reference')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->label('Reference'),

                                        Textarea::make('description')
                                            ->label('Description')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->rows(5)
                                            ->cols(20),

                                        Select::make('payment_term')
                                            ->label('Payment Term')
                                            ->options([
                                                'Immediate Payment' => 'Immediate Payment',
                                                'Net 20 Days' => 'Net 20 Days',
                                                'Net 30 Days' => 'Net 30 Days',
                                                'Net 40 Days' => 'Net 40 Days',
                                                'Net 50 Days' => 'Net 50 Days',
                                                'Net 60 Days' => 'Net 60 Days',
                                            ])
                                            ->inlineLabel()
                                            ->placeholder('')
                                            ->preload()
                                            ->searchable()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        DateTimePicker::make('transaction_at')
                                            ->label('Transaction At')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->seconds(false)
                                            ->default(now())
                                            ->required(),

                                        DateTimePicker::make('delivery_at')
                                            ->label('Delivery At')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->seconds(false)
                                            ->default(now())
                                            ->required(),

                                        Repeater::make('purchaseShipmentOrderMultiple')
                                            ->relationship('purchaseShipmentOrderMultiple')
                                            ->columns(4)
                                            ->collapsible()
                                            ->addActionLabel('Add Line')
                                            ->columnSpanFull()
                                            ->schema([
                                                Select::make('item_id')
                                                    ->label('Item')
                                                    ->relationship('item', 'name')
                                                    ->preload()
                                                    ->searchable()
                                                    ->placeholder('')
                                                    ->required(),

                                                TextInput::make('description')->label('Description'),

                                                TextInput::make('quantity')
                                                    ->numeric()
                                                    ->required()
                                                    ->label('Quantity'),

                                                Select::make('unit_id')
                                                    ->label('Unit')
                                                    ->relationship('unit', 'name')
                                                    ->preload()
                                                    ->searchable()
                                                    ->placeholder('')
                                                    ->required(),

                                                TextInput::make('price')
                                                    ->numeric()
                                                    ->required()
                                                    ->default(0)
                                                    ->label('Price'),

                                                Toggle::make('toggle_discount')
                                                    ->inlineLabel()
                                                    ->label('Manual Discount'),

                                                Select::make('discount_id')
                                                    ->label('Discount')
                                                    ->relationship('discount', 'name')
                                                    ->preload()
                                                    ->searchable()
                                                    ->placeholder('')
                                                    ->nullable(),

                                                Select::make('tax_id')
                                                    ->label('Tax')
                                                    ->relationship('tax', 'name')
                                                    ->preload()
                                                    ->searchable()
                                                    ->placeholder('')
                                                    ->nullable(),
                                            ]),

                                    ]),
                            ]),

                        Tabs\Tab::make('Address')
                            ->schema([
                                Card::make()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                // Company Address
                                                Fieldset::make('Ship To')
                                                    ->schema([
                                                        TextInput::make('contact_person_name_shipment')
                                                            ->label('Contact Person Name'),
                                                        TextInput::make('contact_person_phone_shipment')
                                                            ->label('Contact Person Phone'),
                                                        Textarea::make('address_shipment')
                                                            ->label('Address'),
                                                        Select::make('currency_shipment_id')
                                                            ->label('Country Code')
                                                            ->nullable()
                                                            ->placeholder('')
                                                            ->relationship('currencyShipment', 'name')
                                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                                            ->preload()
                                                            ->searchable(),
                                                        TextInput::make('postcode_shipment')
                                                            ->label('Postcode')
                                                            ->default('15314'),
                                                    ])
                                                    ->columns(1)
                                                    ->columnSpan(1)
                                                    ->extraAttributes(['class' => 'p-4 border rounded-lg']),

                                                // Shipment Address
                                                Fieldset::make('Bill To')
                                                    ->schema([
                                                        TextInput::make('template_bill')
                                                            ->label('Template'),
                                                        Textarea::make('address_bill')
                                                            ->label('Address'),
                                                        Select::make('currency_bill_id')
                                                            ->label('Country Code')
                                                            ->nullable()
                                                            ->placeholder('')
                                                            ->relationship('currencyBill', 'name')
                                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                                            ->preload()
                                                            ->searchable(),
                                                        TextInput::make('postcode_bill')
                                                            ->label('Postcode'),
                                                    ])
                                                    ->columns(1)
                                                    ->columnSpan(1)
                                                    ->extraAttributes(['class' => 'p-4 border rounded-lg']),

                                                // Shipment Address
                                                Fieldset::make('Company Address')
                                                    ->schema([
                                                        TextInput::make('template_company')
                                                            ->label('Template'),
                                                        Textarea::make('address_company')
                                                            ->label('Address'),
                                                        Select::make('currency_company_id')
                                                            ->label('Country Code')
                                                            ->nullable()
                                                            ->placeholder('')
                                                            ->relationship('currencyCompany', 'name')
                                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                                            ->preload()
                                                            ->searchable(),
                                                        TextInput::make('postcode_company')
                                                            ->label('Postcode'),
                                                    ])
                                                    ->columns(1)
                                                    ->columnSpan(1)
                                                    ->extraAttributes(['class' => 'p-4 border rounded-lg']),

                                                // Company Address
                                                Fieldset::make('Ship From')
                                                    ->schema([
                                                        TextInput::make('template_from')
                                                            ->label('Template'),
                                                        TextInput::make('contact_person_name_from')
                                                            ->label('Contact Person Name'),
                                                        TextInput::make('contact_person_phone_from')
                                                            ->label('Contact Person Phone'),
                                                        Textarea::make('address_from')
                                                            ->label('Address'),
                                                        Select::make('currency_from_id')
                                                            ->label('Country Code')
                                                            ->nullable()
                                                            ->placeholder('')
                                                            ->relationship('currencyFrom', 'name')
                                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                                            ->preload()
                                                            ->searchable(),
                                                        TextInput::make('postcode_from')
                                                            ->label('Postcode')
                                                            ->default('15314'),
                                                    ])
                                                    ->columns(1)
                                                    ->columnSpan(1)
                                                    ->extraAttributes(['class' => 'p-4 border rounded-lg']),
                                            ]),
                                    ]),
                            ]),


                        Tabs\Tab::make('Fullfillment')
                            ->schema([
                                Select::make('purchase_requisition_id')
                                    ->label('Purchase Requisition')
                                    ->reactive()
                                    ->preload()
                                    ->searchable()
                                    ->options(PurchaseRequisition::pluck('code', 'id'))
                                    ->afterStateHydrated(function ($state, callable $set) {
                                        if ($state) {
                                            $prItems = PurchaseRequisition::with('multiples.item.unit')
                                                ->find($state)?->multiples ?? [];

                                            // Isi placeholder waktu form edit dibuka
                                            $set('items_from_pr', $prItems->map(fn($i) => [
                                                'item_name'   => $i->item->name,
                                                'description' => $i->description,
                                                'quantity'    => $i->quantity,
                                                'unit'        => $i->unit->name,
                                            ])->toArray());
                                        }
                                    })
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $prItems = PurchaseRequisition::with('multiples.item.unit')
                                                ->find($state)?->multiples ?? [];

                                            // Inject ke repeater saat user pilih PR baru
                                            $set('purchaseShipmentOrderMultiple', $prItems->map(fn($i) => [
                                                'item_id'     => $i->item_id,
                                                'description' => $i->description,
                                                'quantity'    => $i->quantity,
                                                'unit_id'     => $i->unit_id,
                                                'price'       => 0,
                                                'toggle_discount' => false,
                                                'discount_id' => null,
                                                'tax_id'      => null,
                                            ])->toArray());

                                            // Isi placeholder preview
                                            $set('items_from_pr', $prItems->map(fn($i) => [
                                                'item_name'   => $i->item->name,
                                                'description' => $i->description,
                                                'quantity'    => $i->quantity,
                                                'unit'        => $i->unit->name,
                                            ])->toArray());
                                        } else {
                                            $set('purchaseShipmentOrderMultiple', []);
                                            $set('items_from_pr', []);
                                        }
                                    }),

                                Placeholder::make('items_from_pr')
                                    ->label('Items from Purchase Requisition')
                                    ->content(function ($get) {
                                        $items = $get('items_from_pr') ?? [];
                                        if (!count($items)) {
                                            return new \Illuminate\Support\HtmlString(
                                                '<div class="p-4 rounded-xl border shadow-sm text-center text-gray-500">No items selected.</div>'
                                            );
                                        }

                                        $html = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">';
                                        foreach ($items as $row) {
                                            $html .= '
                                                <div class="p-4 rounded-xl border shadow-sm">
                                                    <div class="mb-3">
                                                        <div class="font-semibold text-gray-800 text-sm mb-1">' . e($row['item_name']) . '</div>
                                                        <div class="text-gray-500 text-xs mb-2">' . e($row['description']) . '</div>
                                                        <div class="flex justify-between text-sm">
                                                            <span class="text-gray-600">Qty: <span class="font-medium">' . e($row['quantity']) . '</span></span>
                                                            <span class="text-gray-600">Unit: <span class="font-medium">' . e($row['unit']) . '</span></span>
                                                        </div>
                                                    </div>
                                                </div>';
                                        }
                                        $html .= '</div>';
                                        return new \Illuminate\Support\HtmlString($html);
                                    })
                                    ->columnSpanFull(),
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

                Tables\Columns\TextColumn::make('vendor.name')
                    ->label('Vendor Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Warehouse Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.employee_name')
                    ->label('Document Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('transaction_at')
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
            'index' => Pages\ListPurchaseShipmentOrders::route('/'),
            'create' => Pages\CreatePurchaseShipmentOrder::route('/create'),
            'edit' => Pages\EditPurchaseShipmentOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Purchases';
    }

    public static function getNavigationSort(): ?int
    {
        return 6;
    }
}
