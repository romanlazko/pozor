<?php

namespace App\Livewire;

use App\Models\Announcement;
use App\Notifications\NewMessage;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;

class SendMessage extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $announcement;

    public function sendMessage()
    {
        $announcement = Announcement::findOrFail($this->announcement);

        $action = Action::make('sendMessage')
            ->icon('heroicon-o-paper-airplane');

        if (auth()->guest()) {
            return $action
                ->requiresConfirmation()
                ->modalHeading('You need to login to send message')
                ->modalDescription('')
                ->extraModalFooterActions([
                    Action::make('login')
                        ->color('primary')
                        ->action(fn () => redirect(route('login')))
                ])
                ->modalSubmitAction(false)
                ->modalCancelAction(false);
        }

        if ($announcement->user->id == auth()->id()) {
            return $action
                ->modalHeading('You can\'t send message to yourself')
                ->requiresConfirmation()
                ->modalDescription('')
                ->modalSubmitAction(false);
        }

        return $action
            ->modalHeading(false)
            ->form([
                Textarea::make('message')
                    ->required()
                    ->placeholder('Write a message...')
                    ->rows(6),
            ])
            ->action(function (array $data) use ($announcement){
                $thread = auth()->user()->threads()->where('announcement_id', $announcement->id)->first();

                if (!$thread) {
                    $thread = auth()->user()->threads()->create([
                        'announcement_id' => $announcement->id,
                    ]);

                    $thread->users()->attach([$announcement->user->id]);
                }

                $thread->messages()->create([
                    'user_id' => auth()->id(),
                    'message' => $data['message'],
                ]);
        
                $thread->recipient->notify((new NewMessage($thread))->delay(now()->addMinutes(3)));
            });
    }

    public function render()
    {
        return view('livewire.send-message');
    }
}
