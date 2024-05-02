<?php

namespace App\Livewire\Admin;

use App\Enums\Status;
use App\Models\Announcement;
use App\Models\Attribute;
use App\Models\AttributeSection;
use App\Models\Category;
use App\Models\User;
use App\Tables\Columns\ImageGridColumn;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Support\View\Components\Modal;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Grid as LayoutGrid;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Livewire\Attributes\Layout;
use Livewire\Component;
use OwenIt\Auditing\Models\Audit;

class AnnouncementAudits extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    #[Layout('layouts.admin')]

    public Announcement $announcement;

    public function mount(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    public function render()
    {
        return view('livewire.admin.announcement-audits');
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading("Audits")
            ->query($this->announcement->audits()->with('user')->latest()->getQuery())
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('user.name')
                    ->description(fn (Audit $audit) => $audit->ip_address),
                TextColumn::make('user_agent')
                    ->wrap(),
                TextColumn::make('event')
                    ->description(fn (Audit $audit) => $audit->url),
                TextColumn::make('old_values')
                    ->getStateUsing(function (Audit $audit) {
                        foreach ($audit->old_values as $key => $value) {
                            $old_values[] = "{$key}: {$value}";
                        }
                        return $old_values ?? null;
                    })
                    ->listWithLineBreaks()
                    ->bulleted(),
                TextColumn::make('new_values')
                    ->getStateUsing(function (Audit $audit) {
                        foreach ($audit->new_values as $key => $value) {
                            $new_values[] = "{$key}: {$value}";
                        }
                        return $new_values ?? null;
                    })
                    ->listWithLineBreaks()
                    ->bulleted(),
                TextColumn::make('created_at')
                    ->since()
            ])
            ->headerActions([
                Action::make('back')
                    ->url(route('admin.announcement'))
            ])
            ->paginationPageOptions([25, 50, 100]);
    }
}
