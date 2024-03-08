<?php

namespace App\Jobs;

use App\Models\Marketplace\MarketplaceAnnouncement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NlpTools\Classifiers\MultinomialNBClassifier;
use NlpTools\Documents\TokensDocument;
use NlpTools\Documents\TrainingSet;
use NlpTools\FeatureFactories\DataAsFeatures;
use NlpTools\Models\FeatureBasedNB;
use NlpTools\Tokenizers\WhitespaceTokenizer;

class ModerateAnnouncementByNplToolsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $training;
    private $tset;
    private $tok;
    private $ff;

    /**
     * Create a new job instance.
     */
    public function __construct(private MarketplaceAnnouncement $announcement)
    {
        $this->training = json_decode(file_get_contents('npl-data.json'), true);
        $this->tset = new TrainingSet(); // will hold the training documents
        $this->tok = new WhitespaceTokenizer(); // will split into tokens
        $this->ff = new DataAsFeatures(); // see features in documentation
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->moderate($this->announcement->caption) != 'nonsense') {
            
        }
    }

    public function moderate($text)
    {
        foreach ($this->training as $item) {
            $this->tset->addDocument(
                $item['class'],
                new TokensDocument(
                    $this->tok->tokenize($item['text'])
                )
            );
        }
        
        $model = new FeatureBasedNB(); // train a Naive Bayes model
        $model->train($this->ff, $this->tset);
        
        $cls = new MultinomialNBClassifier($this->ff, $model);
        
        return $cls->classify(
            array('nonsense', 'approve'), // all possible classes
            new TokensDocument(
                $this->tok->tokenize($text) // The document
            )
        );
    }
}
