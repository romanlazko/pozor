<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Announcement;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Geo;
use App\Models\TelegramChat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
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
        return [
            'user_id'           => 1,
            'geo_id'            => Geo::inRandomOrder()->first()->id,
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Announcement $announcement) {
            $announcement->features()->createMany($this->getFeatures($announcement->categories->pluck('id')->toArray()));
            $announcement->channels()->createMany($this->getChannels($announcement));
            $announcement->addMediaFromUrl(fake()->imageUrl(100, 100, $announcement->slug))->toMediaCollection('announcements', 's3');
            $announcement->publish();
        });
    }

    private function getFeatures(array $categories) : array
    {
        $type_options = [
            'fields_with_options' => [
                'select' => 'SELECT (выбор одного элемента из списка)',
                'multiple_select' => 'MULTIPLE SELECT (выбор нескольких элементов из списка)',
                'toggle_buttons' => 'TOGGLE BUTTONS (выбор переключателей)',
                'checkbox_list'   => 'CHECKBOX LIST (список чекбоксов)',
                'price' => 'PRICE (цена)',
            ],
            'text_fields' => [
                'text_input' => 'Текстовое поле',
                'text_area' => 'Текстовый блок',
                'between'   => 'Между',
                'from_to'   => 'From-To',
                'markdown_editor' => 'Markdown Editor',
            ],
            'other' => [
                'location'  => 'Местоположение',
                'hidden'    => 'Скрытое поле',
            ],
            'date' => [
                'date' => 'Date',
                'date_time' => 'Date Time',
                'month_year' => 'Month Year',
            ]
        ];

        return Attribute::whereHas('categories', fn ($query) => $query->whereIn('category_id', $categories))
            ->get()
            ->map(function ($attribute) use ($type_options) {
                if ($attribute->create_layout['type'] == 'from_to') {
                    return [
                        'attribute_id' => $attribute->id,
                        'translated_value' => [
                            'original' => [
                                'from' => fake()->numberBetween(100, 500),
                                'to' => fake()->numberBetween(500, 1000),
                            ],
                        ],
                    ];
                }

                if (in_array($attribute->create_layout['type'], array_keys($type_options['text_fields']))) {
                    return [
                        'attribute_id' => $attribute->id,
                        'translated_value' => [
                            'original' => match (($attribute->create_layout['rules'] ?? null)? $attribute->create_layout['rules'][0]:null) {
                                'numeric' => fake()->numberBetween(0, 100),
                                default => fake()->sentence(12),
                            },
                        ]
                    ];
                }

                if ($attribute->create_layout['type'] == 'price') {
                    return [
                        'attribute_id' => $attribute->id,
                        'translated_value' => [
                            'original' => fake()->numberBetween(0, 100000),
                        ],
                        'attribute_option_id' => $attribute->attribute_options->where('is_null', '!=' ,true)->random()->id,
                    ];
                }

                if (in_array($attribute->create_layout['type'], array_keys($type_options['fields_with_options']))) {
                    return [
                        'attribute_id' => $attribute->id,
                        'attribute_option_id' => $attribute->attribute_options->where('is_null', '!=' ,true)->random()->id,
                    ];
                }

                if (in_array($attribute->create_layout['type'], array_keys($type_options['date']))) {
                    return [
                        'attribute_id' => $attribute->id,
                        'translated_value' => [
                            'original' => fake()->date(),
                        ],
                    ];
                }
            })
            ->filter()
            ->all();
    }

    private function getChannels($announcement) : array
    {
        $categoryChannelIds = $announcement->categories->pluck('channels')->flatten()->pluck('id');

        $locationChannels = TelegramChat::whereIn('id', $categoryChannelIds)
            ->whereHas('geo', fn ($query) => $query->radius($announcement->geo->latitude, $announcement->geo->longitude, 30))
            ->get();

        if ($locationChannels->isEmpty()) {
            $locationChannels = TelegramChat::whereIn('id', $categoryChannelIds)->get();
        }

        return $locationChannels->map(fn ($channel) => ['telegram_chat_id' => $channel->id])->all();
    }
}
