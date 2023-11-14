<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ElectionResource\Pages;
use App\Filament\Resources\ElectionResource\RelationManagers;
use App\Models\Election;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;

class ElectionResource extends Resource
{
    protected static ?string $model = Election::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->unique()->inlineLabel(),
                Select::make('status')
                    ->label('Status')
                    ->placeholder('')
                    ->options(
                        [
                            'active' => 'Active',
                            'suspended' => 'Suspended',
                        ]
                    )
                    ->required()
                    ->inlineLabel(),
                DatePicker::make('start_date')->nullable()->required()->inlineLabel(),
                DatePicker::make('end_date')->nullable()->after('start_date')->required()->inlineLabel(),
                TextInput::make('atl_candidate_no')->required()->numeric()->inlineLabel(),
                TextInput::make('btl_candidate_no')->required()->numeric()->inlineLabel(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('start_date')->searchable()->sortable(),
                TextColumn::make('end_date')->searchable()->sortable(),
                TextColumn::make('status')->searchable()->sortable(),
                TextColumn::make('atl_candidate_no')->sortable(),
                TextColumn::make('btl_candidate_no')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageElections::route('/'),
        ];
    }
}
