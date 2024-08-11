<?php

namespace App\Livewire\Components\Tables\Columns;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\SelectColumn;

class StatusSwitcher extends SelectColumn
{
    protected string $view = 'components.livewire.tables.columns.status-switcher';
}
