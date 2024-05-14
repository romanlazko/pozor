<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\SuperDuperAdmin\Telegram\TelegramAdvertisementController;
use App\Http\Controllers\SuperDuperAdmin\Telegram\TelegramChatController;
use App\Http\Controllers\SuperDuperAdmin\Telegram\TelegramController;
use App\Livewire\Admin\AnnouncementAudits;
use App\Livewire\Admin\Announcements as AdminAnnouncements;
use App\Livewire\Admin\Attributes;
use App\Livewire\Admin\Categories;
use App\Livewire\Announcement\Create;
use App\Livewire\Profile\Announcements;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use NlpTools\Classifiers\MultinomialNBClassifier;
use NlpTools\Documents\TokensDocument;
use NlpTools\Documents\TrainingSet;
use NlpTools\FeatureFactories\DataAsFeatures;
use NlpTools\Models\FeatureBasedNB;
use NlpTools\Tokenizers\WhitespaceTokenizer;
use Stevebauman\Location\Facades\Location;
use App\Http\Controllers\Profile\MessageController;

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

// Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
// Route::get('/category/{category:slug?}', [WelcomeController::class, 'search'])->name('search_by_category');
// Route::post('/search', [WelcomeController::class, 'search'])->name('search');
Route::get('/', fn () => redirect()->route('announcement.index'));

Route::controller(AnnouncementController::class)->name('announcement.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/search/{category:slug}', 'search')->name('search');
    Route::get('/show/{announcement:slug}', 'show')->name('show');
    // Route::get('/create', 'create')->middleware('auth')->name('create');
    // Route::get('/edit/{announcement}', 'edit')->middleware('auth')->name('edit');
    // Route::patch('/update/{announcement}', 'update')->middleware('auth')->name('update');
    // Route::delete('/delete/{announcement}', 'delete')->middleware('auth')->name('delete');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:super-duper-admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::resource('telegram_bot', TelegramController::class);
        
    Route::resource('telegram_bot.chat', TelegramChatController::class);
    Route::resource('telegram_bot.advertisement', TelegramAdvertisementController::class);

    Route::get('category/{category?}', Categories::class)->name('categories');

    Route::get('attribute', Attributes::class)->name('attributes');
    Route::get('announcement', AdminAnnouncements::class)->name('announcement');
    Route::get('announcement/audit/{announcement}', AnnouncementAudits::class)->name('announcement.audit');
});

Route::middleware('auth')->name('profile.')->prefix('profile')->group(function () {
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/update', [ProfileController::class, 'update'])->name('update');
    Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('destroy');

    Route::patch('/updateLang', [ProfileController::class, 'updateLang'])->name('updateLang');
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/announcement', Announcements::class)->name('announcement.index');
    Route::get('/announcement/create', Create::class)->name('announcement.create');


    Route::controller(MessageController::class)->prefix('message')->name('message.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{thread}', 'show')->name('show');
        Route::put('{thread}', 'update')->name('update');
    });
});


// Route::middleware('auth')->group(function () {
//     Route::get('create', Create::class)->name('announcement.create');
//     // Route::get('/announcement/create', function () {
//     //     return view('announcement.create');
//     // })->name('announcement.create');
// });

// Route::middleware('auth')->prefix('create')->group(function () {
//     Route::get('/', Create::class)->name('create');

//     // Route::get('/marketplace', MarketplaceCreate::class)->name('marketplace.create');
//     // Route::get('/real-estate', RealEstateCreate::class)->name('real-estate.create');
// });

// Route::middleware('auth')->prefix('create')->name('create.')->group(function () {
//     Route::get('electronic', CreateElectronicAnnouncement::class)->name('electronic');
//     Route::get('real-estate', CreateRealEstateAnnouncement::class)->name('real-estate');
//     Route::get('clothing', CreateClothingAnnouncement::class)->name('clothing');
    
//     // Route::get('/marketplace', MarketplaceCreate::class)->name('marketplace.create');
//     // Route::get('/real-estate', RealEstateCreate::class)->name('real-estate.create');
// });

// Route::resource('marketplace', MarketplaceController::class)->parameters([
//     'marketplace' => 'marketplaceAnnouncement:slug',
// ]);
// Route::resource('real-estate', RealEstateController::class)->parameters([
//     'real-estate' => 'realEstateAnnouncement:slug',
// ]);
    // Route::get('/show/{announcement:slug}', MarketplaceShow::class)->name('show');

// Route::name('real-estate.')->prefix('real-estate')->group(function () {
//     Route::get('/', RealEstateIndex::class)->name('index');
//     Route::get('/show/{announcement:slug}', RealEstateShow::class)->name('show');
    
// });







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
