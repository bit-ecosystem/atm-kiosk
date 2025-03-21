<?php
namespace App\Filament\Editor\Resources;

use App\Filament\Editor\Resources\EipResource\Pages;
use App\Models\Eip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class EipResource extends Resource
{

    protected static ?string $model = Eip::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        // $user=Auth::user();
        // dd(session('cu.name'));
        // dd($user);
        // $A = db::table('users')
        // ->leftjoin('');
        $optProcess = DB::table('options')->where('type', 'process')->orderBy('list', 'asc')->pluck('list', 'list');
        $optJenis = DB::table('options')->where('type', 'Jenis')->orderBy('list', 'asc')->pluck('list', 'list');
        $optQuality = DB::table('options')->where('type', 'Quality')->orderBy('list', 'asc')->pluck('list', 'list');
        $optSafety = DB::table('options')->where('type', 'Safety')->orderBy('list', 'asc')->pluck('list', 'list');

    

        $uName = session('cu.name');
        $uEmail = session('cu.email');
        $uStaffNo = session('cu.staffno');
        $uDept = session('cu.department');
        $uGroup = session('cu.group');
        $uRealm = session('cu.realm');
        $uClient = session('cu.client');
        $uReportsTo = session('cu.reportsTo');

        // dd(session('cu'));


          // Retrieve Keycloak user data from session
        // $keycloakUser = session('keycloak_user');
        // // dd($keycloakUser);
        // if ($keycloakUser) {
        //     $decodedUser = json_decode($keycloakUser, true);
        //     // dd($decodedUser);
        //     if ($decodedUser) {
        //         // Debugging: Log the decoded user data
        //         Log::info('Decoded Keycloak User:', $decodedUser);
        //         $userName = $decodedUser['name'] ?? 'Unknown User';
        //         $userId = $decodedUser['nickname'] ?? 'Unknown User';
        //         $userDept = $decodedUser['user']['department'] ?? 'Unknown User';
        //     } else {
        //         Log::error('Failed to decode Keycloak user data.');
        //         $userName = 'Unknown User';
        //     }
        // } else {
        //     Log::error('No Keycloak user data found in session.');
        //     $userName = 'Unknown User';
        // }

           return $form
            ->schema([
                Forms\Components\TextInput::make('empno')->label('Emp No')->readonly()->default($uStaffNo)->disabled(),
                Forms\Components\TextInput::make('name')->readonly()->default($uName)
                ->disabled(),
                Forms\Components\TextInput::make('department')->readonly()->default($uDept)
                ->disabled(),
                Forms\Components\TextInput::make('ext'),
                Forms\Components\DatePicker::make('date')->default(now()),
                Select::make('process')
                ->options($optProcess)
                ->required(),
                Forms\Components\TextInput::make('others'),
                Forms\Components\Select::make('eiptype')
                ->label('EIP Type')
                ->options($optJenis)
                ->required()
                ->reactive(),
                Select::make('additional_info')
                ->label('Safety Type')
                ->visible(fn ($get) => $get('eiptype') === 'Safety')
                ->options($optSafety)
                ->required(),
                Select::make('additional_info')
                ->label('Quality Type')
                ->visible(fn ($get) => $get('eiptype') === 'Quality')
                ->options($optQuality)
                ->required(),
                // Forms\Components\TextInput::make('eipcategory')->label('EIP Category'),
                Forms\Components\TextInput::make('location'),
                Forms\Components\TextInput::make('specificlocation')->label('Specific Location'),
                Forms\Components\TextInput::make('current')->label('Current Condition')->required(),
                Forms\Components\FileUpload::make('currentattachment')->label('Current Attachment')->image()->maxSize(1024)->directory('/public/eip/current')->required(),
                // Forms\Components\TextInput::make('webpath'),
                // Forms\Components\TextInput::make('filesize'),
                Forms\Components\TextInput::make('proposal')->label('Improvement Suggestion')->required(),
                Forms\Components\FileUpload::make('proposalattachment')->label('Improvement Suggestion Attachment')->image()->maxSize(1024)->directory('/public/eip/improvement')->required(),
                // Forms\Components\TextInput::make('webpath1'),
                // Forms\Components\TextInput::make('filesize1'),
                // Forms\Components\DateTimePicker::make('createtime')->time(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        $user=Auth::user();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('empno'),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('department')->searchable(),
                Tables\Columns\TextColumn::make('ext')->searchable(),
                Tables\Columns\TextColumn::make('date')->searchable(),
                Tables\Columns\TextColumn::make('process')->label('Process')->searchable()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('others')->searchable(),
                Tables\Columns\TextColumn::make('eiptype')->searchable(),
                // Tables\Columns\TextColumn::make('eipcategory')->searchable(),
                Tables\Columns\TextColumn::make('location')->searchable(),
                Tables\Columns\TextColumn::make('specificlocation')->searchable(),
                Tables\Columns\TextColumn::make('current')->searchable(),
                Tables\Columns\TextColumn::make('currentattachment')->searchable(),
                Tables\Columns\TextColumn::make('webpath')->searchable(),
                Tables\Columns\TextColumn::make('filesize')->searchable(),
                Tables\Columns\TextColumn::make('proposal')->searchable(),
                Tables\Columns\TextColumn::make('proposalattachment')->searchable(),
                Tables\Columns\TextColumn::make('webpath1')->searchable(),
                Tables\Columns\TextColumn::make('filesize1')->searchable(),

            ])
            ->filters([

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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEips::route('/'),
            'create' => Pages\CreateEip::route('/create'),
            'edit' => Pages\EditEip::route('/{record}/edit'),
        ];
    }

    protected function getFormSchema(): array
    {
        // Fetch options directly from the database
        $optProcess = DB::table('options')->where('type','process')->orderby('list','asc')->get();

        return [
            Select::make('process')
                ->label('Select an Option')
                ->options($optProcess)
                ->required(),
        ];
    }

   
}
