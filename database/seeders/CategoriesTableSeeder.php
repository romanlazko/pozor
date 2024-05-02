<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => NULL,
                'name' => 'Real estate',
                'alternames' => '{"cz": "Nemovitosti", "en": "Real estate", "ru": "Недвижимость"}',
                'slug' => 'nedvizimost',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 11:17:11',
                'updated_at' => '2024-04-25 12:33:09',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => NULL,
                'name' => 'Electronics',
                'alternames' => '{"cz": "Elektronika", "en": "Electronics", "ru": "Электроника"}',
                'slug' => 'electronics',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 11:40:59',
                'updated_at' => '2024-04-23 11:41:01',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'name' => 'Computers',
                'alternames' => '{"cz": "Počítače", "en": "Computers", "ru": "Компьютеры"}',
                'slug' => 'computers',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 11:41:37',
                'updated_at' => '2024-04-23 11:41:38',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 3,
                'name' => 'Notebooks',
                'alternames' => '{"cz": "Notebooky", "en": "Notebooks", "ru": "Ноутбуки"}',
                'slug' => 'notebooks',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 12:09:26',
                'updated_at' => '2024-04-23 12:09:27',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'name' => 'Phones',
                'alternames' => '{"cz": "Telefony", "en": "Phones", "ru": "Телефоны"}',
                'slug' => 'phones',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 14:34:44',
                'updated_at' => '2024-04-23 14:34:45',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 1,
                'name' => 'Flats',
                'alternames' => '{"cz": "Byty", "en": "Flats", "ru": "Квартиры"}',
                'slug' => 'flats',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 19:04:44',
                'updated_at' => '2024-04-23 19:04:45',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => NULL,
                'name' => 'Vehicles',
                'alternames' => '{"cz": "Vozidla", "en": "Vehicles", "ru": "Транспортные средства"}',
                'slug' => 'transportnye-sredstva',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 19:06:57',
                'updated_at' => '2024-04-23 19:33:30',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 7,
                'name' => 'Cars',
                'alternames' => '{"cz": "Auta", "en": "Cars", "ru": "Автомобили"}',
                'slug' => 'cars',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 19:07:42',
                'updated_at' => '2024-04-23 19:07:53',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 7,
                'name' => 'Boats',
                'alternames' => '{"cz": "Lodě", "en": "Boats", "ru": "Лодки"}',
                'slug' => 'boats',
                'icon_name' => NULL,
                'is_active' => 0,
                'created_at' => '2024-04-23 19:08:29',
                'updated_at' => '2024-04-23 19:12:13',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 7,
                'name' => 'Trucks and special-purpose vehicles',
                'alternames' => '{"cz": "Nákladní a speciální vozidla", "en": "Trucks and special-purpose vehicles", "ru": "Грузовики и спец техника"}',
                'slug' => 'trucks-and-special-purpose-vehicles',
                'icon_name' => NULL,
                'is_active' => 0,
                'created_at' => '2024-04-23 19:10:09',
                'updated_at' => '2024-04-23 19:12:12',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 7,
                'name' => 'Motorcycles and motorized vehicles',
                'alternames' => '{"cz": "Motorky a motocykly", "en": "Motorcycles and motorized vehicles", "ru": "Мотоциклы и мототехника"}',
                'slug' => 'motorcycles-and-motorized-vehicles',
                'icon_name' => NULL,
                'is_active' => 0,
                'created_at' => '2024-04-23 19:14:16',
                'updated_at' => '2024-04-23 19:14:16',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 2,
                'name' => 'Household appliances',
                'alternames' => '{"cz": "Domácí spotřebiče", "en": "Household appliances", "ru": "Бытовая техника"}',
                'slug' => 'bytovaia-texnika',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 19:47:01',
                'updated_at' => '2024-04-23 19:47:04',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 12,
                'name' => 'Refrigerators',
                'alternames' => '{"cz": "Ledničky", "en": "Refrigerators", "ru": "Холодильники"}',
                'slug' => 'xolodilniki',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 19:47:51',
                'updated_at' => '2024-04-23 19:47:52',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 12,
                'name' => 'Kitchen stoves',
                'alternames' => '{"cz": "Kuchyňské varné desky", "en": "Kitchen stoves", "ru": "Кухонные плиты"}',
                'slug' => 'kuxonnye-plity',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 19:48:31',
                'updated_at' => '2024-04-23 19:50:22',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 12,
                'name' => 'Microwaves',
                'alternames' => '{"cz": "Mikrovlnné trouby", "en": "Microwaves", "ru": "Микроволновки"}',
                'slug' => 'mikrovolnovki',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 19:49:38',
                'updated_at' => '2024-04-23 19:50:21',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 12,
                'name' => 'Dishwashing machines',
                'alternames' => '{"cz": "Myčky na nádobí", "en": "Dishwashing machines", "ru": "Посудомоечные машины"}',
                'slug' => 'posudomoecnye-masiny',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 19:50:19',
                'updated_at' => '2024-04-23 19:50:21',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => 2,
                'name' => 'Телевизоры',
                'alternames' => '{"cz": "Televize", "en": "TVs", "ru": "Телевизоры"}',
                'slug' => 'televizory',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 19:52:26',
                'updated_at' => '2024-04-23 19:57:36',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => NULL,
                'name' => 'Одежда, обувь, аксессуары',
                'alternames' => '{"cz": "Oblečení, boty, doplňky", "en": "Clothes, shoes, accessories", "ru": "Одежда, обувь, аксессуары"}',
                'slug' => 'odezda-obuv-aksessuary',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 20:02:36',
                'updated_at' => '2024-04-23 20:02:57',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'parent_id' => NULL,
                'name' => 'Job',
                'alternames' => '{"cz": "Práce", "en": "Job", "ru": "Работа"}',
                'slug' => 'rabota',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 20:04:09',
                'updated_at' => '2024-04-23 20:04:15',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'parent_id' => NULL,
                'name' => 'Animals',
                'alternames' => '{"cz": "Zvířata", "en": "Animals", "ru": "Животные"}',
                'slug' => 'zivotnye',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 20:04:43',
                'updated_at' => '2024-04-23 20:06:37',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'parent_id' => NULL,
                'name' => 'Furniture',
                'alternames' => '{"cz": "Nábytek", "en": "Furniture", "ru": "Мебель"}',
                'slug' => 'mebel',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 20:05:23',
                'updated_at' => '2024-04-23 20:06:38',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'parent_id' => NULL,
                'name' => 'For children',
                'alternames' => '{"cz": "Pro děti", "en": "For children", "ru": "Для детей"}',
                'slug' => 'dlia-detei',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 20:05:52',
                'updated_at' => '2024-04-23 20:06:39',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'parent_id' => NULL,
                'name' => 'Beauty and personal care',
                'alternames' => '{"cz": "Krása a péče", "en": "Beauty and personal care", "ru": "Красота и уход за собой"}',
                'slug' => 'krasota-i-uxod-za-soboi',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 20:06:35',
                'updated_at' => '2024-04-23 20:06:40',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'parent_id' => NULL,
                'name' => 'Sport',
                'alternames' => '{"cz": "Sport", "en": "Sport", "ru": "Спорт"}',
                'slug' => 'sport',
                'icon_name' => NULL,
                'is_active' => 1,
                'created_at' => '2024-04-23 20:07:18',
                'updated_at' => '2024-04-23 20:07:20',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}