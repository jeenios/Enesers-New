<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseDocumentResource\Pages;
use App\Filament\Resources\PurchaseDocumentResource\RelationManagers;
use App\Models\PurchaseDocument;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
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

class PurchaseDocumentResource extends Resource
{
    protected static ?string $model = PurchaseDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('Admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Purchase Shipment')
                    ->tabs([
                        Tabs\Tab::make('Select Purchase Order')
                            ->schema([
                                Select::make('purchase_order_id')
                                    ->label('Purchase Order')
                                    ->reactive()
                                    ->searchable()
                                    ->inlineLabel()
                                    ->placeholder('')
                                    ->preload()
                                    ->options(PurchaseOrder::pluck('code', 'id'))
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $po = PurchaseOrder::with(['company', 'vendor', 'warehouse', 'multiples.item.unit'])
                                                ->find($state);

                                            if ($po) {
                                                $set('company_id', $po->company_id);
                                                $set('vendor_id', $po->vendor_id);
                                                $set('warehouse_id', $po->warehouse_id);

                                                $set('items_from_po', $po->multiples->map(fn($i) => [
                                                    'purchase_order_item_id' => $i->id,
                                                    'item_name'              => $i->item->name,
                                                    'qty'                    => $i->quantity,
                                                    'unit'                   => $i->unit->name ?? '',
                                                    'price'                  => $i->price,
                                                    'total'                  => $i->quantity * $i->price,
                                                ])->toArray());
                                            }
                                        } else {
                                            $set('company_id', null);
                                            $set('vendor_id', null);
                                            $set('warehouse_id', null);
                                            $set('items_from_po', []);
                                        }
                                    })
                                    ->afterStateHydrated(function ($state, callable $set) {
                                        if ($state) {
                                            $po = PurchaseOrder::with(['company', 'vendor', 'warehouse', 'multiples.item.unit'])
                                                ->find($state);

                                            if ($po) {
                                                $set('items_from_po', $po->multiples->map(fn($i) => [
                                                    'purchase_order_item_id' => $i->id,
                                                    'item_name'              => $i->item->name,
                                                    'qty'                    => $i->quantity,
                                                    'unit'                   => $i->unit->name ?? '',
                                                    'price'                  => $i->price,
                                                    'total'                  => $i->quantity * $i->price,
                                                ])->toArray());
                                            }
                                        }
                                    }),


                                Placeholder::make('purchase_order_detail')
                                    ->label('Purchase Order Detail')
                                    ->content(function ($get) {
                                        $poId = $get('purchase_order_id');

                                        if (!$poId) {
                                            return new \Illuminate\Support\HtmlString(
                                                '<div class="p-4 rounded-xl border shadow-sm text-center text-gray-500">No Purchase Order selected.</div>'
                                            );
                                        }

                                        $po = \App\Models\PurchaseOrder::with(['company', 'vendor', 'warehouse'])->find($poId);

                                        if (!$po) {
                                            return new \Illuminate\Support\HtmlString('<div class="text-gray-500">Data not found.</div>');
                                        }

                                        return new \Illuminate\Support\HtmlString('
                                            <div class="p-4 rounded-xl border shadow-sm">
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <div class="font-semibold">Company</div>
                                                        <div>' . e($po->company->name ?? '-') . '</div>
                                                    </div>
                                                    <div>
                                                        <div class="font-semibold">Company Address</div>
                                                        <div>' . e($po->address_company ?? '-') . '</div>
                                                    </div>

                                                    <div>
                                                        <div class="font-semibold">Bussiness Unit Type</div>
                                                        <div>' . e($po->bussinessUnit->name ?? '-') . '</div>
                                                    </div>

                                                    <div>
                                                        <div class="font-semibold">Project Input Type</div>
                                                        <div>' . e($po->project_input ?? '-') . '</div>
                                                    </div>

                                                    <div>
                                                        <div class="font-semibold">Warehouse</div>
                                                        <div>' . e($po->warehouse->code . ' - ' . $po->warehouse->name ?? '-') . '</div>
                                                    </div>
                                                    <div>
                                                        <div class="font-semibold">Vendor</div>
                                                        <div>' . e($po->vendor->code . ' - ' . $po->vendor->name ?? '-') . '</div>
                                                    </div>

                                                    <div>
                                                        <div class="font-semibold">Delivery Method</div>
                                                        <div>' . e($po->deliveryMethod->name ?? '-') . '</div>
                                                    </div>

                                                    <div>
                                                        <div class="font-semibold">Delivery Method</div>
                                                        <div>' . e($po->transaction_at ? \Carbon\Carbon::parse($po->transaction_at)->format('Y-m-d') : '-') . '</div>
                                                    </div>

                                                    <div>
                                                        <div class="font-semibold">Estimated Method</div>
                                                        <div>' . e($po->estimate_at ? \Carbon\Carbon::parse($po->estimate_at)->format('Y-m-d') : '-') . '</div>
                                                    </div>

                                                    <div>
                                                        <div class="font-semibold">Ship From</div>
                                                        <div>' . e($po->address_from ?? '-') . '</div>
                                                    </div>

                                                    <div>
                                                        <div class="font-semibold">Ship To : </div>
                                                        <div>' . e($po->company->name ?? '-') . '</div>
                                                    </div>
                                                </div>
                                            </div>
                                        ');
                                    })
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('Items')
                            ->schema([
                                Hidden::make('items_from_po')
                                    ->default([])
                                    ->dehydrated(true),

                                Placeholder::make('items_table')
                                    ->label('')
                                    ->content(function (callable $get) {
                                        $items = collect($get('items_from_po') ?? []);
                                        $totalQty = $items->pluck('qty')->map(fn($q) => (int) $q)->sum();

                                        $html = '
                                        <table class="w-full text-sm border rounded-md overflow-hidden">
                                            <thead>
                                                <tr>
                                                    <th class="px-3 py-2 text-left">#</th>
                                                    <th class="px-3 py-2 text-left">Item</th>
                                                    <th class="px-3 py-2 text-right">Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>';

                                        foreach ($items as $i => $item) {
                                            $html .= '
                                                <tr>
                                                    <td class="px-3 py-2">' . ($i + 1) . '</td>
                                                    <td class="px-3 py-2">' . ($item['item_name'] ?? '-') . '</td>
                                                    <td class="px-3 py-2 text-right">' . ($item['qty'] ?? 0) . ' ' . ($item['unit'] ?? '') . '</td>
                                                </tr>';
                                        }

                                        $html .= '</tbody></table>';

                                        $html .= '
                                        <div class="flex justify-end mt-2">
                                            <div class="px-4 py-2 rounded-md font-semibold">
                                                Quantity Total: ' . $totalQty . '
                                            </div>
                                        </div>';

                                        return new \Illuminate\Support\HtmlString($html);
                                    }),
                            ]),

                    ])
                    ->columnSpan('full'),
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

                Tables\Columns\TextColumn::make('purchaseOrder.user.employee_name')
                    ->label('Document Owner')
                    ->searchable(),

                Tables\Columns\TextColumn::make('deliveryMethod.name')
                    ->label('Delivery Method')
                    ->searchable(),

                Tables\Columns\TextColumn::make('purchaseOrder.transaction_at')
                    ->label('Transaction At')
                    ->dateTime('d/m/Y H:i')
                    ->searchable(),

                Tables\Columns\TextColumn::make('purchaseOrder.estimate_at')
                    ->label('Delivery At')
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
            'index' => Pages\ListPurchaseDocuments::route('/'),
            'create' => Pages\CreatePurchaseDocument::route('/create'),
            'edit' => Pages\EditPurchaseDocument::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Purchases';
    }

    public static function getNavigationSort(): ?int
    {
        return 7;
    }
}
