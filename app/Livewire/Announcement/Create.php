<?php

namespace App\Livewire\Announcement;

use App\AttributeType\AttributeFactory;
use App\Livewire\Components\Forms\Components\Wizard;
use App\Livewire\Traits\AnnouncementCrud;
use App\Models\Announcement;
use App\Models\Attribute;
use App\Models\Category;
use App\Services\Actions\CategoryAttributeService;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;

class Create extends Component implements HasForms
{
    use InteractsWithForms, AnnouncementCrud;

    public ?array $data = [
        'geo_id' => null,
        'attachments' => null,
        'attributes' => [
            'description' => '',
            'country' => 'CZ',
        ],
        'categories' => [],
    ];

    public $parent_categories;

    protected $schema = [];

    public $category_attributes = null;

    protected $categories = null;

    protected $categoryAttributeService;

    public function boot(CategoryAttributeService $categoryAttributeService)
    {
        $this->categoryAttributeService = $categoryAttributeService;
    }

    public function mount(): void
    {
        $this->parent_categories = Category::where('parent_id', null)->get()->pluck('name', 'id');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make(fn (Get $get, Set $set) => [
                    Step::make('Information:')
                        ->schema([
                            Section::make(__('Category'))
                                ->schema([
                                    Grid::make(2)
                                        ->schema(fn (Get $get, Set $set) => [
                                            Select::make('categories.0')
                                                ->options($this->parent_categories)
                                                ->afterStateUpdated(function (Get $get) {
                                                    foreach ($this->data['categories'] as $key => $value) {
                                                        if ($key == 0) continue;
                                                        unset($this->data['categories'][$key]);
                                                    }
                                                })
                                                ->required()
                                                ->live(),
                                            ...$this->getSubcategories($get, $set)
                                        ]),
                                ]),
                        ]),
                    Step::make('Features')
                        ->schema($this->getFormSchema()),
                    Step::make('Photos')
                        ->schema([
                            Section::make(__('Photos'))
                                ->schema([
                                    SpatieMediaLibraryFileUpload::make('attachments')
                                        ->hiddenLabel()
                                        ->multiple()
                                        ->image()
                                        ->imagePreviewHeight('120')
                                        ->required(),
                                ]),
                        ]),
                    
                ])
                ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament.submit>
                        {{ __('Submit') }}
                    </x-filament.submit>
                BLADE)))
                ->contained(false)
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $this->validate();

        $this->createAnnouncement((object) $this->data);

        $this->redirectRoute('announcement.index');
    }

    public function render(): View
    {
        return view('livewire.announcement.create');
    }

    public function getFormSchema(): array
    {
        return $this->categoryAttributeService->forCreate($this->data['categories'] ?? [])
            ?->sortBy('createSection.order_number')
            ?->groupBy('createSection.name')
            ?->map(function ($section, $section_name) {
                $fields = $this->getFields($section);
                
                if ($fields->isNotEmpty()) {
                    return Section::make($section_name)->schema([
                        Grid::make([
                            'default' => 2,
                            'sm' => 4,
                            'md' => 4,
                            'lg' => 4,
                            'xl' => 4,
                            '2xl' => 4,
                        ])
                        ->schema($fields->toArray())
                    ]);
                }
            })
            ?->filter()
            ?->toArray();
    }

    public function getSubcategories(Get $get, Set $set, int $currentLevel = 0): array
    {
        $currentCategory = $this->getCategories()?->get($get('categories.'.$currentLevel))?->get('children');
        $nextLevel = $currentLevel + 1;

        if ($currentCategory?->isNotEmpty()) {
            return [
                Select::make('categories.'.$nextLevel)
                    ->options($currentCategory?->pluck('name', 'id'))
                    ->hiddenLabel()
                    ->live()
                    ->afterStateUpdated(function (Set $set) use ($nextLevel) {
                        unset($this->data['categories'][$nextLevel+1]);
                    })
                    ->required(),
                ...$this->getSubcategories($get, $set, $nextLevel)
            ];
        }

        return [];
    }

    public function getFields($section)
    {
        return $section->sortBy('create_layout->order_number')->map(function ($attribute) {
                return AttributeFactory::getCreateComponent($attribute);
            })
            ->filter();
    }

    public function getCategories(): SupportCollection
    {
        $cacheKey = implode('_', $this->data['categories'] ?? []) . '_create_categories';

        return Cache::remember($cacheKey, config('cache.ttl'), function () {
            return Category::whereIn('id', $this->data['categories'])
                ->select('id', 'alternames', 'parent_id')
                ->with('children:alternames,id,parent_id')
                ->get()
                ->keyBy('id')
                ->map(fn (Category $category) => collect([
                    'id' => $category->id,
                    'children' => $category->children,
                ]));
        });
    }
}