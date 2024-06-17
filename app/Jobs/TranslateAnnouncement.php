<?php

namespace App\Jobs;

use App\Enums\Status;
use App\Facades\Deepl;
use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class TranslateAnnouncement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Announcement $announcement;
    /**
     * Create a new job instance.
     */
    public function __construct(private int $announcement_id)
    {
        $this->announcement = Announcement::find($announcement_id);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->announcement->status->isAwaitTranslation()) {

            foreach ($this->announcement->features->where('attribute.translatable', true) as $feature) {
                $feature->update([
                    'translated_value' => [
                        'original' => $feature->translated_value['original'],
                        ...Deepl::translate($feature->translated_value['original'])
                    ]
                ]);
            }

            // if (!$this->announcement->translated_title) {
            //     $this->announcement->update([
            //         'translated_title' => [
            //             'en' => Deepl::translateText($this->announcement->title, null, 'en-US')->text,
            //             'ru' => Deepl::translateText($this->announcement->title, null, 'RU')->text,
            //             'cz' => Deepl::translateText($this->announcement->title, null, 'CS')->text,
            //         ],
            //     ]);
            // }

            // if (!$this->announcement->translated_description) {
            //     $this->announcement->update([
            //         'translated_description' => [
            //             'en' => Deepl::translateText($this->announcement->description, null, 'en-US')->text,
            //             'ru' => Deepl::translateText($this->announcement->description, null, 'RU')->text,
            //             'cz' => Deepl::translateText($this->announcement->description, null, 'CS')->text,
            //         ],
            //     ]);
            // }

            
    
            // $this->announcement->attributes->each(function ($attribute) {
            //     $attribute->pivot->update([
            //         'value' => [
            //             'original' => $attribute->pivot->original_value,
            //             'en' => Deepl::translateText($attribute->pivot->original_value, null, 'en-US')->text,
            //             'ru' => Deepl::translateText($attribute->pivot->original_value, null, 'RU')->text,
            //             'cz' => Deepl::translateText($attribute->pivot->original_value, null, 'CS')->text,
            //         ],
            //     ]);
            // });

            $this->announcement->translated();
        }
    }

    public function failed(Throwable $exception): void
    {
        $this->announcement->translationFailed(['info' => $exception->getMessage()]);
    }
}
