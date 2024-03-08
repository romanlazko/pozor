<?php

namespace App\Jobs;

use App\Models\Marketplace\MarketplaceAnnouncement;
use App\Models\RealEstate\RealEstateAnnouncement;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Romanlazko\Telegram\App\Bot;
use Romanlazko\Telegram\App\BotApi;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private MarketplaceAnnouncement|RealEstateAnnouncement $announcement, private string $message)
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // if ($chat_id = $this->announcement->user->chat?->chat_id) {
            new Bot('5981959980:AAHtBsJcUuXBfuR6FVgFfNh31r2jQwlF8io');

            BotApi::sendMessageWithMedia([
                'text'                      => $this->prepareMessage(),
                'chat_id'                   => '544883527',
                'parse_mode'                => 'HTML',
                'disable_web_page_preview'  => 'true',
            ]);
        // }
    }

    private function prepareMessage()
    {
        $text = [];

        $text[] = "You have a message about you announcement:";

        $text[] = "{$this->announcement->id}";

        $text[] = get_class($this->announcement);

        $text[] = "Message: {$this->message}";

        return implode("\n", $text);
    }
}
