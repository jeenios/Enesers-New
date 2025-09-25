<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseInvoicePaymentResource\Pages;
use App\Filament\Resources\PurchaseInvoicePaymentResource\RelationManagers;
use App\Models\Company;
use App\Models\Currency;
use App\Models\PurchaseInvoicePayment;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
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
use Illuminate\Support\Facades\Auth;
use ZipArchive;
use Illuminate\Support\Str;

class PurchaseInvoicePaymentResource extends Resource
{
    protected static ?string $model = PurchaseInvoicePayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['Admin', 'Accounting']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Purchase Invoice Payment Information')
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
                                            ->default(fn() => Company::where('name', 'PT Enesers Mitra Berkah')->value('id'))
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

                                        Select::make('project_id')
                                            ->label('Project')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('project', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
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
                                            ->label('User')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('user', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->employee_name}")
                                            ->default(fn() => Auth::user()->id)
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
                                            ->default(fn() => Currency::where('name', 'Indonesian Rupiah')->value('id'))
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('input_type')
                                            ->label('Input Type')
                                            ->inlineLabel()
                                            ->placeholder('')
                                            ->default('Accounting')
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->options([
                                                'Accounting' => 'Accounting',
                                                'Finance' => 'Finance',
                                            ]),

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

                                        Select::make('payment_method_id')
                                            ->label('Payment Method')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('paymentMethod', 'name')
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

                                        DateTimePicker::make('transaction_at')
                                            ->label('Transaction At')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->seconds(false)
                                            ->default(now())
                                            ->required(),

                                        DateTimePicker::make('paid_at')
                                            ->label('Paid At')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->seconds(false)
                                            ->default(now())
                                            ->required(),

                                        Repeater::make('invoiceLines') // ✅ pakai relasi invoiceLines, bukan purchaseInvoicePaymentMultiple
                                            ->relationship('invoiceLines')
                                            ->columns(4)
                                            ->collapsible()
                                            ->addActionLabel('Add Invoice Line')
                                            ->columnSpanFull()
                                            ->schema([
                                                Select::make('purchase_invoice_id')
                                                    ->label('Purchase Invoice')
                                                    ->relationship('purchaseInvoice', 'code')
                                                    ->placeholder('')
                                                    ->searchable()
                                                    ->preload()
                                                    ->required(),
                                                TextInput::make('description_invoice')->label('Description'),
                                                TextInput::make('amount_invoice')->numeric()->label('Payment Amount'),
                                                TextInput::make('discount_invoice')->numeric()->label('Discount Amount'),
                                            ])
                                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data) {
                                                $data['financial_reason'] = null;
                                                $data['description_financial'] = null;
                                                $data['amount_financial'] = null;
                                                return $data;
                                            }),

                                        Repeater::make('financialLines') // ✅ pakai relasi financialLines
                                            ->relationship('financialLines')
                                            ->columns(4)
                                            ->collapsible()
                                            ->addActionLabel('Add Financial Line')
                                            ->columnSpanFull()
                                            ->schema([
                                                TextInput::make('financial_reason')->label('Financial Reason'),
                                                TextInput::make('description_financial')->label('Description'),
                                                TextInput::make('amount_financial')->numeric()->label('Amount'),
                                                Select::make('warehouse_id')
                                                    ->label('Warehouse')
                                                    ->placeholder('')
                                                    ->relationship('warehouse', 'name')
                                                    ->searchable()
                                                    ->preload(),
                                                Select::make('business_unit_id')
                                                    ->label('Business Unit')
                                                    ->placeholder('')
                                                    ->relationship('businessUnit', 'name')
                                                    ->searchable()
                                                    ->preload(),
                                                Select::make('project_id')
                                                    ->label('Project')
                                                    ->placeholder('')
                                                    ->relationship('project', 'name')
                                                    ->searchable()
                                                    ->preload(),
                                            ])
                                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data) {
                                                $data['purchase_invoice_id'] = null;
                                                $data['item_id'] = null;
                                                $data['description_invoice'] = null;
                                                $data['amount_invoice'] = null;
                                                $data['discount_invoice'] = null;
                                                return $data;
                                            }),

                                    ]),
                            ]),

                        Tabs\Tab::make('Address')
                            ->schema([
                                Card::make()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
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

                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Attachment')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Image')
                                    ->directory('purchase-invoice-payment')
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
            'index' => Pages\ListPurchaseInvoicePayments::route('/'),
            'create' => Pages\CreatePurchaseInvoicePayment::route('/create'),
            'edit' => Pages\EditPurchaseInvoicePayment::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Purchases';
    }

    public static function getNavigationSort(): ?int
    {
        return 10;
    }
}
