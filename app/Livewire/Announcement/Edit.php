<?php

namespace App\Livewire\Announcement;

use App\Forms\Components\Wizard;
use App\Livewire\Traits\AnnouncementCrud;
use App\Livewire\Traits\CreateAnnouncement;
use App\Models\Announcement;
use App\Models\Attribute;
use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
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
use Guava\FilamentClusters\Forms\Cluster;
use Igaster\LaravelCities\Geo;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Layout;

class Edit extends Component implements HasForms
{
    use InteractsWithForms; use AnnouncementCrud;

    public ?array $data = [];

    protected Announcement $record;

    public $parent_categories;

    protected $countries;

    protected $category_attributes = null;

    public $categories = null;

    public function mount($record): void
    {
        $this->parent_categories = Category::where('parent_id', null)->get()->pluck('name', 'id');

        $this->record = $record->load('attributes', 'categories');

        $this->data = [
            'id' => $this->record->id,
            'title' => $this->record->title,
            'description' => $this->record->description,
            'categories' => $this->record->categories->pluck('id')->toArray(),
            'currency_id' => $this->record->currency_id,
            'current_price' => $this->record->current_price,
        ];

        foreach ($this->record->attributes as $attribute) {
            $this->data['attributes'][$attribute->name] = $attribute->pivot->original_value;
        }

        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        $this->setCategories($this->data['categories']);
        $record = $this->record ?? Announcement::find($this->data['id']);

        return $form
            ->schema([
                Wizard::make([
                    Step::make('Information:')
                        ->schema(function (Get $get) {

                            $schema = [
                                Section::make('Category')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema(fn (Get $get, Set $set) => [
                                                Select::make('categories.0')
                                                    ->options($this->parent_categories)
                                                    ->required()
                                                    ->live()
                                                    ->disabled(),
                                                ...$this->getLevels($get, $set)
                                            ]),
                                        
                                    ]),
                            ];

                            foreach ($this->category_attributes?->sortBy('section.order_number')?->groupBy('section.name') ?? [] as $section_name => $section) {
                                if ($fields = $this->getFields($section)) {
                                    $schema[] = Section::make($section_name)->schema([
                                        Grid::make([
                                            'default' => 1,
                                            'sm' => 2,
                                            'md' => 2,
                                            'lg' => 2,
                                            'xl' => 2,
                                            '2xl' => 2,
                                        ])->schema($fields)
                                    ]);
                                }
                            }

                            return $schema;
                        }),
                    Step::make('Photos')
                        ->schema([
                            Section::make('Photos')
                                ->schema([
                                    SpatieMediaLibraryFileUpload::make('attachments')
                                        ->collection('announcements')
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
                ->model($record),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $this->updateAnnouncement((object) $this->data);

        $this->redirectRoute('profile.announcement');
    }

    public function render(): View
    {
        return view('livewire.announcement.edit');
    }

    public function getLevels(Get $get, Set $set, $level = 0)
    {
        $category_children = $this->categories?->get($get('categories.'.$level))?->get('children');
        $level++;
        if ($category_children?->isNotEmpty()) {
            return [
                Select::make('categories.'.$level)
                    ->options($category_children)
                    ->hiddenLabel()
                    ->live()
                    ->disabled()
                    ->required(),
                ...$this->getLevels($get, $set, $level)
            ];
        }
        return [];
    }

    public function getField(?Attribute $attribute)
    {
        return match ($attribute?->create_type) {
            'select' => Select::make($attribute->featured_name)
                ->label($attribute->label)
                ->options($attribute->attribute_options->pluck('name', 'id'))
                ->columnSpan(['default' => 'full', 'sm' => $attribute->column_span])
                ->columnStart(['default' => '1', 'sm' => $attribute->column_start])
                ->hidden(fn (Get $get) => $this->isVisible($get, $attribute))
                ->required($attribute->required)
                ->live(),
            'toggle' => Toggle::make($attribute->featured_name)
                ->label($attribute->label)
                ->columnSpan(['default' => 'full', 'sm' => $attribute->column_span])
                ->columnStart(['default' => '1', 'sm' => $attribute->column_start])
                ->hidden(fn (Get $get) => $this->isVisible($get, $attribute))
                ->live()
                ->required($attribute->required),
            'toggle_buttons' => ToggleButtons::make($attribute->featured_name)
                ->label($attribute->label)
                ->options($attribute->attribute_options->pluck('name', 'id'))
                ->grouped()
                ->live()
                ->columnSpan(['default' => 'full', 'sm' => $attribute->column_span])
                ->columnStart(['default' => '1', 'sm' => $attribute->column_start])
                ->hidden(fn (Get $get) => $this->isVisible($get, $attribute))
                ->required($attribute->required),
            'text_input' => TextInput::make($attribute->featured_name)
                ->label($attribute->label)
                ->columnSpan(['default' => 'full', 'sm' => $attribute->column_span])
                ->columnStart(['default' => '1', 'sm' => $attribute->column_start])
                ->hidden(fn (Get $get) => $this->isVisible($get, $attribute))
                ->required($attribute->required),
            'text_area' => Textarea::make($attribute->featured_name)
                ->label($attribute->label)
                ->autosize()
                ->rows(6)
                ->columnSpan(['default' => 'full', 'sm' => $attribute->column_span])
                ->columnStart(['default' => '1', 'sm' => $attribute->column_start])
                ->hidden(fn (Get $get) => $this->isVisible($get, $attribute))
                ->required($attribute->required),
            'location' => Grid::make(2)->schema([
                    Select::make('country')
                        ->label('Country')
                        ->options($this->countries)
                        ->afterStateUpdated(fn (Set $set) => $set('geo_id', null))
                        ->placeholder('Country')
                        // ->required()
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
                        // ->required()
                        ->placeholder('City')
                        ->live(),
                ]),
                
            default => Hidden::make('')
        };
    }

    public function getFields($group)
    {
        return $group?->sortBy('order_number')
                ?->map(function ($attribute) {
                    return $this->getField($attribute);
                })
                ->all() ?? [];
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

    public function setCategories(array $categoryIds): void
    {
        $this->categories = Category::whereIn('id', $categoryIds)
            ->with('children')
            ->get()
            ->keyBy('id')
            ->map(fn (Category $category) => collect([
                'id' => $category->id,
                'name' => $category->name,
                'children' => $category->children->pluck('name', 'id'),
            ]));

        $this->category_attributes = Attribute::with('attribute_options', 'section')
            ->whereHas('categories', fn (Builder $query) => $query->whereIn('category_id', $categoryIds))
            ->get()
            ->each(fn (Attribute $attribute) => $attribute->opt = $attribute->attribute_options);

        $this->countries = Geo::getCountries()->pluck('name', 'country');
    }

    public function updatedInteractsWithForms($statePath): void
    {
        foreach ($this->getCachedForms() as $form) {
            $form->callAfterStateUpdated($statePath);
        } 

        // $this->setCategories($this->data['categories'] ?? []);
    }
}
