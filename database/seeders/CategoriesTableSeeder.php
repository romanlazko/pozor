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
                'alternames' => '{"cs": "Pronájem bytu", "en": "Rent a flat", "ru": "Аренда квартир"}',
                'slug' => 'arenda-kvartir',
                'is_active' => 1,
                'created_at' => '2024-05-30 18:23:16',
                'updated_at' => '2024-06-05 13:51:54',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'alternames' => '{"cs": "Prodej bytu", "en": "Sale flats", "ru": "Продажа квартир"}',
                'slug' => 'prodaza-kvartir',
                'is_active' => 1,
                'created_at' => '2024-05-31 08:58:27',
                'updated_at' => '2024-06-05 13:52:01',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}