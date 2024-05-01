<?php

namespace App\Jobs;

use App\Models\Marketplace\MarketplaceAnnouncement;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use NlpTools\Classifiers\MultinomialNBClassifier;
use NlpTools\Documents\TokensDocument;
use NlpTools\Documents\TrainingDocument;
use NlpTools\FeatureFactories\DataAsFeatures;
use NlpTools\Models\FeatureBasedNB;
use NlpTools\Tokenizers\WhitespaceTokenizer;

class ModerateAnnouncementByClarifiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private MarketplaceAnnouncement $announcement)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->announcement->status == 'await_moderation') {
            try {
                $this->moderate($this->announcement->caption) 
                ? $this->announcement->moderationPassed()
                : $this->announcement->moderationNotPassed();
                
            } catch (Exception $e) {
                $this->announcement->fail($e);
            }
        }
    }

    private function moderate($caption)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Key c965004068a6498aa452a3306f2b516d',
            'Content-Type' => 'application/json',
        ])->post('https://api.clarifai.com/v2/users/clarifai/apps/main/models/moderation-multilingual-text-classification/versions/79c2248564b0465bb96265e0c239352b/outputs', [
            'inputs' => [
                [
                    'data' => [
                        'text' => [
                            'raw' => $caption,
                        ],
                    ],
                ],
            ],
        ])->json();

        if ($response) {
            foreach ($response['outputs'][0]['data']['concepts'] as $concept) {
                if ($concept['value'] > 0.1) {
                    return false;
                }
            }
        }

        return true;
    }
}
