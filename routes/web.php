<?php

use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\RealEstateController;
use App\Http\Controllers\SuperDuperAdmin\Marketplace\AnnouncementController;
use App\Http\Controllers\SuperDuperAdmin\Telegram\TelegramAdvertisementController;
use App\Http\Controllers\SuperDuperAdmin\Telegram\TelegramChatController;
use App\Http\Controllers\SuperDuperAdmin\Telegram\TelegramController;
use App\Livewire\Marketplace\Create as MarketplaceCreate;
use App\Livewire\Marketplace\Index as MarketplaceIndex;
use App\Livewire\Marketplace\Show as MarketplaceShow;
use App\Livewire\Profile\Announcements;
use App\Livewire\Profile\Create\Marketplace;
use App\Livewire\Profile\Create;
use App\Livewire\Profile\Create\RealEstate;
use App\Livewire\Profile\Dashboard;
use App\Livewire\Profile\Edit;
use App\Livewire\RealEstate\Create as RealEstateCreate;
use App\Livewire\RealEstate\Index as RealEstateIndex;
use App\Livewire\RealEstate\Show as RealEstateShow;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use NlpTools\Classifiers\MultinomialNBClassifier;
use NlpTools\Documents\TokensDocument;
use NlpTools\Documents\TrainingSet;
use NlpTools\FeatureFactories\DataAsFeatures;
use NlpTools\Models\FeatureBasedNB;
use NlpTools\Tokenizers\WhitespaceTokenizer;
use Stevebauman\Location\Facades\Location;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome' );
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->name('admin.')->prefix('admin')->group(function () {
    Route::resource('telegram_bot', TelegramController::class);
        
    Route::resource('telegram_bot.chat', TelegramChatController::class);
    Route::resource('telegram_bot.advertisement', TelegramAdvertisementController::class);

    Route::name('marketplace.')->prefix('marketplace')->group(function () {
        
        Route::get('announcement/{announcement}/cancel_moderation', [AnnouncementController::class, 'cancel_moderation'])->name('announcement.cancel_moderation');
        Route::get('announcement/{announcement}/retry', [AnnouncementController::class, 'retry'])->name('announcement.retry');
        Route::get('announcement/{announcement}/moderate', [AnnouncementController::class, 'moderate'])->name('announcement.moderate');
        Route::get('announcement/{announcement}/approve', [AnnouncementController::class, 'approve'])->name('announcement.approve');
        Route::get('announcement/{announcement}/stop_publication', [AnnouncementController::class, 'stop_publication'])->name('announcement.stop_publication');
        Route::get('announcement/{announcement}/publish', [AnnouncementController::class, 'publish'])->name('announcement.publish');
        Route::get('announcement/{announcement}/reject', [AnnouncementController::class, 'reject'])->name('announcement.reject');
        Route::resource('announcement', AnnouncementController::class);
    });
});

Route::middleware('auth')->name('profile.')->prefix('profile')->group(function () {
    Route::get('edit', Edit::class)->name('edit');
    Route::patch('/update', [ProfileController::class, 'update'])->name('update');
    Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('destroy');
    Route::get('announcements', Announcements::class)->name('announcements');
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    
    Route::prefix('create')->group(function () {
        Route::get('/', Create::class)->name('create');
        Route::get('/marketplace', MarketplaceCreate::class)->name('marketplace.create');
        Route::get('/real-estate', RealEstateCreate::class)->name('real-estate.create');
    });
});

Route::name('marketplace.')->prefix('marketplace')->group(function () {
    Route::get('/', MarketplaceIndex::class)->name('index');
    Route::get('/show/{announcement:slug}', MarketplaceShow::class)->name('show');
    
});

Route::name('real-estate.')->prefix('real-estate')->group(function () {
    Route::get('/', RealEstateIndex::class)->name('index');
    Route::get('/show/{announcement:slug}', RealEstateShow::class)->name('show');
    
});







Route::get('/request', function () {
    
    
    $response = Http::withHeaders([
        'Authorization' => 'Key c965004068a6498aa452a3306f2b516d',
        'Content-Type' => 'application/json',
    ])->post('https://api.clarifai.com/v2/users/clarifai/apps/main/models/moderation-multilingual-text-classification/versions/79c2248564b0465bb96265e0c239352b/outputs', [
        'inputs' => [
            [
                'data' => [
                    'text' => [
                        'raw' => "Продам пачку сигарет",
                    ],
                ],
            ],
        ],
    ])->json();

    dump($response['outputs'][0]['data']['concepts']);

    foreach ($response['outputs'][0]['data']['concepts'] as $concept) {
        if ($concept['value'] > 0.1) {
            return 'moderate';
        }
    }
    return 'ok';

});

Route::get('/npl-train', function () {
    $training = json_decode(file_get_contents('npl-data.json'), true);
    $tset = new TrainingSet(); // will hold the training documents
    $tok = new WhitespaceTokenizer(); // will split into tokens
    $ff = new DataAsFeatures(); // see features in documentation
    
    // ---------- Training ----------------
    foreach ($training as $item)
    {
        $tset->addDocument(
            $item['class'], // class
            new TokensDocument(
                $tok->tokenize($item['text']) // The actual document
            )
        );
    }
    
    $model = new FeatureBasedNB(); // train a Naive Bayes model
    $model->train($ff,$tset);
    
    $cls = new MultinomialNBClassifier($ff,$model);
    
    return $cls->classify(
        array('nonsense','approve'), // all possible classes
        new TokensDocument(
            $tok->tokenize("Отдам в хорошие руки щенков лабрадора. Они очень милые и игривые. Возраст 2 месяца, привиты и обработаны от паразитов. Есть мальчики и девочки. Звоните по номеру +7 888 888 88 88") // The document
        )
    );

});

Route::get('/openai', function () {
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . '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',
    ])
    ->post('https://api.openai.com/v1/moderations', [
        'input' => 'Отдам в хорошие руки щенков лабрадора. Они очень милые и игривые. Возраст 2 месяца, привиты и обработаны от паразитов. Есть мальчики и девочки. Звоните по номеру +7 888 888 88 88',
        'model' => 'text-moderation-latest'
    ])->json();
    

    dump($response);
});

Route::get('/location', function () {
    dd(Location::get(), request()->ip());
});





require __DIR__.'/auth.php';
