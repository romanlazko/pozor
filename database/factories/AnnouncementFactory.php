<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Announcement;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        $dascription = $this->faker->paragraph;

        return [
            'user_id'           => 1,
            // 'title'             => $title,
            // 'translated_title'  => [
            //     'ru' => $title,
            //     'en' => $title,
            //     'cz' => $title,
            // ],
            // 'description'       => $dascription,
            // 'translated_description'             => json_encode([
            //     'ru' => $dascription,
            //     'en' => $dascription,
            //     'cz' => $dascription,
            // ]),
            // 'current_price'     => rand(1000, 1000000),
            // 'currency_id'       => 3,
        
            'should_be_published_in_telegram' => false,
            'status'            => Status::published,
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }

    public function configure(): static
    {
        $data = (object) [
            "categories" => [
                0 => "1",
                1 => "6",
            ],
            'attachments' => [
                'https://xiaomi-sib.ru/media/cache/thumb_540_600/media/product_variant_image/425//3c009b9b9ad97d260cb431daa056e4d66111cbeb.jpg',
                'https://mobikoff.com.ua/pub/media/magefan_blog/best-laptops.jpg',
                'https://virtual-sim.ru/wp-content/uploads/2021/03/Lenovo-ThinkPad-X1-Nano-5G.jpg',
            ]
        ];

        return $this->afterCreating(function (Announcement $announcement) use ($data) {
            $announcement->categories()->sync($data->categories);
            $announcement->features()->createMany($this->setFeatures($data->categories));

            // $announcement->addMediaFromUrl($data->attachments[rand(0,2)])->toMediaCollection('announcements', 's3');
        });
    }

    private function setFeatures($categories)
    {
        $features = [];
        
        $availableAttributes = Attribute::whereHas('categories', fn ($query) => $query->whereIn('category_id', $categories))->withCount('attribute_options')->get();

        foreach ($availableAttributes as $availableAttribute) {
            if ($availableAttribute->is_feature) {
                if ($availableAttribute->attribute_options_count) {
                    $features[] = [
                        'attribute_id' => $availableAttribute->id,
                        'attribute_option_id' => $availableAttribute->attribute_options()->inRandomOrder()->first()->id,
                    ];
                }
                else {
                    
                    if ($availableAttribute->create_type == 'text_input' AND $availableAttribute->search_type == 'between') {
                        $features[] = [
                            'attribute_id' => $availableAttribute->id,
                            'translated_value'        => [
                                'original' => rand(1000, 1000000),
                            ],
                        ];
                    }
                    else if ($availableAttribute->create_type == 'textarea') {
                        $value = $this->faker->paragraph;
                        $features[] = [
                            'attribute_id' => $availableAttribute->id,
                            'translated_value'        => [
                                'original' => $value,
                                'ru' => $value,
                                'en' => $value,
                                'cz' => $value,
                            ],
                        ];
                    }
                    else {
                        $value = $this->faker->sentence;
                        $features[] = [
                            'attribute_id' => $availableAttribute->id,
                            'translated_value'        => [
                                'original' => $value,
                                'ru' => $value,
                                'en' => $value,
                                'cz' => $value,
                            ],
                        ];
                    }
                    
                }
            }
        }

        return $features;
    }
}
