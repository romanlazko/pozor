<?php

namespace App\Livewire\Announcement;

use App\Enums\Currency;
use App\Enums\RealEstate\Condition;
use App\Enums\RealEstate\Equipment;
use App\Enums\RealEstate\Type;
use App\Forms\Components\Wizard;
use App\Livewire\Traits\CreateAnnouncement;
use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Igaster\LaravelCities\Geo;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Layout;

class CreateRealEstateAnnouncement extends Component implements HasForms
{
    use InteractsWithForms, CreateAnnouncement;

    #[Layout('layouts.user')]

    public ?array $data = [];

    public $title = 'Create Real-Estate announcement';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Information:')
                        ->schema([
                            Section::make('Required Information')
                                ->schema([
                                    ToggleButtons::make('type')
                                        ->grouped()
                                        ->required()
                                        ->options(Type::class)
                                        ->default(Type::sell)
                                        ->live(),
                                    Grid::make(2)
                                        ->schema(fn (Get $get, Set $set) => [
                                            Select::make('categories.0')
                                                ->options(Category::where('slug', 'real-estate')->first()?->children->pluck('name', 'id'))
                                                ->afterStateUpdated(function () {
                                                    unset($this->data['categories'][1]);
                                                })
                                                ->required()
                                                ->live(),
                                            ...$this->getLevels($get, $set)
                                        ]),
                                    TextInput::make('title')
                                        ->required(),
                                    Textarea::make('description')
                                        ->autosize()
                                        ->rows(6)
                                        ->required(),
                                ])
                                ->columns(1),
                            Section::make('Location')
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            Select::make('country')
                                                ->label('Country')
                                                ->options(Geo::getCountries()->pluck('name', 'country'))
                                                ->afterStateUpdated(fn (Set $set) => $set('city_id', null))
                                                ->required()
                                                ->live(),
                                            Select::make('geo_id')
                                                ->label('City')
                                                ->options(function (Get $get) {
                                                    return Geo::where('country', $get('country'))->limit(10)->pluck('name', 'id');
                                                })
                                                ->searchable()
                                                ->getSearchResultsUsing(function (string $search, Get $get) {
                                                    return Geo::where('country', $get('country'))
                                                        ->whereRaw('LOWER(alternames) LIKE ?', ['%' . mb_strtolower($search) . '%'])
                                                        ->limit(10)
                                                        ->pluck('name', 'id')
                                                        ->toArray();
                                                })
                                                ->required()
                                                ->live(),
                                        ]),
                                    TextInput::make('features.address')
                                        ->required(),
                                ]),
                            Section::make('Prices')
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            TextInput::make('current_price')
                                                ->label('Price')
                                                ->required(),
                                            Select::make('currency')
                                                ->options(Currency::class)
                                                ->default(Currency::czk)
                                                ->required(),
                                            Select::make('features.price-unit')
                                                ->label('')
                                                ->options([
                                                    'per-day' => 'Per day',
                                                    'per-square-meter-per-day' => 'Per m²/day',
                                                    'per-month' => 'Per month',
                                                    'per-square-meter-per-month' => 'Per m²/month',
                                                    'per-year' => 'Per year',
                                                    'per-square-meter-per-year' => 'Per m²/year'
                                                ])
                                                ->columnStart(2)
                                        ]),
                                    TextInput::make('features.note-on-price')
                                        ->required(),
                                    Grid::make(2)
                                        ->schema([
                                            TextInput::make('features.deposit-price')
                                                ->label('Deposit')
                                                ->required(),
                                        ])
                                        ->hidden(fn (Get $get) => $get('type') == Type::sell),
                                    Grid::make(2)
                                        ->schema([
                                            TextInput::make('features.utilities-price')
                                                ->label('Utilities')
                                                ->required(),
                                        ]),
                                ])
                                ->columns(1),
                        ]),
                    // Step::make('features')
                    //     ->schema([
                    //         Section::make('Building information')
                    //             ->schema([
                    //                 Grid::make(2)
                    //                     ->schema([
                    //                         Select::make('features.building-construction')
                    //                             ->options([
                    //                                 '1' => 'Wooden building',
                    //                                 '2' => 'Brick',
                    //                                 '3' => 'Stone building',
                    //                                 '4' => 'Prefabricated building',
                    //                                 '5' => 'Panel building'
                    //                             ])
                    //                     ]),
                    //                 ToggleButtons::make('features.building-condition')
                    //                     ->grouped()
                    //                     ->required()
                    //                     ->options(Condition::class)
                    //                     ->default(Condition::good),
                    //                 Grid::make(2)
                    //                     ->schema([
                    //                         TextInput::make('features.building-count-of-flors')
                    //                             ->required(),
                    //                         TextInput::make('features.building-count-of-underground-flors')
                    //                             ->required(),
                                            
                    //                     ]),
                    //                 Grid::make(3)
                    //                     ->schema([
                    //                         Toggle::make('features.building-elevator'),
                    //                         Toggle::make('features.building-hendicap'),
                    //                         Toggle::make('features.building-parking'),
                    //                         Toggle::make('features.building-storerooms'),
                    //                     ])
                    //             ]),
                    //         Section::make('Property information')
                    //             ->schema([
                    //                 ToggleButtons::make('features.property-condition')
                    //                     ->grouped()
                    //                     ->required()
                    //                     ->options(Condition::class)
                    //                     ->default(Condition::good),
                    //                 ToggleButtons::make('features.property-furnished')
                    //                     ->grouped()
                    //                     ->required()
                    //                     ->options(Equipment::class)
                    //                     ->default(Equipment::none),
                    //                 Grid::make(2)
                    //                     ->schema([
                    //                         TextInput::make('features.property-flore')
                    //                             ->required(),
                    //                         TextInput::make('features.property-square-meters')
                    //                             ->label('m²')
                    //                             ->required(),
                    //                     ]),
                    //                 Grid::make(3)
                    //                     ->schema([
                    //                         Toggle::make('features.property-balkon'),
                    //                         Toggle::make('features.property-terace'),
                    //                         Toggle::make('features.property-storage'),
                    //                         Toggle::make('features.property-garage'),
                    //                         Toggle::make('features.property-parking'),
                    //                         Toggle::make('features.property-pool'),
                    //                     ]),
                                    
                    //             ]),
                    //         Section::make('Energy performance')
                    //             ->schema([
                    //                 Select::make('features.property-en-performance')
                    //                     ->label('')
                    //                     ->options([
                    //                         'a' => 'A - Extremely economical',
                    //                         'b' => 'B - Very economical'
                    //                     ]),
                    //                 TextInput::make('features.property-en-performance-indicator')
                    //                     ->label('Energy performance indicator: (kWh/m² per year)')
                    //             ]),
                        
                    //     ]),
                    Step::make('features')
                        ->schema(function (Get $get) {
                            $categories = Category::whereIn('id', $get('categories'))->get();

                            $schema = [];

                            foreach ($categories ?? [] as $category) {
                                $attribute_groups = $category->attributes->groupBy('group_name')->all();

                                foreach ($attribute_groups as $group) {
                                    $schema[] = Section::make('')
                                        ->schema([
                                            Grid::make(4)
                                                ->schema(function () use ($group){
                                                    foreach ($group as $attribute) {
                                                        $schema[] = match ($attribute->type) {
                                                            'select' => Select::make($attribute->name)
                                                                ->label($attribute->title)
                                                                ->options($attribute->options)
                                                                ->columnSpan(2),
                                                            'toggle' => Toggle::make($attribute->name)
                                                                ->label($attribute->title)
                                                                ->columnSpan(2),
                                                            'toggle_buttons' => ToggleButtons::make($attribute->name)
                                                                ->label($attribute->title)
                                                                ->options($attribute->options)
                                                                ->grouped()
                                                                ->columnSpan('full'),
                                                            'text_input' => TextInput::make($attribute->name)
                                                                ->label($attribute->title)
                                                                ->columnSpan(2),
                                                        };
                                                    }
                                                    return $schema;
                                                })
                                        ]);
                                }
                            }

                            return $schema;
                        }),
                    Step::make('Photos')
                        ->schema([
                            Section::make('Photos')
                                ->schema([
                                    FileUpload::make('attachment')
                                        ->hiddenLabel()
                                        ->multiple()
                                        ->image()
                                        ->imagePreviewHeight('120'),
                                ]),
                        ]),
                    
                ])
                ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm"
                    >
                        Submit
                    </x-filament::button>
                BLADE)))
                ->contained(false)
                ->skippable()
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $this->createAnnouncement((object) $this->data);

        $this->redirectRoute('profile.announcement');
    }

    public function render(): View
    {
        return view('livewire.announcement.create');
    }

    public function getLevels(Get $get, Set $set, $level = 0)
    {
        $selected_category = Category::find($get('categories.'.$level));
        $level++;
        if ($selected_category AND $selected_category->children->isNotEmpty()) {
            return [
                Select::make('categories.'.$level)
                    ->options($selected_category->children->pluck('name', 'id'))
                    ->hiddenLabel()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function () use ($level) {
                        unset($this->data['categories'][$level+1]);
                    }),
                ...$this->getLevels($get, $set, $level)
            ];
        }
        return [];
    }
}