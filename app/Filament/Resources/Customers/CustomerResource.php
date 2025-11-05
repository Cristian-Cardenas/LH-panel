<?php

namespace App\Filament\Resources\Customers;

use App\Filament\Resources\Customers\Pages\ManageCustomers;
use App\Models\Customer;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Textarea;
class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextArea::make('description')
                    ->label('Descripción')
                    ->required(),
                TextInput::make('price')
                    ->label('Precio')
                    ->required(),
                DatePicker::make('start_date')
                    ->label('Fecha de inicio')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Fecha de entrega')
                    ->required(),
                ToggleButtons::make('status')
                    ->label('Estado')
                    //horizontal display
                    ->inline()
                    //poner color a cada opcion
                    ->options([
                        'Stopped' => 'Sin Iniciar',
                        'In Progress' => 'En Progreso',
                        'Completed' => 'Completado'
                    ])
                    ->colors([
                        'Stopped' => 'danger',
                        'In Progress' => 'info',
                        'Completed' => 'success',
                    ])
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')->label('Nombre'),
                TextEntry::make('description')->label('Descripción'),
                TextEntry::make('price')->label('Precio'),
                TextEntry::make('start_date')
                    ->date()
                    ->label('Fecha de inicio'),
                TextEntry::make('end_date')
                    ->date()
                    ->label('Fecha de finalización'),
                TextEntry::make('status')->label('Estado'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('Nombre'),
                TextColumn::make('description')
                    ->searchable()
                    ->label('Descripción')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('price')
                    ->searchable()
                    ->label('Precio'),
                TextColumn::make('start_date')
                    ->date()
                    ->label('Fecha de inicio')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date()
                    ->label('Fecha de finalización')
                    ->sortable(),
                //poner color segun el estado
                TextColumn::make('status')
                    ->label('Estado')
                    ->sortable()
                    ->badge()
                    // ->formatStateUsing(fn(string $state): string => match ($state) {
                    //     'Stopped' => 'Detenido',
                    //     'In Progress' => 'En Progreso',
                    //     'Completed' => 'Completado',
                    //     default => $state, 
                    // })
                    ->color(fn(string $state): string => match ($state) {
                        'Stopped' => 'danger',
                        'In Progress' => 'info',
                        'Completed' => 'success',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCustomers::route('/'),
        ];
    }
}
