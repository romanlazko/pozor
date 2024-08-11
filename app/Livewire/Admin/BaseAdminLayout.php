<?php

namespace App\Livewire\Admin;

use App\Enums\Status;
use App\Livewire\Components\Tables\Columns\ImageGridColumn;
use App\Models\Announcement;
use App\Models\AnnouncementStatus;
use App\Models\Category;
use App\Models\TelegramChat;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Filament\Forms\Components\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

abstract class BaseAdminLayout extends Component
{
    use InteractsWithTable;
    use InteractsWithForms;

    #[Layout('layouts.admin')]

    public function render()
    {
        return view('livewire.admin.table');
    }
}