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
                'alternames' => '{"cs": "Nemovitosti", "en": "Real estate", "ru": "Недвижимость"}',
                'slug' => 'nemovitosti',
                'is_active' => 1,
                'created_at' => '2024-05-21 16:56:35',
                'updated_at' => '2024-06-04 09:04:18',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 1,
                'alternames' => '{"cs": "Byty", "en": "Flats", "ru": "Квартиры"}',
                'slug' => 'kvartiry',
                'is_active' => 1,
                'created_at' => '2024-05-21 18:31:31',
                'updated_at' => '2024-06-05 13:51:44',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => NULL,
                'alternames' => '{"cs": "Práce ", "en": "Job", "ru": "Вакансии"}',
                'slug' => 'prace',
                'is_active' => 1,
                'created_at' => '2024-05-22 17:30:46',
                'updated_at' => '2024-06-04 09:04:26',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => NULL,
                'alternames' => '{"cs": "Electronika", "en": "Electronic", "ru": "Электроника"}',
                'slug' => 'electronika',
                'is_active' => 1,
                'created_at' => '2024-05-23 18:32:31',
                'updated_at' => '2024-06-04 09:04:32',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 4,
                'alternames' => '{"cs": "Mobilni telefony", "en": "Phone", "ru": "Телефоны"}',
                'slug' => 'mobilni-telefony',
                'is_active' => 1,
                'created_at' => '2024-05-23 18:39:55',
                'updated_at' => '2024-06-04 09:04:58',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'alternames' => '{"cs": "Dlouhodobý pronájem", "en": "Long-term rent", "ru": "Долгосрочная аренда"}',
                'slug' => 'dolgosrocnaia-arenda',
                'is_active' => 1,
                'created_at' => '2024-05-30 18:23:16',
                'updated_at' => '2024-07-14 14:21:50',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'alternames' => '{"cs": "Prodej bytu", "en": "Sale flats", "ru": "Продажа"}',
                'slug' => 'prodaza',
                'is_active' => 1,
                'created_at' => '2024-05-31 08:58:27',
                'updated_at' => '2024-07-14 14:22:04',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 2,
                'alternames' => '{"cz": "Pronájem pokoje", "en": "Rent room", "ru": "Аренда комнаты"}',
                'slug' => 'arenda-komnaty',
                'is_active' => 1,
                'created_at' => '2024-07-14 10:27:05',
                'updated_at' => '2024-07-15 11:09:13',
                'deleted_at' => '2024-07-15 11:09:13',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => NULL,
                'alternames' => '{"cs": "Vozidla", "en": "Vehicles", "ru": "Транспорт"}',
                'slug' => 'transport',
                'is_active' => 1,
                'created_at' => '2024-07-14 11:42:40',
                'updated_at' => '2024-07-14 12:38:33',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => NULL,
                'alternames' => '{"cs": "Dům a zahrada", "en": "House and garden", "ru": "Для дома и дачи"}',
                'slug' => 'dlia-doma-i-daci',
                'is_active' => 1,
                'created_at' => '2024-07-14 11:47:49',
                'updated_at' => '2024-07-14 12:39:02',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => NULL,
                'alternames' => '{"cs": "Oblečení a obuv", "en": "Clothes and shoes", "ru": "Одежда и обувь"}',
                'slug' => 'odezda-i-obuv',
                'is_active' => 1,
                'created_at' => '2024-07-14 12:08:07',
                'updated_at' => '2024-07-14 12:39:53',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => NULL,
                'alternames' => '{"cs": "Služby", "en": "Services", "ru": "Услуги"}',
                'slug' => 'uslugi',
                'is_active' => 1,
                'created_at' => '2024-07-14 12:13:47',
                'updated_at' => '2024-07-14 12:39:45',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => NULL,
                'alternames' => '{"cs": "Krása a zdraví", "en": "Beauty and health", "ru": "Красота и здоровье"}',
                'slug' => 'krasota-i-zdorove',
                'is_active' => 1,
                'created_at' => '2024-07-14 12:16:04',
                'updated_at' => '2024-07-14 12:39:59',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => NULL,
                'alternames' => '{"cs": "Koníčky a rekreace", "en": "Hobbies and recreation", "ru": "Хобби и отдых"}',
                'slug' => 'xobbi-i-otdyx',
                'is_active' => 1,
                'created_at' => '2024-07-14 12:37:14',
                'updated_at' => '2024-07-14 12:40:05',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => NULL,
                'alternames' => '{"cs": "Zvířata", "en": "Animals", "ru": "Животные"}',
                'slug' => 'animals',
                'is_active' => 1,
                'created_at' => '2024-07-14 12:58:50',
                'updated_at' => '2024-07-14 12:58:53',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => NULL,
                'alternames' => '{"cs": "Cestování", "en": "Travel", "ru": "Путешествия"}',
                'slug' => 'travel',
                'is_active' => 1,
                'created_at' => '2024-07-14 13:03:04',
                'updated_at' => '2024-07-14 13:03:12',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => NULL,
                'alternames' => '{"cs": "Pro děti", "en": "For children", "ru": "Для детей"}',
                'slug' => 'for-children',
                'is_active' => 1,
                'created_at' => '2024-07-14 13:04:41',
                'updated_at' => '2024-07-14 13:04:44',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => 1,
                'alternames' => '{"cs": "Dům, chata, chalupa, městský dům", "en": "House, cottage, cottage, townhouse", "ru": "Дом, дача, коттедж, таунхаус"}',
                'slug' => 'dom-daca-kottedz-taunxaus',
                'is_active' => 1,
                'created_at' => '2024-07-14 13:07:57',
                'updated_at' => '2024-07-15 12:00:43',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'parent_id' => 1,
                'alternames' => '{"cs": "Pokoje", "en": "Rooms", "ru": "Комнаты"}',
                'slug' => 'komnaty',
                'is_active' => 1,
                'created_at' => '2024-07-14 13:31:52',
                'updated_at' => '2024-07-14 13:31:54',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'parent_id' => 1,
                'alternames' => '{"cs": "Garáž a parkoviště", "en": "Garage and parking", "ru": "Гараж и парковка"}',
                'slug' => 'garaz-i-parkovka',
                'is_active' => 1,
                'created_at' => '2024-07-14 13:34:30',
                'updated_at' => '2024-07-14 13:34:31',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'parent_id' => 1,
                'alternames' => '{"cs": "Komerční nemovitosti", "en": "Commercial", "ru": "Коммерческая недвижимость"}',
                'slug' => 'kommerceskaia-nedvizimost',
                'is_active' => 1,
                'created_at' => '2024-07-14 13:37:02',
                'updated_at' => '2024-07-14 13:37:09',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'parent_id' => 1,
                'alternames' => '{"cs": "Pozemek", "en": "Land plot", "ru": "Земельный участок"}',
                'slug' => 'zemelnyi-ucastok',
                'is_active' => 1,
                'created_at' => '2024-07-14 13:45:14',
                'updated_at' => '2024-07-14 13:45:18',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'parent_id' => 4,
                'alternames' => '{"cs": "Tablety", "en": "Tablets", "ru": "Планшеты"}',
                'slug' => 'plansety',
                'is_active' => 1,
                'created_at' => '2024-07-14 14:02:22',
                'updated_at' => '2024-07-14 14:02:29',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'parent_id' => 4,
                'alternames' => '{"cs": "Stolní počítače", "en": "Desktop computers", "ru": "Настольные компьютеры"}',
                'slug' => 'nastolnye-kompiutery',
                'is_active' => 1,
                'created_at' => '2024-07-14 14:03:32',
                'updated_at' => '2024-07-14 14:09:37',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'parent_id' => 4,
                'alternames' => '{"cs": "Domácí spotřebiče", "en": "Household appliances", "ru": "Бытовая техника"}',
                'slug' => 'bytovaia-texnika',
                'is_active' => 1,
                'created_at' => '2024-07-14 14:04:11',
                'updated_at' => '2024-07-14 14:04:13',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'parent_id' => 4,
                'alternames' => '{"cs": "Notebooky", "en": "Laptops", "ru": "Ноутбуки"}',
                'slug' => 'noutbuki',
                'is_active' => 1,
                'created_at' => '2024-07-14 14:11:22',
                'updated_at' => '2024-07-14 14:11:24',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'parent_id' => 2,
                'alternames' => '{"cs": "Krátkodobé pronájmy", "en": "Short-term rent", "ru": "Краткосрочная аренда"}',
                'slug' => 'kratkosrocnaia-arenda',
                'is_active' => 1,
                'created_at' => '2024-07-14 14:27:44',
                'updated_at' => '2024-07-14 14:27:47',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'parent_id' => 18,
                'alternames' => '{"cs": "Dlouhodobý pronájem", "en": "Long-term rent", "ru": "Долгосрочная аренда"}',
                'slug' => 'dolgosrocnaia-arenda-1',
                'is_active' => 1,
                'created_at' => '2024-07-15 12:05:04',
                'updated_at' => '2024-07-15 12:05:06',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'parent_id' => 18,
                'alternames' => '{"cs": "Krátkodobé pronájmy", "en": "Short-term rent", "ru": "Краткосрочная аренда"}',
                'slug' => 'kratkosrocnaia-arenda-1',
                'is_active' => 1,
                'created_at' => '2024-07-15 12:05:54',
                'updated_at' => '2024-07-15 12:05:57',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'parent_id' => 18,
                'alternames' => '{"cs": "Prodej", "en": "For Sale", "ru": "Продажа"}',
                'slug' => 'prodaza-1',
                'is_active' => 1,
                'created_at' => '2024-07-15 12:06:42',
                'updated_at' => '2024-07-15 12:06:43',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}