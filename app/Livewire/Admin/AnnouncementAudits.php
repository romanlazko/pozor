<?php

namespace App\Livewire\Admin;

use App\Models\Announcement;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
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
                    // ->url(route('admin.announcement'))
            ])
            ->paginationPageOptions([25, 50, 100]);
    }
}
