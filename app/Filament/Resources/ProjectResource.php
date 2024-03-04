<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
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

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('company_name')->required(),
                TextInput::make('company_slug')->required(),
                TextInput::make('status')->required(),
                TextInput::make('url'),
                TextInput::make('project')->required(),
                TextInput::make('project_type')->required(),
                TextArea::make('key_notes'),
                TextArea::make('description'),
                TextArea::make('short_description'),
                TextInput::make('date_started'),
                TextInput::make('date_completed'),
                TextInput::make('country'),
                TextInput::make('location'),
                TextInput::make('industry'),
                TextInput::make('sub_industry'),
                TextArea::make('problem_statement'),
                TextArea::make('solution_summary'),
                TextArea::make('feedback'),
                TextArea::make('feedback'),
                TextArea::make('team_info'),
                TextArea::make('blurb'),
                Repeater::make('tech_stack')
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_name')->label('Company'),
                TextColumn::make('project')->label('Project'),
                TextColumn::make('project_type')->label('Project Type'),
                TextColumn::make('country')->label('Country'),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
