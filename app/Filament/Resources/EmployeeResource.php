<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->required(),
                TextInput::make('latest_role')->required(),
                Textarea::make('summary')->required(),
                Repeater::make('work_experience')
                    ->required()
                    ->schema([
                        TextInput::make('position')->required(),
                        TextInput::make('company')->required(),
                        TextInput::make('employment_period')->required(),
                        TextArea::make('responsibilities')->required(),
                        Repeater::make('stack')
                            ->required()
                            ->schema([
                                TextInput::make('tech_stack'),
                                Select::make('usage')
                                    ->options([
                                        'Front-end',
                                        'Back-end',
                                        'Mobile Application',
                                        'Server',
                                        'CI/CD',
                                        'Project Management',
                                        'Payment Integration',
                                        'Development Tools',
                                        'Testing',
                                        'Documentation',
                                        'Development',
                                    ])
                            ]),
                    ]),
                Repeater::make('education')
                    ->schema([
                        TextInput::make('degree'),
                        TextInput::make('institution'),
                        TextInput::make('graduation_period'),
                    ]),
                Textarea::make('extra_curricular'),
                Textarea::make('volunteer_work'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('latest_role')->label('Role'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
