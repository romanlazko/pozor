<?php 

namespace App\Bots\pozorbottestbot\Commands\UserCommands\Marketplace;

use App\Bots\pozorbottestbot\Http\DataTransferObjects\Announcement;
use App\Bots\pozorbottestbot\Http\Services\BaraholkaAnnouncementService;
use App\Bots\pozorbottestbot\Models\BaraholkaAnnouncement;
use App\Enums\Marketplace\Type;
use App\Enums\Status;
use App\Models\Marketplace\MarketplaceAnnouncement;
use App\Models\User;
use GuzzleHttp\Client;
use Igaster\LaravelCities\Geo;
use Illuminate\Support\Facades\Storage;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\DB;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class SaveAnnouncement extends Command
{
    public static $command = 'save_announcement';

    public static $usage = ['save_announcement'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $notes = $this->getConversation()->notes;

        $user = User::where('telegram_chat_id', DB::getChat($updates->getChat()->getId())->id)->first();

        $location = Geo::findName($notes['city'])->toArray();

        $announcement = $user->marketplaceAnnouncements()->create([
            'type'              => $notes['type'],
            'title'             => $notes['title'],
            'category_id'       => $notes['category_id'],
            'subcategory_id'    => $notes['subcategory_id'],
            'price'             => $notes['price'],
            'currency'          => $notes['currency'] ?? "CZK",
            'condition'         => $notes['condition'],
            // 'shipping'          => $this->shipping'],
            // 'payment'           => $this->payment'],
            'location'          => $location,
            'latitude'          => $location['lat'],
            'longitude'         => $location['long'],
            'should_be_published_in_telegram' => true,
            'caption'           => $notes['caption'],
            'status'            => Status::created,
            'status_info'       => [[
                'user' => $user->id,
                'status' => 'created',
                'datetime' => now()->format('Y-m-d H:s:i'),
            ]]
        ]);

        if (isset($notes['photos'])) {
            foreach ($notes['photos'] ?? [] as $photo) {
                $photoUrl = BotApi::getPhoto([
                    'file_id' => $photo
                ]);
        
                $client = new Client();
                $response = $client->get($photoUrl);
        
                $fileExtension = pathinfo($photoUrl, PATHINFO_EXTENSION);
                $fileName = uniqid() . '.' . $fileExtension;
        
                $filePath = "marketplace/announcements/{$announcement->created_at->format('Y')}/{$announcement->created_at->format('F')}/{$announcement->created_at->format('d')}/{$announcement->slug}/$fileName";
        
                Storage::put($filePath, $response->getBody()->getContents());
        
                $announcement->photos()->create([
                    'src' => $filePath,
                ]);
            }
        }

        if ($announcement) {
            $announcement->moderate();
        }
        
        return $this->bot->executeCommand(Published::$command);
    }

    private function validate()
    {

    }
}