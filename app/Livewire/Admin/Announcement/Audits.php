<?php

namespace App\Livewire\Admin\Announcement;

use App\Livewire\Admin\BaseAdminLayout;
use App\Models\Announcement;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use OwenIt\Auditing\Models\Audit;

class Audits extends BaseAdminLayout implements HasForms, HasTable
{
    public Announcement $announcement;

    public function mount($announcement_id)
    {
        $this->announcement = Announcement::find($announcement_id);
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
            ->paginationPageOptions([25, 50, 100]);
    }
}
