<?php

namespace Database\Seeders;

use App\Models\Marketplace\MarketplaceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarketplaceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronic',
                'alternames' => [
                    'ru' => 'Электроника',
                    'en' => 'Electronic',
                    'cz' => 'Electronica'
                ],
                'subcategories' => [
                    [
                        'name' => 'Smartphones',
                        'alternames' => [
                            'ru' => 'Смартфоны',
                            'en' => 'Smartphones',
                            'cz' => 'Chytre Telefony'
                        ],
                        'subcategories' => [
                            [
                                'name' => 'Apple',
                                'alternames' => [
                                    'ru' => 'Apple',
                                    'en' => 'Apple',
                                    'cz' => 'Apple'
                                ],
                            ],
                            [
                                'name' => 'Accesoaries',
                                'alternames' => [
                                    'ru' => 'Аксессуары',
                                    'en' => 'Accesoaries',
                                    'cz' => 'Prislusenstvi'
                                ],
                            ],
                            
                        ]
                    ],
                    [
                        'name' => 'Notebooks',
                        'alternames' => [
                            'ru' => 'Ноутбуки',
                            'en' => 'Notebooks',
                            'cz' => 'Notebooky'
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Clothing',
                'alternames' => [
                    'ru' => 'Одежда',
                    'en' => 'Clothing',
                    'cz' => 'Oblečení'
                ],
                'subcategories' => [
                    [
                        'name' => 'T-Shirts',
                        'alternames' => [
                            'ru' => 'Футболки',
                            'en' => 'T-Shirts',
                            'cz' => 'Trička'
                        ],
                    ],
                    [
                        'name' => 'Dresses',
                        'alternames' => [
                            'ru' => 'Платья',
                            'en' => 'Dresses',
                            'cz' => 'Šaty'
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Home Appliances',
                'alternames' => [
                    'ru' => 'Бытовая Техника',
                    'en' => 'Home Appliances',
                    'cz' => 'Domácí Spotřebiče'
                ],
                'subcategories' => [
                    [
                        'name' => 'Refrigerators',
                        'alternames' => [
                            'ru' => 'Холодильники',
                            'en' => 'Refrigerators',
                            'cz' => 'Lednice'
                        ],
                    ],
                    [
                        'name' => 'Washing Machines',
                        'alternames' => [
                            'ru' => 'Стиральные Машины',
                            'en' => 'Washing Machines',
                            'cz' => 'Prací Stroje'
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Sports Gear',
                'alternames' => [
                    'ru' => 'Спортивные Товары',
                    'en' => 'Sports Gear',
                    'cz' => 'Sportovní Vybavení'
                ],
                'subcategories' => [
                    [
                        'name' => 'Running Shoes',
                        'alternames' => [
                            'ru' => 'Беговая Обувь',
                            'en' => 'Running Shoes',
                            'cz' => 'Běžecké Boty'
                        ],
                    ],
                    [
                        'name' => 'Yoga Mats',
                        'alternames' => [
                            'ru' => 'Коврики для Йоги',
                            'en' => 'Yoga Mats',
                            'cz' => 'Podložky na Jógu'
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Books',
                'alternames' => [
                    'ru' => 'Книги',
                    'en' => 'Books',
                    'cz' => 'Knihy'
                ],
                'subcategories' => [
                    [
                        'name' => 'Fiction',
                        'alternames' => [
                            'ru' => 'Художественная Литература',
                            'en' => 'Fiction',
                            'cz' => 'Beletrie'
                        ],
                    ],
                    [
                        'name' => 'Non-fiction',
                        'alternames' => [
                            'ru' => 'Научно-популярная Литература',
                            'en' => 'Non-fiction',
                            'cz' => 'Odborná Literatura'
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Furniture',
                'alternames' => [
                    'ru' => 'Мебель',
                    'en' => 'Furniture',
                    'cz' => 'Nábytek'
                ],
                'subcategories' => [
                    [
                        'name' => 'For home',
                        'alternames' => [
                            'ru' => 'Для дома',
                            'en' => 'For home',
                            'cz' => 'Pro dum'
                        ],
                        'subcategories' => [
                            [
                                'name' => 'Sofas',
                                'alternames' => [
                                    'ru' => 'Диваны',
                                    'en' => 'Sofas',
                                    'cz' => 'Pohovky'
                                ],
                            ],
                            [
                                'name' => 'Dining Tables',
                                'alternames' => [
                                    'ru' => 'Обеденные Столы',
                                    'en' => 'Dining Tables',
                                    'cz' => 'Jídelní Stoly'
                                ],
                            ],
                        ],
                    ],
                    [
                        'name' => 'For Garden',
                        'alternames' => [
                            'ru' => 'Для сада',
                            'en' => 'For Garden',
                            'cz' => 'Pro zahradu'
                        ],
                        'subcategories' => [
                            [
                                'name' => 'Sofas',
                                'alternames' => [
                                    'ru' => 'Диваны',
                                    'en' => 'Sofas',
                                    'cz' => 'Pohovky'
                                ],
                            ],
                            [
                                'name' => 'Dining Tables',
                                'alternames' => [
                                    'ru' => 'Обеденные Столы',
                                    'en' => 'Dining Tables',
                                    'cz' => 'Jídelní Stoly'
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Toys',
                'alternames' => [
                    'ru' => 'Игрушки',
                    'en' => 'Toys',
                    'cz' => 'Hračky'
                ],
                'subcategories' => [
                    [
                        'name' => 'Action Figures',
                        'alternames' => [
                            'ru' => 'Фигурки',
                            'en' => 'Action Figures',
                            'cz' => 'Akční Figurky'
                        ],
                    ],
                    [
                        'name' => 'Board Games',
                        'alternames' => [
                            'ru' => 'Настольные Игры',
                            'en' => 'Board Games',
                            'cz' => 'Stolní Hry'
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Beauty and Personal Care',
                'alternames' => [
                    'ru' => 'Красота и Уход за Собой',
                    'en' => 'Beauty and Personal Care',
                    'cz' => 'Krása a Péče o Sebe'
                ],
                'subcategories' => [
                    [
                        'name' => 'Skincare',
                        'alternames' => [
                            'ru' => 'Уход за Кожей',
                            'en' => 'Skincare',
                            'cz' => 'Ošetřování Pleti'
                        ],
                    ],
                    [
                        'name' => 'Haircare',
                        'alternames' => [
                            'ru' => 'Уход за Волосами',
                            'en' => 'Haircare',
                            'cz' => 'Ošetřování Vlasů'
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Kitchen Appliances',
                'alternames' => [
                    'ru' => 'Кухонные Приборы',
                    'en' => 'Kitchen Appliances',
                    'cz' => 'Kuchyňské Spotřebiče'
                ],
                'subcategories' => [
                    [
                        'name' => 'Blenders',
                        'alternames' => [
                            'ru' => 'Блендеры',
                            'en' => 'Blenders',
                            'cz' => 'Mixéry'
                        ],
                    ],
                    [
                        'name' => 'Coffee Makers',
                        'alternames' => [
                            'ru' => 'Кофеварки',
                            'en' => 'Coffee Makers',
                            'cz' => 'Kávovary'
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Gardening',
                'alternames' => [
                    'ru' => 'Садоводство',
                    'en' => 'Gardening',
                    'cz' => 'Zahradničení'
                ],
                'subcategories' => [
                    [
                        'name' => 'Garden Tools',
                        'alternames' => [
                            'ru' => 'Садовые Инструменты',
                            'en' => 'Garden Tools',
                            'cz' => 'Zahradní Nástroje'
                        ],
                    ],
                    [
                        'name' => 'Seeds and Plants',
                        'alternames' => [
                            'ru' => 'Семена и Растения',
                            'en' => 'Seeds and Plants',
                            'cz' => 'Semena a Rostliny'
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Fitness Equipment',
                'alternames' => [
                    'ru' => 'Фитнес Оборудование',
                    'en' => 'Fitness Equipment',
                    'cz' => 'Fitness Vybavení'
                ],
                'subcategories' => [
                    [
                        'name' => 'Dumbbells',
                        'alternames' => [
                            'ru' => 'Гантели',
                            'en' => 'Dumbbells',
                            'cz' => 'Činky'
                        ],
                    ],
                    [
                        'name' => 'Yoga Accessories',
                        'alternames' => [
                            'ru' => 'Аксессуары для Йоги',
                            'en' => 'Yoga Accessories',
                            'cz' => 'Příslušenství na Jógu'
                        ],
                    ],
                ],
            ],
        ];

        $this->seedCategories($categories);
    }
    
    private function seedCategories(array $categories, int $parentId = null)
    {
        foreach ($categories as $categoryData) {
            $category = MarketplaceCategory::create([
                'name' => $categoryData['name'],
                'alternames' => $categoryData['alternames'],
                'parent_id' => $parentId,
            ]);

            if (isset($categoryData['subcategories'])) {
                $this->seedCategories($categoryData['subcategories'], $category->id);
            }
        }
    }
}
