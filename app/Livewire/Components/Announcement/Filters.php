<?php

namespace App\Livewire\Components\Announcement;

use App\AttributeType\AttributeFactory;
use App\Models\Attribute;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use App\Models\Category;
use App\Services\Actions\CategoryAttributeService;
use Filament\Forms\Components\Fieldset;

class Filters extends Component implements HasForms
{
    use InteractsWithForms;

    public $filters = [
    ];

    public $gettedFilters = null;

    public $category;

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
        return view('components.livewire.announcement.filters');
    }

    public function search()
    {
        return $this->redirectRoute('announcement.search', ['category' => $this->category?->slug, 'filters' => $this->filters]);
    }

    public function getFormSchema(): array
    {
        return CategoryAttributeService::forFilter($this->category)
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
        session()->forget('filters');
        $this->reset('filters');
        $this->form->fill($this->filters);
        $this->search();
    }
}

