<?php

namespace App\Livewire\Forms;

use App\Enums\Filter;
use App\Enums\Marketplace\Type;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MarketplaceSearchForm extends Form
{
    public $filter = Filter::newest->name;
    public $type;
    public $category = 0;
    public $subcategories = [];
    public $condition = []; 
    public $priceMin = '';
    public $priceMax = '';
    public $search = '';
    public $search_in_caption = false;
    public $location = [];
    public $radius = 10;
}
