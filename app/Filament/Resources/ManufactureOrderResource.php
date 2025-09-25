<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManufactureOrderResource\Pages;
use App\Filament\Resources\ManufactureOrderResource\RelationManagers;
use App\Models\ManufactureOrder;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use ZipArchive;
use Illuminate\Support\Str;

class ManufactureOrderResource extends Resource
{
    protected static ?string $model = ManufactureOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['Admin', 'Warehouse']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Manufacture Order Information')
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

                                        Select::make('item_category_id')
                                            ->label('Item')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('itemCategory', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        TextInput::make('manufacture_quantity')
                                            ->label('Planned Manufacture Quantity')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->numeric()
                                            ->required(),

                                        Select::make('unit_id')
                                            ->label('Unit')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('unit', 'name')
                                            ->preload()
                                            ->searchable()
                                            ->required()
                                            ->placeholder(''),

                                        Select::make('bill_of_material_id')
                                            ->label('Bill of Material')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('billOfMaterial', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->nullable()
                                            ->placeholder(''),

                                        Select::make('business_unit_id')
                                            ->label('Business Unit')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('bussinessUnit', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->nullable()
                                            ->placeholder(''),

                                        Select::make('project_category_id')
                                            ->label('Projecy')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('projectCategory', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->nullable()
                                            ->placeholder(''),

                                        Select::make('partner_id')
                                            ->label('Customer')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('partner', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->nullable()
                                            ->placeholder(''),

                                        Select::make('user_id')
                                            ->label('Document Owner')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('user', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->nullable()
                                            ->placeholder(''),

                                        Select::make('user_id')
                                            ->label('Suvervisor')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('user', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->nullable()
                                            ->placeholder(''),

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
                                            ->default(now()),

                                        DateTimePicker::make('due_at')
                                            ->label('Due At')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->required()
                                            ->default(now()),
                                    ]),
                            ]),

                        Tabs\Tab::make('Attachment')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Image')
                                    ->directory('manufactures')
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

                Tables\Columns\TextColumn::make('itemCategory.name')
                    ->label('Item Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('billOfMaterial.name')
                    ->label('Bill Of Material Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('manufacture_quantity')
                    ->label('Planned Manufacture Quantity')
                    ->searchable(),

                Tables\Columns\TextColumn::make('unit.name')
                    ->label('Manufacture Unit Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Document Owner Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('unit.name')
                    ->label('Suvervisor Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('businessUnit.name')
                    ->label('Business Unit Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('project.name')
                    ->label('Business Unit Name')
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
            'index' => Pages\ListManufactureOrders::route('/'),
            'create' => Pages\CreateManufactureOrder::route('/create'),
            'edit' => Pages\EditManufactureOrder::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Manufacture';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }
}
