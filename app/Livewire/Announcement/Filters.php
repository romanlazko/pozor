<?php

namespace App\Livewire\Announcement;

use App\Enums\Sort;
use App\Models\Attribute;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Guava\FilamentClusters\Forms\Cluster;
use Igaster\LaravelCities\Geo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Filters extends Component implements HasForms
{
    use InteractsWithForms;

    public $data = [
    ];

    protected $countries;

    protected $category_attributes = null;

    public $category;

    public function mount($search = null , $category = null)
    {
        $this->category = $category;
        $this->setCategories();

        $this->form->fill($search);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('sort')
                    ->label('Sorting')
                    ->options(Sort::class)
                    ->selectablePlaceholder(false)
                    ->hintAction(
                        Action::make('reset')
                            ->icon('heroicon-m-x-mark')
                            ->action(function () {
                                $this->data = [
                                ];
                                $this->search();
                            })
                            ->label(__('Reset filters'))
                    ),
                Grid::make()
                    ->schema(function () {
                        $schema = [];
                        
                        foreach ($this->category_attributes?->sortBy('section.order_number')?->groupBy('section') ?? [] as $group) {
                            if ($fields = $this->getFields($group)) {
                                $schema[] = Grid::make()
                                    ->schema($fields);
                            }
                        }

                        return $schema;
                    })
            ])
            ->statePath('data');
    }


    public function render()
    {
        return view('livewire.announcement.filters');
    }

    public function search()
    {
        $data = urlencode(encrypt(serialize($this->data))); 

        Session::put('announcement_search', $data);

        return $this->redirectRoute('announcement.index', ['category' => $this->category?->slug]);
    }

    public function getField($attribute)
    {
        if (!$attribute->searchable) return null;

        return match ($attribute?->search_type) {
            'select' => Select::make($attribute->featured_name)
                ->label($attribute->label)
                ->options($attribute->attribute_options?->pluck('name', 'id'))
                ->columnSpanFull()
                ->hidden(fn (Get $get) => $this->isVisible($get, $attribute)),

            'toggle' => Toggle::make($attribute->featured_name)
                ->label($attribute->label)
                ->columnSpanFull()
                ->hidden(fn (Get $get) => $this->isVisible($get, $attribute)),

            'toggle_buttons' => ToggleButtons::make($attribute->featured_name)
                ->label($attribute->label)
                ->options($attribute->attribute_options?->pluck('name', 'id'))
                ->grouped()
                ->live()
                ->columnSpanFull()
                ->hidden(fn (Get $get) => $this->isVisible($get, $attribute)),

            'search' => Grid::make(1)
                ->schema([
                    TextInput::make('search')
                        ->label('Search')
                        ->columnSpanFull(),
                    Checkbox::make('search_in_description'),
                ]),

            'between' => Cluster::make([
                            TextInput::make($attribute->featured_name.'.min')
                                ->placeholder('min')
                                ->numeric()
                                ->default(''),
                            TextInput::make($attribute->featured_name.'.max')
                                ->placeholder('max')
                                ->numeric()
                                ->default(''),
                        ])
                        ->label($attribute->label)
                        ->columnSpanFull()
                        ->columns(['default' => 2])
                        ->hidden(fn (Get $get) => $this->isVisible($get, $attribute)),
            'checkboxlist' => CheckboxList::make($attribute->featured_name)
                        ->label($attribute->label)
                        ->options($attribute->attribute_options?->pluck('name', 'id'))
                        ->columns($attribute->column_span)
                        ->columnSpanFull()
                        ->hidden(fn (Get $get) => $this->isVisible($get, $attribute)),
            'tags' => TagsInput::make('tags')
                        ->suggestions([
                            'apple',
                            'phone',
                            'notebooks',
                        ])
                        ->splitKeys(['Tab', ' ', ',', '.', 'ArrowDown', 'ArrowRight']),
            'location' => Grid::make(2)->schema([
                            Select::make('country')
                                ->label('Country')
                                ->options($this->countries)
                                ->afterStateUpdated(fn (Set $set) => $set('geo_id', null))
                                ->placeholder('Country')
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
                                        ->pluck('name', 'id');
                                })
                                ->placeholder('City')
                                ->live(),
                        ]),
            default => null
        };
    }

    public function getFields($group)
    {
        $fields = [];

        $attributes = $group?->sortBy('order_number');

        foreach ($attributes as $attribute) {
            if ($field = $this->getField($attribute)) {
                $fields[] = $field;
            }
        }
        return $fields;
    }

    public function isVisible(Get $get, $attribute)
    {
        if (!empty($attribute->visible)) {
            foreach ($attribute->visible as $condition) {
                if ($get($condition['attribute_name']) == $condition['value'] OR $get('attributes.'.$condition['attribute_name']) == $condition['value']) return false;
            }
            return true;
        }
        return false;
    }

    public function setCategories(): void
    {
        $this->category_attributes = Cache::remember(($this->category?->slug ?? 'default') . '_filters_attributes', 3600, function () {
            return Attribute::select('id', 'name', 'searchable', 'search_type', 'is_feature', 'label', 'visible', 'column_span', 'order_number', 'attribute_section_id', 'alterlabels')
                ->with('attribute_options:id,name,alternames,attribute_id', 'section:id,order_number')
                ->when($this->category, function ($query) {
                    $categoryIds = $this->category
                        ->getParentsAndSelf()
                        ->pluck('id')
                        ->toArray();
                    
                    $query->whereHas('categories', fn (Builder $query) => $query->whereIn('category_id', $categoryIds ?? [])->select('categories.id'));
                })
                
                ->when(!$this->category, function ($query) { 
                    $query->whereHas('section', fn (Builder $query) => $query->whereIn('slug', ['required_information', 'location', 'prices'])->select('attribute_sections.id'));
                })
                
                ->get();
        });

        $this->countries = Cache::remember('countries', 3600, fn () => Geo::getCountries()->pluck('name', 'country'));
    }

    public function updatedInteractsWithForms($statePath): void
    {
        foreach ($this->getCachedForms() as $form) {
            $form->callAfterStateUpdated($statePath);
        }

        $this->setCategories();
    }
}