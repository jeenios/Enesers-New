<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesOrderResource\Pages;
use App\Filament\Resources\SalesOrderResource\RelationManagers;
use App\Models\SalesOrder;
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

class SalesOrderResource extends Resource
{
    protected static ?string $model = SalesOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('Admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Sales Order Information')
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
                                                'No Person' => 'No Person',
                                                'Single Person' => 'Single Person',
                                                'Multiple Person' => 'Multiple Person',
                                            ])
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('sales_input')
                                            ->label('Sales Person Input Type')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->options([
                                                'No Sales Person' => 'No Sales Person',
                                                'Single Sales Person' => 'Single Sales Person',
                                                'Multiple Sales Person' => 'Multiple Sales Person',
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
                                                'Price Include Tax' => 'Price Include Tax',
                                                'Price Exclude Tax' => 'Price Exclude Tax',
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

                                        Select::make('customer_id')
                                            ->label('Customer')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('customer', 'name', fn($query) => $query)
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

                                        Select::make('sales_pricelist_id')
                                            ->label('Sales Price List')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('salesPriceList', 'name', fn($query) => $query)
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
                                                'Rate' => 'Rate',
                                                'Amount' => 'Amount',
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

                                        Select::make('delivery_method_id')
                                            ->label('Delivery Method')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('deliveryMethod', 'name')
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

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

                                        DateTimePicker::make('estimate_at')
                                            ->label('Estimated At')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->seconds(false)
                                            ->default(now())
                                            ->required(),
                                    ]),
                            ]),

                        Tabs\Tab::make('Items')
                            ->schema([
                                Select::make('item_category_id')
                                    ->label('Item')
                                    ->relationship('itemCategory', 'name')
                                    ->preload()
                                    ->inlineLabel()
                                    ->extraAttributes(['class' => 'max-w-sm'])
                                    ->placeholder('')
                                    ->searchable()
                                    ->required()
                                    ->reactive(), // <- penting

                                TextInput::make('quantity')
                                    ->numeric()
                                    ->required()
                                    ->inlineLabel()
                                    ->extraAttributes(['class' => 'max-w-sm'])
                                    ->label('Quantity')
                                    ->reactive(), // <- penting

                                Select::make('unit_id')
                                    ->label('Unit')
                                    ->relationship('unit', 'name')
                                    ->preload()
                                    ->inlineLabel()
                                    ->extraAttributes(['class' => 'max-w-sm'])
                                    ->placeholder('')
                                    ->searchable()
                                    ->required()
                                    ->reactive(), // <- penting

                                TextInput::make('price')
                                    ->numeric()
                                    ->required()
                                    ->inlineLabel()
                                    ->extraAttributes(['class' => 'max-w-sm'])
                                    ->default(0)
                                    ->label('Price')
                                    ->reactive(), // <- penting

                                Toggle::make('toggle_discount')
                                    ->inlineLabel()
                                    ->extraAttributes(['class' => 'max-w-sm'])
                                    ->label('Manual Discount')
                                    ->reactive(),

                                Select::make('discount_id')
                                    ->label('Discount')
                                    ->relationship('discount', 'name')
                                    ->preload()
                                    ->inlineLabel()
                                    ->extraAttributes(['class' => 'max-w-sm'])
                                    ->placeholder('')
                                    ->searchable()
                                    ->nullable()
                                    ->visible(fn($get) => ! $get('toggle_discount'))
                                    ->reactive(), // <- penting

                                Select::make('tax_id')
                                    ->label('Tax')
                                    ->relationship('tax', 'name')
                                    ->preload()
                                    ->inlineLabel()
                                    ->extraAttributes(['class' => 'max-w-sm'])
                                    ->placeholder('')
                                    ->searchable()
                                    ->nullable()
                                    ->reactive(), // <- penting

                                Textarea::make('description_item')
                                    ->inlineLabel()
                                    ->extraAttributes(['class' => 'max-w-sm'])
                                    ->label('Description')
                                    ->reactive(), // <- penting

                                //

                                Placeholder::make('purchase_order_detail')
                                    ->label('Items Detail')
                                    ->content(function ($get) {
                                        $item     = $get('item_category_id');
                                        $qty      = (int) $get('quantity');
                                        $unit     = $get('unit_id');
                                        $price    = (float) $get('price');
                                        $discount = $get('discount_id');
                                        $tax      = $get('tax_id');
                                        $desc     = $get('description_item');

                                        if (! $item || ! $qty || ! $unit || ! $price) {
                                            return new \Illuminate\Support\HtmlString(
                                                '<div class="p-4 rounded-xl border shadow-sm text-center text-gray-500">
                                                Lengkapi semua input untuk melihat detail item.
                                             </div>'
                                            );
                                        }

                                        $itemName   = \App\Models\ItemCategory::find($item)?->name;
                                        $unitName   = \App\Models\Unit::find($unit)?->name;
                                        $discountModel = $discount ? \App\Models\Discount::with('multiples')->find($discount) : null;
                                        $taxModel   = $tax ? \App\Models\Tax::find($tax) : null;

                                        // ============================
                                        // Perhitungan Harga
                                        // ============================

                                        // Total awal
                                        $quantityTotal = $qty; // hanya jumlah unit
                                        $totalPrice    = $qty * $price; // total harga sebelum diskon

                                        // Hitung diskon
                                        $itemDiscountTotal = 0;
                                        if ($discountModel && $discountModel->multiples) {
                                            foreach ($discountModel->multiples as $multi) {
                                                if ($multi->calculation === 'percentage') {
                                                    $itemDiscountTotal += ($multi->value / 100) * $totalPrice;
                                                } elseif ($multi->calculation === 'fixed') {
                                                    $itemDiscountTotal += $multi->value;
                                                }
                                            }
                                        }

                                        // Subtotal setelah diskon
                                        $subtotal = max(0, $totalPrice - $itemDiscountTotal);

                                        // Final Discount tambahan
                                        $finalDiscountTotal = 0;

                                        // Taxable Total
                                        $taxableTotal = max(0, $subtotal - $finalDiscountTotal);

                                        // Pajak
                                        $taxValue = $taxModel?->value ?? 0;
                                        $taxTotal = ($taxValue / 100) * $taxableTotal;

                                        // Total sebelum pembulatan
                                        $beforeRoundingTotal = $taxableTotal + $taxTotal;

                                        // Rounding
                                        $roundingAmount = 0;

                                        // Grand Total
                                        $grandTotal = $beforeRoundingTotal + $roundingAmount;

                                        // ============================
                                        // Tampilan
                                        // ============================
                                        $html = '
                                        <table class="w-full text-sm border rounded-md overflow-hidden">
                                            <thead>
                                                <tr>
                                                    <th class="px-3 py-2 text-left">#</th>
                                                    <th class="px-3 py-2 text-left">Item</th>
                                                    <th class="px-3 py-2 text-right">Quantity</th>
                                                    <th class="px-3 py-2 text-right">Price</th>
                                                    <th class="px-3 py-2 text-left">Discount</th>
                                                    <th class="px-3 py-2 text-left">Tax</th>
                                                    <th class="px-3 py-2 text-left">Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="px-3 py-2">1</td>
                                                    <td class="px-3 py-2">' . e($itemName) . '</td>
                                                    <td class="px-3 py-2 text-right">' . e($qty) . ' ' . e($unitName) . '</td>
                                                    <td class="px-3 py-2 text-right">Rp' . number_format($price, 0, ',', '.') . '</td>
                                                    <td class="px-3 py-2">' . ($discountModel?->name ?? '-') . '</td>
                                                    <td class="px-3 py-2">' . ($taxModel?->name ?? '-') . '</td>
                                                    <td class="px-3 py-2">' . e($desc ?? '-') . '</td>
                                                </tr>
                                            </tbody>
                                        </table>';

                                        $html .= '
                                        <div class="mt-3 max-w-sm float-right">
                                            <div class="p-3 rounded-lg border shadow-sm text-sm">
                                                <div class="flex justify-between"><span>Quantity Total</span><span>' . e($quantityTotal) . ' ' . e($unitName) . '</span></div>
                                                <div class="flex justify-between"><span>Total Price</span><span>Rp' . number_format($totalPrice, 2, ',', '.') . '</span></div>
                                                <div class="flex justify-between"><span>Item Discount Total</span><span>- Rp' . number_format($itemDiscountTotal, 2, ',', '.') . '</span></div>
                                                <div class="flex justify-between"><span>Subtotal</span><span>Rp' . number_format($subtotal, 2, ',', '.') . '</span></div>
                                                <div class="flex justify-between"><span>Final Discount Total</span><span>- Rp' . number_format($finalDiscountTotal, 2, ',', '.') . '</span></div>
                                                <div class="flex justify-between"><span>Taxable Total</span><span>Rp' . number_format($taxableTotal, 2, ',', '.') . '</span></div>
                                                <div class="flex justify-between"><span>Tax (' . $taxValue . '%)</span><span>Rp' . number_format($taxTotal, 2, ',', '.') . '</span></div>
                                                <div class="flex justify-between"><span>Before Rounding Total</span><span>Rp' . number_format($beforeRoundingTotal, 2, ',', '.') . '</span></div>
                                                <div class="flex justify-between"><span>Rounding Amount</span><span>Rp' . number_format($roundingAmount, 2, ',', '.') . '</span></div>
                                                <div class="flex justify-between font-bold border-t pt-1"><span>Grand Total</span><span>Rp' . number_format($grandTotal, 2, ',', '.') . '</span></div>
                                            </div>
                                        </div>';

                                        return new \Illuminate\Support\HtmlString($html);
                                    })
                                    ->reactive()
                                    ->columnSpanFull(),
                            ]),

                        // Placeholder::make('purchase_order_detail')
                        //     ->label('Items Detail')
                        //     ->content(function ($get) {
                        //         $item     = $get('item_category_id');
                        //         $qty      = $get('quantity');
                        //         $unit     = $get('unit_id');
                        //         $price    = $get('price');
                        //         $discount = $get('discount_id');
                        //         $tax      = $get('tax_id');
                        //         $desc     = $get('description_item');

                        //         if (! $item || ! $qty || ! $unit || ! $price) {
                        //             return new \Illuminate\Support\HtmlString(
                        //                 '<div class="p-4 rounded-xl border shadow-sm text-center text-gray-500">
                        //                     Lengkapi semua input untuk melihat detail item.
                        //                 </div>'
                        //             );
                        //         }

                        //         $itemName     = \App\Models\ItemCategory::find($item)?->name;
                        //         $unitName     = \App\Models\Unit::find($unit)?->name;
                        //         $discountName = $discount ? \App\Models\Discount::find($discount)?->name : '-';
                        //         $taxName      = $tax ? \App\Models\Tax::find($tax)?->name : '-';

                        //         $html = '
                        //         <table class="w-full text-sm border rounded-md overflow-hidden">
                        //             <thead>
                        //                 <tr>
                        //                     <th class="px-3 py-2 text-left">#</th>
                        //                     <th class="px-3 py-2 text-left">Item</th>
                        //                     <th class="px-3 py-2 text-right">Quantity</th>
                        //                     <th class="px-3 py-2 text-right">Price</th>
                        //                     <th class="px-3 py-2 text-left">Discount</th>
                        //                     <th class="px-3 py-2 text-left">Tax</th>
                        //                     <th class="px-3 py-2 text-left">Description</th>
                        //                 </tr>
                        //             </thead>
                        //             <tbody>
                        //                 <tr>
                        //                     <td class="px-3 py-2">1</td>
                        //                     <td class="px-3 py-2">' . e($itemName) . '</td>
                        //                     <td class="px-3 py-2 text-right">' . e($qty) . ' ' . e($unitName) . '</td>
                        //                     <td class="px-3 py-2 text-right">' . number_format($price, 0, ',', '.') . '</td>
                        //                     <td class="px-3 py-2">' . e($discountName) . '</td>
                        //                     <td class="px-3 py-2">' . e($taxName) . '</td>
                        //                     <td class="px-3 py-2">' . e($desc ?? '-') . '</td>
                        //                 </tr>
                        //             </tbody>
                        //         </table>';

                        //         return new \Illuminate\Support\HtmlString($html);
                        //     })
                        //     ->reactive()
                        //     ->columnSpanFull(),

                        Tabs\Tab::make('Down Payment')
                            ->schema([
                                Repeater::make('salesOrderDownPayments')
                                    ->relationship('salesOrderDownPayments')
                                    ->columns(3)
                                    ->collapsible()
                                    ->addActionLabel('Add Down Payment Data')
                                    ->schema([
                                        Select::make('input_type')
                                            ->label('Input Type')
                                            ->placeholder('')
                                            ->options([
                                                'Percentage' => 'Percentage',
                                                'Amount' => 'Amount',
                                            ])
                                            ->required(),
                                        TextInput::make('value_type')
                                            ->label('Value Type')
                                            ->numeric()
                                            ->default(0)
                                            ->required(),
                                        TextInput::make('description_type')->label('Description Type'),
                                        Select::make('tax_type_id')
                                            ->label('Tax Type')
                                            ->relationship('taxType', 'name')
                                            ->preload()
                                            ->searchable()
                                            ->placeholder('')
                                            ->nullable(),
                                        TextInput::make('estimated_type')->label('Estimated Type'),
                                    ])
                                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data) {
                                        $data['type'] = 'down_payment';
                                        return $data;
                                    }),

                                Card::make()
                                    ->schema([
                                        DateTimePicker::make('estimate_billing_at')
                                            ->label('Estimated Billing At')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->seconds(false)
                                            ->default(now()),
                                        Textarea::make('description_billing')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->label('Description'),
                                    ])

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

                        Tabs\Tab::make('Attachment')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Image')
                                    ->directory('sales-order')
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

                Tables\Columns\TextColumn::make('user.employee_name')
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
            'index' => Pages\ListSalesOrders::route('/'),
            'create' => Pages\CreateSalesOrder::route('/create'),
            'edit' => Pages\EditSalesOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Sales';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }
}
