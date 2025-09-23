<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Filament\Resources\PartnerResource\RelationManagers;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\TabsPosition;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use ZipArchive;
use Illuminate\Support\Str;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('Admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Partner Information')
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
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($state, Set $set, callable $get) {
                                                if ($get('tax')) {
                                                    $set('tax_name', $state);
                                                }
                                            }),

                                        Textarea::make('description')
                                            ->rows(5)
                                            ->cols(20)
                                            ->label('Description')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        TextInput::make('email')
                                            ->label('Email')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        TextInput::make('website')
                                            ->label('Website')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Toggle::make('customer')
                                            ->label('Customer')
                                            ->default(false)
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Select::make('customer_payment_term')
                                            ->label('Customer Payment Term')
                                            ->options([
                                                'Immediate Payment' => 'Immediate Payment',
                                                'Net 20 Days' => 'Net 20 Days',
                                                'Net 30 Days' => 'Net 30 Days',
                                                'Net 40 Days' => 'Net 40 Days',
                                                'Net 50 Days' => 'Net 50 Days',
                                                'Net 60 Days' => 'Net 60 Days',
                                            ])
                                            ->default('Standard User')
                                            ->inlineLabel()
                                            ->placeholder('')
                                            ->preload()
                                            ->searchable()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Select::make('user_id')
                                            ->label('Customer Sales Person')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('user', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->employee_name}")
                                            ->preload()
                                            ->searchable()
                                            ->placeholder('')
                                            ->nullable(),

                                        Toggle::make('vendor')
                                            ->label('Vendor')
                                            ->inlineLabel()
                                            ->default(false),

                                        Select::make('vendor_payment_term')
                                            ->label('Vendor Payment Term')
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

                                        Select::make('partner_category_id')
                                            ->label('Partner Category')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('partnerCategory', 'name', fn($query) => $query)
                                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->code} - {$record->name}")
                                            ->preload()
                                            ->searchable()
                                            ->placeholder('')
                                            ->nullable(),

                                        Select::make('sales_pricelist_id')
                                            ->label('Sales Pricelist')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->relationship('salesPricelist', 'name')
                                            ->preload()
                                            ->searchable()
                                            ->placeholder('')
                                            ->nullable(),

                                        // TextInput::make('sales_price_list')
                                        //     ->label('Sales Price List')
                                        //     ->inlineLabel()
                                        //     ->extraAttributes(['class' => 'max-w-sm']),

                                        Toggle::make('tax')
                                            ->label('Use Name As Tax Identification Name')
                                            ->inlineLabel()
                                            ->default(false)
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, Set $set, callable $get) {
                                                if ($state) {
                                                    if (blank($get('name'))) {
                                                        Notification::make()
                                                            ->title('Name is required')
                                                            ->body('Please fill in the Name before enabling tax identification.')
                                                            ->danger()
                                                            ->send();
                                                        $set('tax', false);
                                                        return;
                                                    }

                                                    $set('tax_name', $get('name'));
                                                } else {
                                                    $set('tax_name', null);
                                                }
                                            }),

                                        TextInput::make('tax_name')
                                            ->label('Tax Name')
                                            ->maxLength(255)
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->readOnly(fn(callable $get) => $get('tax')),

                                        TextInput::make('tax_number')
                                            ->label('Tax Number')
                                            ->maxLength(255)
                                            ->numeric()
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Repeater::make('contact')
                                            ->label('Contacts')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->schema([
                                                TextInput::make('number')
                                                    ->label('Contact Number')
                                                    ->numeric()
                                                    ->maxLength(20)
                                                    ->inlineLabel()
                                                    ->extraAttributes(['class' => 'w-full']),
                                            ])
                                            ->minItems(1)
                                            ->collapsible()
                                            ->createItemButtonLabel('Add Contact')
                                            ->dehydrated(), // penting biar data JSON ke DB


                                    ]),
                            ]),

                        Tabs\Tab::make('Accounting')
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('receivable_account')
                                            ->label('Receivable Account')
                                            ->inlineLabel()
                                            ->maxLength(255)
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        TextInput::make('payable_account')
                                            ->label('Payable Number')
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
                // Tables\Columns\TextColumn::make('description')
                //     ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('website')
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('customer')
                    ->label('Customer')
                    ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No')
                    ->colors([
                        'success' => fn($state) => $state === true,
                        'secondary' => fn($state) => $state === false,
                    ])
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('vendor')
                    ->label('Vendor')
                    ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No')
                    ->colors([
                        'success' => fn($state) => $state === true,
                        'secondary' => fn($state) => $state === false,
                    ])
                    ->searchable(),

                Tables\Columns\TextColumn::make('tax_name')
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
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Master';
    }

    public static function getNavigationSort(): ?int
    {
        return 4;
    }
}
