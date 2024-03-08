<?php

namespace Database\Factories\RealEstate;

use App\Enums\Currency;
use App\Enums\RealEstate\AdditionalSpace;
use App\Enums\RealEstate\Condition;
use App\Enums\RealEstate\Equipment;
use App\Enums\RealEstate\Type;
use App\Enums\Status;
use Igaster\LaravelCities\Geo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RealEstate\RealEstateAnnouncement>
 */
class RealEstateAnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $location = $this->faker->randomElement([Geo::findName('prague')->toArray(), Geo::findName('brno')->toArray()]);
        return [
            'user_id' => 1,
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(Type::cases()),
            'category_id' => $this->faker->numberBetween(1, 3),
            'subcategory_id' => $this->faker->numberBetween(1, 3),
            'configuration_id' => $this->faker->numberBetween(1, 3),
            'condition' => $this->faker->randomElement(Condition::cases()),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'price_currency' => $this->faker->randomElement(Currency::cases()),
            'deposit' => $this->faker->randomFloat(2, 50, 500),
            'deposit_currency' => $this->faker->randomElement(Currency::cases()),
            'utilities' => $this->faker->randomFloat(2, 20, 200),
            'utilities_currency' => $this->faker->randomElement(Currency::cases()),
            'square_meters' => $this->faker->numberBetween(50, 200),
            'check_in_date' => $this->faker->date,
            'additional_spaces' => [$this->faker->randomElement(AdditionalSpace::cases()),$this->faker->randomElement(AdditionalSpace::cases()), $this->faker->randomElement(AdditionalSpace::cases()),],
            'equipment' => $this->faker->randomElement(Equipment::cases()),
            'floor' => $this->faker->numberBetween(1, 10),
            'location' => $location,
            'latitude' => $location['lat'],
            'longitude' => $location['long'],
            'address' => $this->faker->address,
            'views' => $this->faker->numberBetween(0, 1000),
            'status_info' => json_encode(['info' => 'some status info']),
            'status' => Status::published,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
