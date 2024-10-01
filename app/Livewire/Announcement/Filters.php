<?php

namespace App\Livewire\Announcement;

use App\AttributeType\AttributeFactory;
use App\Enums\Sort;
use App\Models\Attribute;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use App\Models\Category;
use App\Services\Actions\CategoryAttributeService;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;

class Filters extends Component implements HasForms
{
    use InteractsWithForms;

    public $filters = [
    ];

    public $gettedFilters = null;

    private $categoryAttributeService;

    public $category;

    public function boot(CategoryAttributeService $categoryAttributeService)
    {
        $this->categoryAttributeService = $categoryAttributeService;
    }

    public function mount(null|array $filters = null , $category = null)
    {
        $this->category = $category;

        $this->gettedFilters = $filters;

        $this->form->fill($filters);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Actions::make([
                    Action::make('reset')
                        ->icon('heroicon-m-x-mark')
                        ->action(fn () => $this->resetData())
                        ->label(__('filament.labels.reset_filters'))
                        ->link()
                        ->color('danger')
                ]),
                Grid::make()
                    ->schema($this->getFormSchema())
            ])
            ->statePath('filters')
            ->extraAttributes(['class' => 'rounded-2xl']);
    }


    public function render()
    {
        return view('livewire.announcement.filters');
    }

    public function search()
    {
        return $this->redirectRoute('announcement.search', ['category' => $this->category?->slug, 'filters' => $this->filters]);
    }

    public function getFormSchema(): array
    {
        return $this->categoryAttributeService->forFilter($this->category)
            ?->sortBy('filterSection.order_number')
            ?->groupBy('filterSection.name')
            ?->map(function ($section, $section_name) {

                $fields = $this->getFields($section);
                
                if ($fields->isNotEmpty()) {
                    return Fieldset::make($section_name)->schema([
                        Grid::make([
                            'default' => 2,
                            'sm' => 4,
                            'md' => 4,
                            'lg' => 4,
                            'xl' => 4,
                            '2xl' => 4,
                        ])
                        ->schema($fields->toArray())
                    ])
                    ->extraAttributes(['class' => 'bg-white']);
                }
            })
            ?->filter()
            ?->toArray();
    }

    public function getFields($group)
    {
        return $group->sortBy('filter_layout.order_number')->map(function (Attribute $attribute) {
            return AttributeFactory::getFilterComponent($attribute);
        })
        ->filter();
    }

    private function resetData()
    {
        $this->reset('filters');
        $this->form->fill($this->filters);
        $this->search();
    }
}

