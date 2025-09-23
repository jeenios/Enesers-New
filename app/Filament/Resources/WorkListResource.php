<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkListResource\Pages;
use App\Filament\Resources\WorkListResource\RelationManagers;
use App\Models\WorkList;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use ZipArchive;
use Illuminate\Support\Str;

class WorkListResource extends Resource
{
    protected static ?string $model = WorkList::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('Admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Work Report Information')
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

                                        Select::make('state')
                                            ->label('Status')
                                            ->options([
                                                'Pending' => 'Pending',
                                                'Completed' => 'Completed',
                                            ])
                                            ->placeholder('')
                                            ->inlineLabel()
                                            ->preload()
                                            ->searchable()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        // // 👇 Employee field (user_id)
                                        // Select::make('user_id')
                                        //     ->label('Employee')
                                        //     ->relationship('user', 'employee_name')
                                        //     ->searchable()
                                        //     ->preload()
                                        //     ->required()
                                        //     ->default(fn() => auth()->id())
                                        //     ->inlineLabel()
                                        //     ->extraAttributes(['class' => 'max-w-sm']),

                                        TextInput::make('permintaan')
                                            ->label('Permintaan')
                                            ->required()
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),
                                        // ->extraAttributes(['class' => 'max-w-lg']),

                                        // 👇 Employee field (user_id)
                                        Select::make('hospital_id')
                                            ->label('Hospital')
                                            ->relationship('hospital', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required()
                                            ->inlineLabel()
                                            ->placeholder('')
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        DateTimePicker::make('tgl_instalasi')
                                            ->label('Waktu Mulai')
                                            ->required()
                                            ->default(now())
                                            ->seconds(false)
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->inlineLabel(),

                                        DateTimePicker::make('tgl_selesai')
                                            ->label('Waktu Selesai')
                                            ->default(now())
                                            ->seconds(false)
                                            ->extraAttributes(['class' => 'max-w-sm'])
                                            ->inlineLabel(),

                                        Select::make('item_category_id')
                                            ->label('Alat')
                                            ->relationship('itemCategory', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->inlineLabel()
                                            ->placeholder('')
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        TextInput::make('no_seri')
                                            ->label('No Seri')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Select::make('vendor_id')
                                            ->label('Vendor')
                                            ->relationship('vendor', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->inlineLabel()
                                            ->placeholder('')
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Select::make('partner_id')
                                            ->label('Distributor')
                                            ->relationship('partner', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->inlineLabel()
                                            ->placeholder('')
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        TextInput::make('penanggung_jawab')
                                            ->label('Penanggung Jawab')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Select::make('user_id')
                                            ->label('Teknisi')
                                            ->relationship('user', 'employee_name')
                                            ->searchable()
                                            ->preload()
                                            ->inlineLabel()
                                            ->placeholder('')
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        CheckboxList::make('kondisi_alat')
                                            ->label('Kondisi Alat')
                                            ->options([
                                                'baik' => 'Baik',
                                                'rusak_ringan' => 'Rusak Ringan',
                                                'rusak_berat' => 'Rusak Berat',
                                                'tidak_berfungsi' => 'Tidak Berfungsi',
                                            ])
                                            ->inlineLabel(),

                                        Textarea::make('description')
                                            ->rows(5)
                                            ->cols(20)
                                            ->label('Description')
                                            ->inlineLabel()
                                            ->extraAttributes(['class' => 'max-w-sm']),

                                        Repeater::make('workListMultiple')
                                            ->relationship('workListMultiple')
                                            ->label('Parts used in repairs')
                                            ->columns(4)
                                            ->collapsible()
                                            ->addActionLabel('Add Line')
                                            ->columnSpanFull()
                                            ->schema([
                                                Select::make('item_id')
                                                    ->label('Item')
                                                    ->relationship('item', 'name')
                                                    ->preload()
                                                    ->nullable()
                                                    ->searchable()
                                                    ->placeholder(''),

                                                TextInput::make('description')
                                                    ->label('Description'),

                                                TextInput::make('quantity')
                                                    ->numeric()
                                                    ->label('Quantity'),

                                                Select::make('unit_id')
                                                    ->label('Unit')
                                                    ->nullable()
                                                    ->relationship('unit', 'name')
                                                    ->preload()
                                                    ->placeholder('')
                                                    ->searchable(),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Attachment')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Image')
                                    ->directory('users')
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
                        'success' => 'Completed',
                        'danger' => 'Pending',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('permintaan')
                    ->label('Employee Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('hospital.name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tgl_instalasi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                // ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('tgl_selesai')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                // ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state')
                    ->options([
                        'Pending' => 'Pending',
                        'Completed' => 'Completed',
                    ]),

                Tables\Filters\Filter::make('tgl_instalasi')
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
                                fn(Builder $query, $date) => $query->whereDate('tgl_instalasi', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date) => $query->whereDate('tgl_instalasi', '<=', $date),
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
            ->defaultSort('code', 'desc')
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
            'index' => Pages\ListWorkLists::route('/'),
            'create' => Pages\CreateWorkList::route('/create'),
            'edit' => Pages\EditWorkList::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'AfterSale';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }
}
