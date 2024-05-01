<?php

namespace Database\Seeders;

use App\Enums\RealEstate\Condition;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
                        'name' => 'Phones',
                        'alternames' => [
                            'ru' => 'Телефоны',
                            'en' => 'Phones',
                            'cz' => 'Telefony'
                        ],
                        'subcategories' => [
                            [
                                'name' => 'Phone',
                                'alternames' => [
                                    'ru' => 'Мобильные телефоны',
                                    'en' => 'Smartphones',
                                    'cz' => 'Chytre Telefony'
                                ],
                                'attributes' => [
                                    [
                                        'name'  => 'ram',
                                        'title'  => 'Ram',
                                        'type'  => 'select',
                                        'options'  => [
                                            '1 gb',
                                            '2 gb',
                                            '3 gb'
                                        ],
                                        'group_name'  => 'phone_memory',
                                    ],
                                    [
                                        'name'  => 'rom',
                                        'title'  => 'Rom',
                                        'type'  => 'select',
                                        'options'  => [
                                            '64 gb',
                                            '128 gb',
                                            '256 gb',
                                            '512 gb',
                                            '1024 gb',
                                        ],
                                        'group_name'  => 'phone_memory',
                                    ],
                                ]
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
                        'name' => 'Computers',
                        'alternames' => [
                            'ru' => 'Компьютеры',
                            'en' => 'Computers',
                            'cz' => 'Pocitace'
                        ],
                        'subcategories' => [
                            [
                                'name' => 'Notebooks',
                                'alternames' => [
                                    'ru' => 'Ноутбуки',
                                    'en' => 'Notebooks',
                                    'cz' => 'Notebooks'
                                ],
                                'attributes' => [
                                    [
                                        'name'  => 'display_diagonal',
                                        'title'  => 'Display diagonal',
                                        'type'  => 'select',
                                        'options'  => [
                                            '12',
                                            '13,3',
                                            '14'
                                        ],
                                        'group_name'  => 'notebooks_display',
                                    ],
                                    [
                                        'name'  => 'display_type',
                                        'title'  => 'Display type',
                                        'type'  => 'select',
                                        'options'  => [
                                            'OLED',
                                            'LED',
                                            'QLED',
                                            'Nanocell',
                                        ],
                                        'group_name'  => 'notebooks_display',
                                    ],
                                ],
                            ],
                            [
                                'name' => 'PC',
                                'alternames' => [
                                    'ru' => 'Персоальные компьютеры',
                                    'en' => 'PC',
                                    'cz' => 'PC'
                                ],
                            ]
                        ],
                        'attributes' => [
                            [
                                'name'  => 'ram',
                                'title'  => 'Ram',
                                'type'  => 'select',
                                'options'  => [
                                    '1 gb',
                                    '2 gb',
                                    '3 gb'
                                ],
                                'group_name'  => 'computers_memory',
                            ],
                            [
                                'name'  => 'rom',
                                'title'  => 'Rom',
                                'type'  => 'select',
                                'options'  => [
                                    '64 gb',
                                    '128 gb',
                                    '256 gb',
                                    '512 gb',
                                    '1024 gb',
                                ],
                                'group_name'  => 'computers_memory',
                            ],
                            [
                                'name'  => 'cpu',
                                'title'  => 'CPU',
                                'type'  => 'select',
                                'options'  => [
                                ],
                                'group_name'  => 'computers_cpu',
                            ],
                            [
                                'name'  => 'cpu_type',
                                'title'  => 'CPU type',
                                'type'  => 'select',
                                'options'  => [
                                ],
                                'group_name'  => 'computers_cpu',
                            ],
                        ]
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
            [
                'name' => 'Real Estate',
                'alternames' => [
                    'ru' => 'Недвижимость',
                    'en' => 'Real Estate',
                    'cz' => 'Reality'
                ],
                'subcategories' => [
                    [
                        'name' => 'Flats',
                        'alternames' => [
                            'ru' => 'Квартиры',
                            'en' => 'Flats',
                            'cz' => 'Byty'
                        ],
                        'attributes' => [
                            [
                                'name'  => 'building_construction',
                                'title'  => 'Building construction',
                                'type'  => 'select',
                                'options'  => [
                                    '1' => 'Wooden building',
                                    '2' => 'Brick',
                                    '3' => 'Stone building',
                                    '4' => 'Prefabricated building',
                                    '5' => 'Panel building'
                                ],
                                'group_name'  => 'building_information',
                            ],
                            [
                                'name'  => 'building_condition',
                                'title'  => 'Building condition',
                                'type'  => 'toggle_buttons',
                                'options'  => Condition::cases(),
                                'group_name'  => 'building_information',
                            ],
                            [
                                'name'  => 'building_count_of_flors',
                                'title'  => 'Building count of flors',
                                'type'  => 'text_input',
                                'options'  => null,
                                'group_name'  => 'building_information',
                            ],
                            [
                                'name'  => 'building_count_of_underground_flors',
                                'title'  => 'Building count of underground flors',
                                'type'  => 'text_input',
                                'options'  => null,
                                'group_name'  => 'building_information',
                            ],
                            [
                                'name'  => 'building_elevator',
                                'title'  => 'Building elevator',
                                'type'  => 'toggle',
                                'options'  => null,
                                'group_name'  => 'building_information',
                            ],
                            [
                                'name'  => 'building_hendicap',
                                'title'  => 'Building hendicap',
                                'type'  => 'toggle',
                                'options'  => null,
                                'group_name'  => 'building_information',
                            ],
                            [
                                'name'  => 'building_parking',
                                'title'  => 'Building parking',
                                'type'  => 'toggle',
                                'options'  => null,
                                'group_name'  => 'building_information',
                            ],
                            [
                                'name'  => 'building_storages',
                                'title'  => 'Building storages',
                                'type'  => 'toggle',
                                'options'  => null,
                                'group_name'  => 'building_information',
                            ],
                        ]
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
                ],
            ],
        ];

        $this->seedCategories($categories);
    }
    
    private function seedCategories(array $categories, int $parentId = null)
    {
        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'alternames' => $categoryData['alternames'],
                'parent_id' => $parentId,
            ]);

            if (isset($categoryData['subcategories'])) {
                $this->seedCategories($categoryData['subcategories'], $category->id);
            }

            if (isset($categoryData['attributes'])) {
                foreach ($categoryData['attributes'] as $attribute_item) {
                    $category->attributes()->create($attribute_item);
                }
            }
        }
    }
}
