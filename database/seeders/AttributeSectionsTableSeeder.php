<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeSectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('attribute_sections')->delete();
        
        \DB::table('attribute_sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Prices',
                'slug' => 'prices',
                'alternames' => '{"cz": "Ceník", "en": "Prices", "ru": "Цены"}',
                'order_number' => 3,
                'created_at' => '2024-04-23 10:41:01',
                'updated_at' => '2024-04-23 12:03:12',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Type',
                'slug' => 'real_estate_type',
                'alternames' => '{"cz": "Typ", "en": "Type", "ru": "Тип"}',
                'order_number' => 1,
                'created_at' => '2024-04-23 10:47:04',
                'updated_at' => '2024-04-23 10:47:04',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Required information',
                'slug' => 'required_information',
                'alternames' => '{"cz": "Potřebné informace", "en": "Required information", "ru": "Обязательная информация"}',
                'order_number' => 1,
                'created_at' => '2024-04-23 11:14:00',
                'updated_at' => '2024-04-23 11:14:00',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Memory',
                'slug' => 'pc_memory',
                'alternames' => '{"cz": "Paměť", "en": "Memory", "ru": "Память"}',
                'order_number' => 3,
                'created_at' => '2024-04-23 11:39:44',
                'updated_at' => '2024-04-23 11:39:44',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Location',
                'slug' => 'location',
                'alternames' => '{"cz": "Lokalita", "en": "Location", "ru": "Месторасположение"}',
                'order_number' => 2,
                'created_at' => '2024-04-23 12:01:44',
                'updated_at' => '2024-04-23 12:02:56',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Display',
                'slug' => 'notebooks_display',
                'alternames' => '{"cz": "Obrazovka", "en": "Display", "ru": "Экран"}',
                'order_number' => 4,
                'created_at' => '2024-04-23 12:07:05',
                'updated_at' => '2024-04-23 12:07:05',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Display',
                'slug' => 'tv_display',
                'alternames' => '{"cz": "Obrazovka", "en": "Display", "ru": "Дисплей"}',
                'order_number' => 4,
                'created_at' => '2024-04-23 19:56:51',
                'updated_at' => '2024-04-23 19:56:51',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}