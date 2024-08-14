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

class Filters extends Component implements HasForms
{
    use InteractsWithForms;

    public $filters = [
    ];

    public $category;

    public function mount(null|array $filters = null , $category = null)
    {
        $this->category = $category;

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
                    ->schema(fn () => $this->getCategoryAttributes()
                        ?->sortBy('filterSection.order_number')
                        ?->groupBy('filterSection')
                        ?->map(function ($section) {
                            $fields = $this->getFields($section);
                            
                            if ($fields->isNotEmpty()) {
                                return Grid::make()
                                    ->schema($fields->toArray())
                                    ->extraAttributes(['class' => 'bg-gray-100 rounded-lg border p-2 border-gray-500']);
                            }
                        })
                        ?->filter()
                        ?->toArray()
                )
            ])
            ->statePath('filters');
    }


    public function render()
    {
        return view('livewire.announcement.filters');
    }

    public function search()
    {
        return $this->redirectRoute('announcement.search', ['category' => $this->category?->slug, 'filters' => $this->filters]);
    }

    public function getFields($group)
    {
        return $group->sortBy('filter_layout.order_number')->map(function (Attribute $attribute) {
            return AttributeFactory::getFilterComponent($attribute);
        })
        ->filter();
    }

    public function getCategoryAttributes()
    {
        $cacheKey = ($this->category?->slug ?? 'default') . '_filters_attributes';

        $category_attributes = Cache::remember($cacheKey, config('cache.ttl'), function () {
            return Attribute::select('id', 'name', 'is_feature', 'visible', 'filter_layout', 'alterlabels')
                ->with('attribute_options:id,alternames,attribute_id,is_default,is_null', 'filterSection:id,order_number')
                ->whereHas('categories', fn (Builder $query) => 
                    $query->whereIn('category_id', $this->category
                        ->getParentsAndSelf()
                        ->pluck('id')
                        ->toArray()
                    )
                )
                ->get();
        });

        return $category_attributes;
    }

    private function resetData()
    {
        $this->form->fill();
        $this->search();
    }
}

