<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeOptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('attribute_options')->delete();
        
        \DB::table('attribute_options')->insert(array (
            0 => 
            array (
                'id' => 1,
                'attribute_id' => 3,
                'name' => 'Sale',
                'alternames' => '{"cz": "Prodej", "en": "Sale", "ru": "Продажа"}',
                'created_at' => '2024-04-23 10:47:22',
                'updated_at' => '2024-04-23 10:47:22',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'attribute_id' => 3,
                'name' => 'Rent',
                'alternames' => '{"cz": "Pronájem", "en": "Rent", "ru": "Аренда"}',
                'created_at' => '2024-04-23 10:47:22',
                'updated_at' => '2024-04-23 10:47:22',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'attribute_id' => 4,
                'name' => 'CZK',
                'alternames' => '[]',
                'created_at' => '2024-04-23 10:57:51',
                'updated_at' => '2024-04-23 10:57:51',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'attribute_id' => 4,
                'name' => 'USD',
                'alternames' => '[]',
                'created_at' => '2024-04-23 10:57:51',
                'updated_at' => '2024-04-23 10:57:51',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'attribute_id' => 4,
                'name' => 'EUR',
                'alternames' => '[]',
                'created_at' => '2024-04-23 10:57:51',
                'updated_at' => '2024-04-23 10:57:51',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'attribute_id' => 7,
                'name' => '4 GB and less',
                'alternames' => '{"cz": "4 GB a méně", "en": "4 GB and less", "ru": "4 GB и менее"}',
                'created_at' => '2024-04-23 11:40:03',
                'updated_at' => '2024-04-23 11:40:03',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'attribute_id' => 7,
                'name' => '8 GB',
                'alternames' => '[]',
                'created_at' => '2024-04-23 11:40:03',
                'updated_at' => '2024-04-23 11:40:03',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'attribute_id' => 7,
                'name' => '16 GB',
                'alternames' => '[]',
                'created_at' => '2024-04-23 11:40:03',
                'updated_at' => '2024-04-23 11:40:03',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'attribute_id' => 7,
                'name' => '18 GB',
                'alternames' => '[]',
                'created_at' => '2024-04-23 11:40:03',
                'updated_at' => '2024-04-23 11:40:03',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'attribute_id' => 7,
                'name' => '24 GB',
                'alternames' => '[]',
                'created_at' => '2024-04-23 11:40:03',
                'updated_at' => '2024-04-23 11:40:03',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'attribute_id' => 7,
                'name' => '32 GB',
                'alternames' => '[]',
                'created_at' => '2024-04-23 11:40:03',
                'updated_at' => '2024-04-23 11:40:03',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'attribute_id' => 7,
                'name' => '36 GB',
                'alternames' => '[]',
                'created_at' => '2024-04-23 11:40:03',
                'updated_at' => '2024-04-23 11:40:03',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'attribute_id' => 7,
                'name' => '48 GB',
                'alternames' => '[]',
                'created_at' => '2024-04-23 11:40:03',
                'updated_at' => '2024-04-23 11:40:03',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'attribute_id' => 7,
                'name' => '64 GB',
                'alternames' => '[]',
                'created_at' => '2024-04-23 11:40:03',
                'updated_at' => '2024-04-23 11:40:03',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'attribute_id' => 7,
                'name' => '96 GB',
                'alternames' => '[]',
                'created_at' => '2024-04-23 11:40:03',
                'updated_at' => '2024-04-23 11:40:03',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'attribute_id' => 7,
                'name' => '128',
                'alternames' => '[]',
                'created_at' => '2024-04-23 11:40:03',
                'updated_at' => '2024-04-23 11:40:03',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'attribute_id' => 9,
                'name' => 'OLED',
                'alternames' => '[]',
                'created_at' => '2024-04-23 12:07:21',
                'updated_at' => '2024-04-23 12:07:21',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'attribute_id' => 9,
                'name' => 'QLED',
                'alternames' => '[]',
                'created_at' => '2024-04-23 12:07:21',
                'updated_at' => '2024-04-23 12:07:21',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'attribute_id' => 9,
                'name' => 'IPS',
                'alternames' => '[]',
                'created_at' => '2024-04-23 12:07:21',
                'updated_at' => '2024-04-23 12:07:21',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'attribute_id' => 9,
                'name' => 'NanoCell',
                'alternames' => '[]',
                'created_at' => '2024-04-23 12:07:21',
                'updated_at' => '2024-04-23 12:07:21',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'attribute_id' => 12,
                'name' => 'LED',
                'alternames' => '[]',
                'created_at' => '2024-04-23 19:57:09',
                'updated_at' => '2024-04-23 19:57:09',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'attribute_id' => 12,
                'name' => 'OLED',
                'alternames' => '[]',
                'created_at' => '2024-04-23 19:57:09',
                'updated_at' => '2024-04-23 19:57:09',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'attribute_id' => 12,
                'name' => 'QLED',
                'alternames' => '[]',
                'created_at' => '2024-04-23 19:57:09',
                'updated_at' => '2024-04-23 19:57:09',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'attribute_id' => 12,
                'name' => 'NanoCell',
                'alternames' => '[]',
                'created_at' => '2024-04-23 19:57:09',
                'updated_at' => '2024-04-23 19:57:09',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'attribute_id' => 12,
                'name' => 'QNED',
                'alternames' => '[]',
                'created_at' => '2024-04-23 19:57:09',
                'updated_at' => '2024-04-23 19:57:09',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'attribute_id' => 12,
                'name' => 'Laser',
                'alternames' => '[]',
                'created_at' => '2024-04-23 19:57:09',
                'updated_at' => '2024-04-23 19:57:09',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}