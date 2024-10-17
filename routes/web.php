<?php

use App\Facades\RapidApiTranslator;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Profile\ProfileController;
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
use App\Http\Requests\SearchRequest;
use App\Livewire\Pages\Admin\Announcement\Announcements;
use App\Livewire\Pages\Admin\Announcement\Moderation;
use App\Livewire\Pages\Admin\Settings\Attributes;
use App\Livewire\Pages\Admin\Settings\Categories;
use App\Livewire\Pages\Admin\Settings\Sections;
use App\Livewire\Pages\Admin\Settings\Sortings;
use App\Livewire\Pages\Admin\Telegram\Bots;
use App\Livewire\Pages\Admin\Telegram\Channels;
use App\Livewire\Pages\Admin\Telegram\Chats;
use App\Livewire\Pages\Admin\Telegram\Logs;
use App\Livewire\Pages\Admin\User\Users;
use App\View\Models\HomeViewModel;
use Illuminate\Http\Request;

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

Route::post('/locale', function (Request $request){
    if ($user = auth()->user()) {
        $user->update([
            'locale' => $request->locale
        ]);
    }

    session(['locale' => $request->locale]);

    return back();
})->name('locale');

Route::get('/', function (SearchRequest $request) {
    session()->forget('filters');
    session()->forget('search');
    session()->forget('sort');

    $viewModel = new HomeViewModel();

    return view('home', [
        'announcements' => $viewModel->getAnnouncements(),
        'categories' => $viewModel->getCategories(),
        'request' => $request,
    ]);
})->name('home');



Route::middleware(['auth', 'role:super-duper-admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::name('telegram.')->prefix('telegram')->group(function () {
        Route::get('bots', Bots::class)->name('bots');
        Route::get('{telegram_bot}/chats', Chats::class)->name('chats');
        Route::get('{telegram_bot}/channels', Channels::class)->name('channels');
        Route::get('{telegram_bot}/logs', Logs::class)->name('logs');
    });

    Route::name('announcement.')->prefix('announcement')->group(function () {
        Route::get('announcements', Announcements::class)->name('announcements');
        Route::get('moderation', Moderation::class)->name('moderation');
    });

    Route::name('setting.')->prefix('setting')->group(function () {
        Route::get('categories/{category?}', Categories::class)->name('categories');
        Route::get('attributes', Attributes::class)->name('attributes');
        Route::get('sections', Sections::class)->name('sections');
        Route::get('sortings', Sortings::class)->name('sortings');
    });

    Route::name('users.')->prefix('users')->group(function () {
        Route::get('users', Users::class)->name('users');
    });

    // Route::name('attributes.')->prefix('attributes')->group(function () {
    //     Route::get('section/', AttributeSections::class)->name('section');
    //     Route::get('sorting/', AttributeSorting::class)->name('sorting');
    // });
    
    Route::get('logs', fn () => redirect('admin/logs'))->name('logs');
});

Route::controller(AnnouncementController::class)->name('announcement.')->group(function () {
    Route::get('/all/{category:slug?}', 'index')->name('index');
    Route::get('/search/{category:slug?}', 'search')->name('search');
    Route::get('/show/{announcement:slug}', 'show')->name('show');
});

Route::middleware(['auth'])->name('profile.')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/update', [ProfileController::class, 'update'])->name('update');
    Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('destroy');
    Route::patch('/updateAvatar', [ProfileController::class, 'updateAvatar'])->name('updateAvatar');
    Route::get('/announcement/wishlist', [AnnouncementController::class, 'wishlist'])->name('announcement.wishlist');

    Route::middleware(['verified', 'profile_filled'])->group(function () {
        // Route::get('/announcement', Announcements::class)->name('announcement.index');
        Route::get('/announcement/create', [AnnouncementController::class, 'create'])->name('announcement.create');
    });

    Route::controller(MessageController::class)->prefix('message')->name('message.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('{thread}', 'show')->name('show');
        Route::put('{thread}', 'update')->name('update');
    });

    // Route::patch('/updateLang', [ProfileController::class, 'updateLang'])->name('updateLang');
    
    
    

    
});

Route::get('translate' , function () {
    // $response = Http::withHeaders([
    //     'x-rapidapi-host' => 'nlp-translation.p.rapidapi.com',
    //     'x-rapidapi-key' => 'abb4d8aff0mshe1f1bb77e8e01a2p16e8ecjsned3cdb8857ee',
    // ])->asMultipart()->post('https://nlp-translation.p.rapidapi.com/v1/translate', [
    //     [
    //         'name' => 'from',
    //         'contents' => 'en',
    //     ],
    //     [
    //         'name' => 'to',
    //         'contents' => 'ru',
    //     ],
    //     [
    //         'name' => 'text',
    //         'contents' => "New York City (NYC), often called New York (NY), is the most populous city in the United States. With an estimated 2019 population of 8,336,817 distributed over about 302.6 square miles (784 km2), New York is also the most densely populated major city in the United States.",
    //     ],
    // ]);


    $sourceText = "Мастер маникюра

-Гарантируем полную запись с первого рабочего дня!
-ЗП % от  20000 - 45000 крон + премии+ процент от продаж + 🫰 чаевые 
*Зависит от того, сколько вы готовы работать
-График оговаривается, но обязательно выходные и наличие вечерних смен. 
-  Мы предоставляем абсолютно все расходные материалы, инструменты, форму одежды, всё для правильной стерилизации.
- Официальное трудоустройство (DPP, HPP)

-Опыт работы, минимум пол года активной работы с клиентами
- Знание чешского приветствуется
- Osvědčení (лицензию мастера) мы поможем вам получить
";


    $translation = RapidApiTranslator::text($sourceText)->to('cs')->translate();
    
    dump($translation);
});

Route::get('translate1' , function () {
    // $response = Http::withHeaders([
    //     'x-rapidapi-host' => 'nlp-translation.p.rapidapi.com',
    //     'x-rapidapi-key' => 'abb4d8aff0mshe1f1bb77e8e01a2p16e8ecjsned3cdb8857ee',
    // ])->asMultipart()->post('https://nlp-translation.p.rapidapi.com/v1/translate', [
    //     [
    //         'name' => 'from',
    //         'contents' => 'en',
    //     ],
    //     [
    //         'name' => 'to',
    //         'contents' => 'ru',
    //     ],
    //     [
    //         'name' => 'text',
    //         'contents' => "New York City (NYC), often called New York (NY), is the most populous city in the United States. With an estimated 2019 population of 8,336,817 distributed over about 302.6 square miles (784 km2), New York is also the most densely populated major city in the United States.",
    //     ],
    // ]);


    $translation = (new NlpTranslation('abb4d8aff0mshe1f1bb77e8e01a2p16e8ecjsned3cdb8857ee'))->translateText(
        'New York City (NYC), often called New York (NY), is the most populous city in the United States. With an estimated 2019 population of 8,336,817 distributed over about 302.6 square miles (784 km2), New York is also the most densely populated major city in the United States.', 
        'ru;cs', 'en');
    
    dump($translation);
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
