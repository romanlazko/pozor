<?php

namespace Database\Factories\Marketplace;

use App\Enums\Currency;
use App\Enums\Marketplace\Condition;
use App\Enums\Marketplace\Type;
use App\Enums\Status;
use App\Models\Marketplace\MarketplaceAnnouncement;
use Igaster\LaravelCities\Geo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MarketplaceAnnouncementFactory extends Factory
{
    protected $model = MarketplaceAnnouncement::class;

    public function definition()
    {
        $location = $this->faker->randomElement([Geo::findName('prague')->toArray(), Geo::findName('brno')->toArray()]);
        return [
            'user_id' => 1,
            'telegram_chat_id' => 1,
            'slug' => $this->faker->slug,
            'title' => $this->faker->sentence,
            'caption' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(Type::cases()),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'currency' => $this->faker->randomElement(Currency::cases()),
            'category_id' => $this->faker->randomElement(['1', '2','3','4','5','6']), // Замените на конкретное значение, если у вас есть категории
            'subcategory_id' => $this->faker->randomElement(['1', '2','3','4','5','6']),
            'condition' => $this->faker->randomElement(Condition::cases()),
            'location' => $location,
            'latitude' => $location['lat'],
            'longitude' => $location['long'],
            'should_be_published_in_telegram' => true,
            'views' => 0,
            'status_info' => null,
            'status' => Status::published,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
