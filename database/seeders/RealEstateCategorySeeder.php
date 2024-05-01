<?php

namespace Database\Seeders;

use App\Models\RealEstate\RealEstateCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RealEstateCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Flats',
                'alternames' => [
                    'ru' => 'Квартиры',
                    'en' => 'Flats',
                    'cz' => 'Byty'
                ],
                'configurations' => [
                    [
                        'name' => '1+KK',
                        'alternames' => [
                            'ru' => '1+KK',
                            'en' => '1+KK',
                            'cz' => '1+KK'
                        ],
                    ],
                    [
                        'name' => '2+KK',
                        'alternames' => [
                            'ru' => '2+KK',
                            'en' => '2+KK',
                            'cz' => '2+KK'
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Houses',
                'alternames' => [
                    'ru' => 'Дома',
                    'en' => 'Houses',
                    'cz' => 'Domy'
                ],
                'subcategories' => [
                    [
                        'name' => 'Vila',
                        'alternames' => [
                            'ru' => 'Вилла',
                            'en' => 'Vila',
                            'cz' => 'Vila'
                        ],
                    ],
                    [
                        'name' => 'Cottage',
                        'alternames' => [
                            'ru' => 'Коттедж',
                            'en' => 'Cottage',
                            'cz' => 'Сhalupa'
                        ],
                    ],
                ],
                'configurations' => [
                    [
                        'name' => '1+KK',
                        'alternames' => [
                            'ru' => '1+KK',
                            'en' => '1+KK',
                            'cz' => '1+KK'
                        ],
                    ],
                    [
                        'name' => '2+KK',
                        'alternames' => [
                            'ru' => '2+KK',
                            'en' => '2+KK',
                            'cz' => '2+KK'
                        ],
                    ],
                ],
            ],
            // Additional Categories
            [
                'name' => 'Apartments',
                'alternames' => [
                    'ru' => 'Апартаменты',
                    'en' => 'Apartments',
                    'cz' => 'Apartmány'
                ],
                'subcategories' => [
                    [
                        'name' => 'Studio',
                        'alternames' => [
                            'ru' => 'Студия',
                            'en' => 'Studio',
                            'cz' => 'Studio'
                        ],
                    ],
                ],
                'configurations' => [
                    [
                        'name' => '1 Bedroom',
                        'alternames' => [
                            'ru' => '1 спальня',
                            'en' => '1 Bedroom',
                            'cz' => '1 ložnice'
                        ],
                    ],
                    [
                        'name' => 'Duplex',
                        'alternames' => [
                            'ru' => 'Дуплекс',
                            'en' => 'Duplex',
                            'cz' => 'Duplex'
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Commercial',
                'alternames' => [
                    'ru' => 'Коммерческая недвижимость',
                    'en' => 'Commercial',
                    'cz' => 'Komerční nemovitosti'
                ],
                'subcategories' => [
                    [
                        'name' => 'Office Space',
                        'alternames' => [
                            'ru' => 'Офисное помещение',
                            'en' => 'Office Space',
                            'cz' => 'Kancelářský prostor'
                        ],
                    ],
                    [
                        'name' => 'Retail Store',
                        'alternames' => [
                            'ru' => 'Розничный магазин',
                            'en' => 'Retail Store',
                            'cz' => 'Maloprodejní obchod'
                        ],
                    ],
                    [
                        'name' => 'Warehouse',
                        'alternames' => [
                            'ru' => 'Склад',
                            'en' => 'Warehouse',
                            'cz' => 'Sklad'
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Land',
                'alternames' => [
                    'ru' => 'Земля',
                    'en' => 'Land',
                    'cz' => 'Pozemky'
                ],
                'subcategories' => [
                    [
                        'name' => 'Residential',
                        'alternames' => [
                            'ru' => 'Жилой',
                            'en' => 'Residential',
                            'cz' => 'Obytná'
                        ],
                    ],
                    [
                        'name' => 'Agricultural',
                        'alternames' => [
                            'ru' => 'Сельскохозяйственный',
                            'en' => 'Agricultural',
                            'cz' => 'Zemědělský'
                        ],
                    ],
                    [
                        'name' => 'Commercial',
                        'alternames' => [
                            'ru' => 'Коммерческий',
                            'en' => 'Commercial',
                            'cz' => 'Komerční'
                        ],
                    ],
                ],
            ],
        ];

        // foreach ($categories as $categoryData) {
        //     $category = RealEstateCategory::create([
        //         'name' => $categoryData['name'],
        //         'alternames' => $categoryData['alternames'],
        //     ]);

        //     foreach ($categoryData['subcategories'] ?? [] as $subcategoryData) {
        //         $category->subcategories()->create([
        //             'name' => $subcategoryData['name'],
        //             'alternames' => $subcategoryData['alternames'],
        //         ]);
        //     }

        //     foreach ($categoryData['configurations'] ?? [] as $configurationData) {
        //         $category->configurations()->create([
        //             'name' => $configurationData['name'],
        //             'alternames' => $configurationData['alternames'],
        //         ]);
        //     }
        // }

        $this->seedCategories($categories);
    }
    
    private function seedCategories(array $categories, int $parentId = null)
    {
        foreach ($categories as $categoryData) {
            $category = RealEstateCategory::create([
                'name' => $categoryData['name'],
                'alternames' => $categoryData['alternames'],
                'parent_id' => $parentId,
            ]);

            if (isset($categoryData['subcategories'])) {
                $this->seedCategories($categoryData['subcategories'], $category->id);
            }

            foreach ($categoryData['configurations'] ?? [] as $configurationData) {
                $category->configurations()->create([
                    'name' => $configurationData['name'],
                    'alternames' => $configurationData['alternames'],
                ]);
            }
        }
    }
}
