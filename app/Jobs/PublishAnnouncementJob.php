<?php

namespace App\Jobs;

use App\Enums\Status;
use App\Facades\Deepl;
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

class PublishAnnouncementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private MarketplaceAnnouncement|RealEstateAnnouncement $announcement)
    {
        //
    }

    public function handle(): void
    {
        if ($this->announcement->status->isAwaitPublication() AND $this->publishOnTelegram($this->announcement)) {
            $this->announcement->update([
                'title' => [
                    'original' => $this->announcement->original_title,
                    'en' => Deepl::translateText($this->announcement->original_title, null, 'en-US')->text,
                    'ru' => Deepl::translateText($this->announcement->original_title, null, 'RU')->text,
                    'cz' => Deepl::translateText($this->announcement->original_title, null, 'CS')->text,
                ],
                'description' => [
                    'original' => $this->announcement->original_description,
                    'en' => Deepl::translateText($this->announcement->original_description, null, 'en-US')->text,
                    'ru' => Deepl::translateText($this->announcement->original_description, null, 'RU')->text,
                    'cz' => Deepl::translateText($this->announcement->original_description, null, 'CS')->text,
                ],
            ]);
            $this->announcement->published();
        }
    }

    private function publishOnTelegram(MarketplaceAnnouncement|RealEstateAnnouncement $announcement)
    {
        if ($announcement->should_be_published_in_telegram) {
            try {
                new Bot('5981959980:AAHtBsJcUuXBfuR6FVgFfNh31r2jQwlF8io');

                $response = BotApi::sendMessageWithMedia([
                    'text'                      => $announcement->prepareForTelegram(),
                    'chat_id'                   => '@pozor_test',
                    'media'                     => $announcement->photos()->pluck('src')->map(function($src) {
                        return env('APP_URL').'/storage/'.$src;
                    })->toArray() ?? null,
                    'parse_mode'                => 'HTML',
                    'disable_web_page_preview'  => 'true',
                ]);

                return $response->getOk();
            } catch (Exception $e) {
                $this->announcement->publishingFailed($e);
                return false;
            }
        }

        return true;
    }
}
