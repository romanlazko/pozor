<?php

namespace App\Livewire\Forms;

use App\Enums\Filter;
use App\Enums\RealEstate\Type;
use App\Models\RealEstate\RealEstateCategory;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RealEstateSearchForm extends Form
{
    public $filter = Filter::newest->name;
    public $type = Type::rent->value;
    public $category = 1;
    public $subcategory = null;
    public $configurations = [];
    public $condition = [];
    public $priceMin = null;
    public $priceMax = null;
    public $additional_spaces = [];
    public $minSquareMeters = null;
    public $maxSquareMeters = null;
    public $minFlore = null;
    public $maxFlore = null;
    public $location = [];
    public $radius = 10;
    public $equipment = [];
}
