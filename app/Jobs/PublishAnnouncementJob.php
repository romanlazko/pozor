<?php

namespace App\Jobs;

use App\Enums\Status;
use App\Facades\Deepl;
use App\Models\Announcement;
use App\Models\TelegramChat;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Romanlazko\Telegram\App\Bot;
use Romanlazko\Telegram\App\BotApi;

class PublishAnnouncementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $announcement;

    /**
     * Create a new job instance.
     */
    public function __construct($announcement_id)
    {
        $this->announcement = Announcement::find($announcement_id);
    }

    public function handle(): void
    {
        if ($this->announcement->status->isAwaitPublication() AND $this->publishOnTelegram($this->announcement)) {
            $this->announcement->published();
        }
    }

    private function publishOnTelegram(Announcement $announcement)
    {
        if ($announcement->channels->isEmpty()) {
            return true;
        }
        
        foreach ($announcement->channels->whereNot('status', Status::published) as $announcement_channel) {
            try {
                $bot = new Bot($announcement_channel->channel->bot->token);

                $response = $bot::sendMessageWithMedia([
                    'text'                      => $this->announcement->getFeatureByName('title')?->value,
                    'chat_id'                   => $announcement_channel->channel->chat_id,
                    'media'                     => [$this->announcement->getFirstMediaUrl('announcements')],
                    'parse_mode'                => 'HTML',
                    'disable_web_page_preview'  => 'true',
                ]);

                $announcement_channel->update([
                    'status' => Status::published,
                    'info' => [
                        'info' => $response->getDescription()
                    ],
                ]);
            } catch (Exception $exception) {
                $announcement_channel->update([
                    'status' => Status::publishing_failed,
                    'info' => [
                        'info' => $exception->getMessage(),
                    ]
                ]);
    
                throw new Exception($exception->getMessage());
            }
        }

        return true;
    }

    public function failed(Exception $exception)
    {
        $this->announcement->publishingFailed(['info' => $exception->getMessage()]);
    }
}
