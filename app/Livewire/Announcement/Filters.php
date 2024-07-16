<?php

namespace App\Livewire\Announcement;

use App\AttributeType\AttributeFactory;
use App\Enums\Sort;
use App\Models\Attribute;
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

    public $data = [
    ];

    protected $fields = [];

    protected $category_attributes = null;

    public $category;

    public function mount($search = null , $category = null)
    {
        $this->category = $category;

        $this->form->fill($search);
    }

    public function form(Form $form): Form
    {
        $this->fields = $this->getCategoryAttributes()
            ?->sortBy('section.order_number')
            ?->groupBy('section')
            ?->map(function ($section) {
                $fields = $this->getFields($section);
                
                if (!empty($fields)) {
                    return Grid::make()->schema($fields);
                }
            })
            ?->filter()
            ?->toArray();

        return $form
            ->schema([
                Select::make('sort')
                    ->label(__('filament.labels.sorting'))
                    ->options(Sort::class)
                    ->selectablePlaceholder(false)
                    ->hintAction(
                        Action::make('reset')
                            ->icon('heroicon-m-x-mark')
                            ->action(fn () => $this->reset('data'))
                            ->label(__('filament.labels.reset_filters'))
                    ),
                Grid::make()
                    ->schema($this->fields)
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

    public function getFields($group)
    {
        return $group->sortBy('order_number')->map(function ($attribute) {
            return AttributeFactory::getFilterComponent($attribute);
        })
        ->filter()
        ->toArray();
    }

    public function getCategoryAttributes()
    {
        $cacheKey = ($this->category?->slug ?? 'default') . '_filters_attributes';

        // return Cache::remember($cacheKey, config('cache.ttl'), function () {
            return Attribute::select('id', 'name', 'filterable', 'search_type', 'is_feature', 'visible', 'column_span', 'order_number', 'attribute_section_id', 'alterlabels')
                ->with('attribute_options:id,alternames,attribute_id,is_default,is_null', 'section:id,order_number')

                ->when($this->category, function ($query) {
                    $categoryIds = $this->category
                        ->getParentsAndSelf()
                        ->pluck('id')
                        ->toArray();
                    
                    $query->whereHas('categories', fn (Builder $query) => $query->whereIn('category_id', $categoryIds ?? [])->select('categories.id'));
                })
                
                ->when(!$this->category, function (Builder $query) { 
                    $query->where('always_required', true);
                })

                ->get();
        // });
    }
}

