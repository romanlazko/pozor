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
                'alternames' => '{"cz": null, "en": "CZK", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 17:37:31',
                'updated_at' => '2024-05-21 18:33:20',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'attribute_id' => 3,
                'alternames' => '{"cz": null, "en": "EUR", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 17:37:31',
                'updated_at' => '2024-05-21 18:33:20',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'attribute_id' => 3,
                'alternames' => '{"cz": null, "en": "USD", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 17:37:31',
                'updated_at' => '2024-05-21 18:33:20',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'attribute_id' => 7,
                'alternames' => '{"cz": "Prodej", "en": "Sale", "ru": "Продажа"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 17:49:37',
                'updated_at' => '2024-07-26 16:37:59',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'attribute_id' => 7,
                'alternames' => '{"cz": "Dlouhodobý pronájem", "en": "Long-term rent", "ru": "Долгосрочная аренда"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 17:49:37',
                'updated_at' => '2024-07-26 16:37:59',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'attribute_id' => 8,
                'alternames' => '{"cz": "1+KK", "en": "1+KK", "ru": "1+KK"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:31:00',
                'updated_at' => '2024-05-21 18:31:00',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'attribute_id' => 8,
                'alternames' => '{"cz": "2+KK", "en": "2+KK", "ru": "2+KK"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:31:00',
                'updated_at' => '2024-05-21 18:31:00',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'attribute_id' => 8,
                'alternames' => '{"cz": "3+KK", "en": "3+KK", "ru": "3+KK"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:31:00',
                'updated_at' => '2024-05-21 18:31:00',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'attribute_id' => 9,
                'alternames' => '{"cs": "Cihlová", "en": "Brick", "ru": "Кирпичная"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:41:59',
                'updated_at' => '2024-07-28 10:09:55',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'attribute_id' => 9,
                'alternames' => '{"cs": "Dřevostavba", "en": "Wooden", "ru": "Деревянная"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:41:59',
                'updated_at' => '2024-07-28 10:09:55',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'attribute_id' => 9,
                'alternames' => '{"cs": "Kamenná", "en": "Stone", "ru": "Каменная"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:41:59',
                'updated_at' => '2024-07-28 10:09:55',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'attribute_id' => 9,
                'alternames' => '{"cs": "Modulární", "en": "Modular", "ru": "Модульная"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:41:59',
                'updated_at' => '2024-07-28 10:09:55',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'attribute_id' => 9,
                'alternames' => '{"cs": "Panelová", "en": "Panel", "ru": "Панельная"}',
                'is_default' => 1,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:41:59',
                'updated_at' => '2024-07-28 10:09:55',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'attribute_id' => 10,
                'alternames' => '{"cs": "Velmi dobrý", "en": "Very good", "ru": "Очень хорошее"}',
                'is_default' => 1,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:45:41',
                'updated_at' => '2024-06-05 16:04:09',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'attribute_id' => 10,
                'alternames' => '{"cs": "Dobrý", "en": "Good", "ru": "Хорошее"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:45:41',
                'updated_at' => '2024-06-05 16:04:09',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'attribute_id' => 10,
                'alternames' => '{"cs": "Novostavba", "en": "New building", "ru": "Новостройка"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:45:41',
                'updated_at' => '2024-06-05 16:04:09',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'attribute_id' => 13,
                'alternames' => '{"cz": "Ano", "en": "Yes", "ru": "Да"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:50:35',
                'updated_at' => '2024-05-25 11:36:02',
                'deleted_at' => '2024-05-25 11:36:02',
            ),
            17 => 
            array (
                'id' => 18,
                'attribute_id' => 13,
                'alternames' => '{"cz": "Ne", "en": "No", "ru": "Нет"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:50:35',
                'updated_at' => '2024-05-25 11:36:02',
                'deleted_at' => '2024-05-25 11:36:02',
            ),
            18 => 
            array (
                'id' => 19,
                'attribute_id' => 14,
                'alternames' => '{"cz": "Ano", "en": "Yes", "ru": "Да"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:51:39',
                'updated_at' => '2024-05-25 11:41:02',
                'deleted_at' => '2024-05-25 11:41:02',
            ),
            19 => 
            array (
                'id' => 20,
                'attribute_id' => 14,
                'alternames' => '{"cz": "Ne", "en": "No", "ru": "Нет"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:51:40',
                'updated_at' => '2024-05-25 11:41:02',
                'deleted_at' => '2024-05-25 11:41:02',
            ),
            20 => 
            array (
                'id' => 21,
                'attribute_id' => 15,
                'alternames' => '{"cz": "Ano", "en": "Yes", "ru": "Да"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:53:35',
                'updated_at' => '2024-05-25 11:36:14',
                'deleted_at' => '2024-05-25 11:36:14',
            ),
            21 => 
            array (
                'id' => 22,
                'attribute_id' => 15,
                'alternames' => '{"cz": "Ne", "en": "No", "ru": "Нет"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-21 18:53:35',
                'updated_at' => '2024-05-25 11:36:14',
                'deleted_at' => '2024-05-25 11:36:14',
            ),
            22 => 
            array (
                'id' => 23,
                'attribute_id' => 17,
                'alternames' => '{"cz": "1 SIM karta", "en": "1 SIM card", "ru": "1 сим карта"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-23 18:48:58',
                'updated_at' => '2024-05-23 18:48:58',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'attribute_id' => 17,
                'alternames' => '{"cz": "2 SIM karty", "en": "2 SIM card", "ru": "2 сим карты"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-23 18:48:58',
                'updated_at' => '2024-05-23 18:48:58',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'attribute_id' => 19,
                'alternames' => '{"cz": null, "en": "CZK", "ru": null}',
                'is_default' => 1,
                'is_null' => 0,
                'created_at' => '2024-05-24 09:50:31',
                'updated_at' => '2024-05-26 14:42:26',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'attribute_id' => 19,
                'alternames' => '{"cz": null, "en": "EUR", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-24 09:50:31',
                'updated_at' => '2024-05-26 14:42:26',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'attribute_id' => 19,
                'alternames' => '{"cz": null, "en": "USD", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-24 09:50:31',
                'updated_at' => '2024-05-26 14:42:26',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'attribute_id' => 21,
                'alternames' => '{"cz": "Za měsíc", "en": "Per month", "ru": "За месяц"}',
                'is_default' => 1,
                'is_null' => 0,
                'created_at' => '2024-05-24 16:48:19',
                'updated_at' => '2024-05-26 14:42:43',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'attribute_id' => 21,
                'alternames' => '{"cz": "Za den", "en": "Per day", "ru": "За день"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-24 16:48:19',
                'updated_at' => '2024-05-26 14:42:43',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'attribute_id' => 21,
                'alternames' => '{"cz": "Za hodinu", "en": "Per hour", "ru": "За час"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-24 16:48:19',
                'updated_at' => '2024-05-26 14:42:43',
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'attribute_id' => 21,
                'alternames' => '{"cz": "Za provedenou práci", "en": "For work performed", "ru": "За выполненную работу"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-24 16:48:19',
                'updated_at' => '2024-05-26 14:42:43',
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'attribute_id' => 22,
                'alternames' => '{"cz": "1 GB nebo méně", "en": "1 GB and less", "ru": "1 GB и менее"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 14:58:39',
                'updated_at' => '2024-05-25 14:58:39',
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'attribute_id' => 22,
                'alternames' => '{"cz": null, "en": "2 GB", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 14:58:39',
                'updated_at' => '2024-05-25 14:58:39',
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'attribute_id' => 22,
                'alternames' => '{"cz": null, "en": "3 GB", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 14:58:39',
                'updated_at' => '2024-05-25 14:58:39',
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'attribute_id' => 22,
                'alternames' => '{"cz": null, "en": "4 GB", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 14:58:39',
                'updated_at' => '2024-05-25 14:58:39',
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'attribute_id' => 22,
                'alternames' => '{"cz": null, "en": "6 GB", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 14:58:39',
                'updated_at' => '2024-05-25 14:58:39',
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'attribute_id' => 22,
                'alternames' => '{"cz": null, "en": "8 GB", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 14:58:39',
                'updated_at' => '2024-05-25 14:58:39',
                'deleted_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'attribute_id' => 22,
                'alternames' => '{"cz": null, "en": "12 GB", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 14:58:39',
                'updated_at' => '2024-05-25 14:58:39',
                'deleted_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'attribute_id' => 22,
                'alternames' => '{"cz": null, "en": "14 GB", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 14:58:39',
                'updated_at' => '2024-05-25 14:58:39',
                'deleted_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'attribute_id' => 22,
                'alternames' => '{"cz": null, "en": "16 GB", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 14:58:39',
                'updated_at' => '2024-05-25 14:58:39',
                'deleted_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'attribute_id' => 23,
                'alternames' => '{"cz": "16 GB nebo méně", "en": "16 GB and less", "ru": "16 GB и менее"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:08:54',
                'updated_at' => '2024-05-25 15:08:54',
                'deleted_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'attribute_id' => 23,
                'alternames' => '{"cz": null, "en": "32 GB", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:08:54',
                'updated_at' => '2024-05-25 15:08:54',
                'deleted_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'attribute_id' => 23,
                'alternames' => '{"cz": null, "en": "64 GB", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:08:54',
                'updated_at' => '2024-05-25 15:08:54',
                'deleted_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'attribute_id' => 23,
                'alternames' => '{"cz": null, "en": "128 GB", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:08:54',
                'updated_at' => '2024-05-25 15:08:54',
                'deleted_at' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'attribute_id' => 23,
                'alternames' => '{"cz": null, "en": "256 GB", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:08:54',
                'updated_at' => '2024-05-25 15:08:54',
                'deleted_at' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'attribute_id' => 23,
                'alternames' => '{"cz": null, "en": "512 GB", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:08:54',
                'updated_at' => '2024-05-25 15:08:54',
                'deleted_at' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'attribute_id' => 23,
                'alternames' => '{"cz": "1 TB nebo více", "en": "1 TB and more", "ru": "1 TB и более"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:08:54',
                'updated_at' => '2024-05-25 15:08:54',
                'deleted_at' => NULL,
            ),
            47 => 
            array (
                'id' => 48,
                'attribute_id' => 24,
                'alternames' => '{"cz": "4,4 nebo méně", "en": "4,4 and less", "ru": "4,4 и менее"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:15:31',
                'updated_at' => '2024-05-25 15:15:31',
                'deleted_at' => NULL,
            ),
            48 => 
            array (
                'id' => 49,
                'attribute_id' => 24,
                'alternames' => '{"cz": null, "en": "4,5 - 5,4", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:15:31',
                'updated_at' => '2024-05-25 15:15:31',
                'deleted_at' => NULL,
            ),
            49 => 
            array (
                'id' => 50,
                'attribute_id' => 24,
                'alternames' => '{"cz": null, "en": "5,5 - 5,9", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:15:31',
                'updated_at' => '2024-05-25 15:15:31',
                'deleted_at' => NULL,
            ),
            50 => 
            array (
                'id' => 51,
                'attribute_id' => 24,
                'alternames' => '{"cz": null, "en": "6 - 6,4", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:15:31',
                'updated_at' => '2024-05-25 15:15:31',
                'deleted_at' => NULL,
            ),
            51 => 
            array (
                'id' => 52,
                'attribute_id' => 24,
                'alternames' => '{"cz": "6,5 nebo více", "en": "6,5 and more", "ru": "6,5 и более"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:15:31',
                'updated_at' => '2024-05-25 15:15:31',
                'deleted_at' => NULL,
            ),
            52 => 
            array (
                'id' => 53,
                'attribute_id' => 25,
                'alternames' => '{"cz": null, "en": "OLED", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:17:15',
                'updated_at' => '2024-05-25 15:17:15',
                'deleted_at' => NULL,
            ),
            53 => 
            array (
                'id' => 54,
                'attribute_id' => 25,
                'alternames' => '{"cz": null, "en": "QLED", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:17:15',
                'updated_at' => '2024-05-25 15:17:15',
                'deleted_at' => NULL,
            ),
            54 => 
            array (
                'id' => 55,
                'attribute_id' => 25,
                'alternames' => '{"cz": null, "en": "LED", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:17:15',
                'updated_at' => '2024-05-25 15:17:15',
                'deleted_at' => NULL,
            ),
            55 => 
            array (
                'id' => 56,
                'attribute_id' => 25,
                'alternames' => '{"cz": null, "en": "NanoCell", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:17:15',
                'updated_at' => '2024-05-25 15:17:15',
                'deleted_at' => NULL,
            ),
            56 => 
            array (
                'id' => 57,
                'attribute_id' => 25,
                'alternames' => '{"cz": null, "en": "IPS", "ru": null}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-25 15:17:15',
                'updated_at' => '2024-05-25 15:17:15',
                'deleted_at' => NULL,
            ),
            57 => 
            array (
                'id' => 58,
                'attribute_id' => 14,
                'alternames' => '{"cz": "Ano", "en": "Yes", "ru": "Да"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-26 11:59:51',
                'updated_at' => '2024-07-15 12:38:19',
                'deleted_at' => NULL,
            ),
            58 => 
            array (
                'id' => 59,
                'attribute_id' => 14,
                'alternames' => '[]',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-26 11:59:51',
                'updated_at' => '2024-05-26 12:00:21',
                'deleted_at' => '2024-05-26 12:00:21',
            ),
            59 => 
            array (
                'id' => 60,
                'attribute_id' => 14,
                'alternames' => '{"cz": "Ne", "en": "No", "ru": "Нет"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-26 12:00:56',
                'updated_at' => '2024-07-15 12:38:19',
                'deleted_at' => NULL,
            ),
            60 => 
            array (
                'id' => 61,
                'attribute_id' => 14,
                'alternames' => '{"cz": "Nevadí", "en": "No metter", "ru": "Не важно"}',
                'is_default' => 1,
                'is_null' => 1,
                'created_at' => '2024-05-26 12:06:52',
                'updated_at' => '2024-07-15 12:38:19',
                'deleted_at' => NULL,
            ),
            61 => 
            array (
                'id' => 62,
                'attribute_id' => 15,
                'alternames' => '{"cz": "Ano", "en": "Yes", "ru": "Да"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-26 13:06:00',
                'updated_at' => '2024-05-26 13:06:00',
                'deleted_at' => NULL,
            ),
            62 => 
            array (
                'id' => 63,
                'attribute_id' => 15,
                'alternames' => '{"cz": "Ne", "en": "No", "ru": "Нет"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-05-26 13:06:00',
                'updated_at' => '2024-05-26 13:06:00',
                'deleted_at' => NULL,
            ),
            63 => 
            array (
                'id' => 64,
                'attribute_id' => 15,
                'alternames' => '{"cz": "Nevadí", "en": "No metter", "ru": "Не важно"}',
                'is_default' => 1,
                'is_null' => 1,
                'created_at' => '2024-05-26 13:06:00',
                'updated_at' => '2024-05-26 13:06:00',
                'deleted_at' => NULL,
            ),
            64 => 
            array (
                'id' => 65,
                'attribute_id' => 13,
                'alternames' => '{"cz": "Ano", "en": "Yes", "ru": "Да"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-06-04 10:48:09',
                'updated_at' => '2024-06-04 10:48:09',
                'deleted_at' => NULL,
            ),
            65 => 
            array (
                'id' => 66,
                'attribute_id' => 13,
                'alternames' => '{"cz": "Ne", "en": "No", "ru": "Нет"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-06-04 10:48:09',
                'updated_at' => '2024-06-04 10:48:09',
                'deleted_at' => NULL,
            ),
            66 => 
            array (
                'id' => 67,
                'attribute_id' => 13,
                'alternames' => '{"cz": "Nevadi", "en": "No metter", "ru": "Неважно"}',
                'is_default' => 1,
                'is_null' => 1,
                'created_at' => '2024-06-04 10:48:09',
                'updated_at' => '2024-06-04 10:48:09',
                'deleted_at' => NULL,
            ),
            67 => 
            array (
                'id' => 68,
                'attribute_id' => 30,
                'alternames' => '{"cs": "Dům", "en": "House", "ru": "Дом"}',
                'is_default' => 1,
                'is_null' => 0,
                'created_at' => '2024-07-15 12:31:43',
                'updated_at' => '2024-07-15 12:57:20',
                'deleted_at' => NULL,
            ),
            68 => 
            array (
                'id' => 69,
                'attribute_id' => 30,
                'alternames' => '{"cs": "Letní dům", "en": "Summer house", "ru": "Дача"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-15 12:31:43',
                'updated_at' => '2024-07-15 12:57:20',
                'deleted_at' => NULL,
            ),
            69 => 
            array (
                'id' => 70,
                'attribute_id' => 30,
                'alternames' => '{"cs": "Chata", "en": "Cottage", "ru": "Коттедж"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-15 12:31:43',
                'updated_at' => '2024-07-15 12:57:20',
                'deleted_at' => NULL,
            ),
            70 => 
            array (
                'id' => 71,
                'attribute_id' => 30,
                'alternames' => '{"cs": "Městský dům", "en": "Townhouse", "ru": "Таунхаус"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-15 12:31:43',
                'updated_at' => '2024-07-15 12:57:20',
                'deleted_at' => NULL,
            ),
            71 => 
            array (
                'id' => 72,
                'attribute_id' => 31,
                'alternames' => '{"cs": "1 pokoj", "en": "1 room", "ru": "1 комната"}',
                'is_default' => 1,
                'is_null' => 0,
                'created_at' => '2024-07-15 12:36:20',
                'updated_at' => '2024-07-17 10:28:47',
                'deleted_at' => NULL,
            ),
            72 => 
            array (
                'id' => 73,
                'attribute_id' => 31,
                'alternames' => '{"cs": "2 pokoje", "en": "2 rooms", "ru": "2 комнаты"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-15 12:36:20',
                'updated_at' => '2024-07-17 10:28:47',
                'deleted_at' => NULL,
            ),
            73 => 
            array (
                'id' => 74,
                'attribute_id' => 31,
                'alternames' => '{"cs": "3 pokoje", "en": "3 rooms", "ru": "3 комнаты"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-15 12:36:20',
                'updated_at' => '2024-07-17 10:28:47',
                'deleted_at' => NULL,
            ),
            74 => 
            array (
                'id' => 75,
                'attribute_id' => 31,
                'alternames' => '{"cs": "4 pokoje", "en": "4 rooms", "ru": "4 комнаты"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-15 12:36:20',
                'updated_at' => '2024-07-17 10:28:47',
                'deleted_at' => NULL,
            ),
            75 => 
            array (
                'id' => 76,
                'attribute_id' => 31,
                'alternames' => '{"cs": "5 pokoje", "en": "5 rooms", "ru": "5 комнаты"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-15 12:36:20',
                'updated_at' => '2024-07-17 10:28:47',
                'deleted_at' => NULL,
            ),
            76 => 
            array (
                'id' => 77,
                'attribute_id' => 31,
                'alternames' => '{"cs": "6 a více", "en": "6 and more", "ru": "6 и более"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-15 12:36:20',
                'updated_at' => '2024-07-17 10:28:47',
                'deleted_at' => NULL,
            ),
            77 => 
            array (
                'id' => 78,
                'attribute_id' => 7,
                'alternames' => '{"cs": "Krátkodoby pronájem", "en": "Short-term rent", "ru": "Краткосрочная аренда"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-16 10:56:40',
                'updated_at' => '2024-07-26 16:37:59',
                'deleted_at' => NULL,
            ),
            78 => 
            array (
                'id' => 79,
                'attribute_id' => 7,
                'alternames' => '{"cs": "Nevadí", "en": "No matter", "ru": "Не важно"}',
                'is_default' => 1,
                'is_null' => 1,
                'created_at' => '2024-07-16 12:10:04',
                'updated_at' => '2024-07-26 16:37:59',
                'deleted_at' => NULL,
            ),
            79 => 
            array (
                'id' => 80,
                'attribute_id' => 33,
                'alternames' => '{"cs": "Все", "en": "Все", "ru": "Все"}',
                'is_default' => 1,
                'is_null' => 1,
                'created_at' => '2024-07-17 11:32:19',
                'updated_at' => '2024-07-17 13:16:18',
                'deleted_at' => NULL,
            ),
            80 => 
            array (
                'id' => 81,
                'attribute_id' => 33,
                'alternames' => '{"cs": "Pokoj", "en": "Room", "ru": "Комната"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 11:32:19',
                'updated_at' => '2024-07-17 13:16:18',
                'deleted_at' => NULL,
            ),
            81 => 
            array (
                'id' => 82,
                'attribute_id' => 33,
                'alternames' => '{"cs": "Lůžko", "en": "Bed", "ru": "Койко-место"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 11:32:19',
                'updated_at' => '2024-07-17 13:16:18',
                'deleted_at' => NULL,
            ),
            82 => 
            array (
                'id' => 83,
                'attribute_id' => 34,
                'alternames' => '{"cs": "Všechny", "en": "All", "ru": "Все"}',
                'is_default' => 1,
                'is_null' => 1,
                'created_at' => '2024-07-17 11:43:59',
                'updated_at' => '2024-07-17 13:14:47',
                'deleted_at' => NULL,
            ),
            83 => 
            array (
                'id' => 84,
                'attribute_id' => 34,
                'alternames' => '{"cs": "Garáž", "en": "Garage", "ru": "Гараж"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 11:43:59',
                'updated_at' => '2024-07-17 13:14:47',
                'deleted_at' => NULL,
            ),
            84 => 
            array (
                'id' => 85,
                'attribute_id' => 34,
                'alternames' => '{"cs": "Parkovací místo", "en": "Parking space", "ru": "Машиноместо"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 11:43:59',
                'updated_at' => '2024-07-17 13:14:47',
                'deleted_at' => NULL,
            ),
            85 => 
            array (
                'id' => 86,
                'attribute_id' => 35,
                'alternames' => '{"cs": "Kancelář", "en": "Office", "ru": "Офис"}',
                'is_default' => 1,
                'is_null' => 0,
                'created_at' => '2024-07-17 12:22:20',
                'updated_at' => '2024-07-17 13:15:14',
                'deleted_at' => NULL,
            ),
            86 => 
            array (
                'id' => 87,
                'attribute_id' => 35,
                'alternames' => '{"cs": "Obchodní prostor", "en": "Trading area", "ru": "Торговая площадь"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 12:22:20',
                'updated_at' => '2024-07-17 13:15:14',
                'deleted_at' => NULL,
            ),
            87 => 
            array (
                'id' => 88,
                'attribute_id' => 35,
                'alternames' => '{"cs": "Skladové prostory", "en": "Storage", "ru": "Склад"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 12:22:20',
                'updated_at' => '2024-07-17 13:15:14',
                'deleted_at' => NULL,
            ),
            88 => 
            array (
                'id' => 89,
                'attribute_id' => 35,
                'alternames' => '{"cs": "Výroba", "en": "Production", "ru": "Производство"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 12:22:20',
                'updated_at' => '2024-07-17 13:15:14',
                'deleted_at' => NULL,
            ),
            89 => 
            array (
                'id' => 90,
                'attribute_id' => 35,
                'alternames' => '{"cs": "Gastronomie", "en": "Restaurant", "ru": "Общепит"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 12:22:20',
                'updated_at' => '2024-07-17 13:15:14',
                'deleted_at' => NULL,
            ),
            90 => 
            array (
                'id' => 91,
                'attribute_id' => 35,
                'alternames' => '{"cs": "Hotel", "en": "Hotel", "ru": "Гостиница"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 12:22:20',
                'updated_at' => '2024-07-17 13:15:14',
                'deleted_at' => NULL,
            ),
            91 => 
            array (
                'id' => 92,
                'attribute_id' => 35,
                'alternames' => '{"cs": "Autoservis", "en": "Car service", "ru": "Автосервис"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 12:22:20',
                'updated_at' => '2024-07-17 13:15:14',
                'deleted_at' => NULL,
            ),
            92 => 
            array (
                'id' => 93,
                'attribute_id' => 35,
                'alternames' => '{"cs": "Celá budova", "en": "The whole building", "ru": "Здание целиком"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 12:22:20',
                'updated_at' => '2024-07-17 13:15:14',
                'deleted_at' => NULL,
            ),
            93 => 
            array (
                'id' => 94,
                'attribute_id' => 36,
                'alternames' => '{"cs": "Pro obytnou výstavbu", "en": "For residential development", "ru": "Под жилую застройку"}',
                'is_default' => 1,
                'is_null' => 0,
                'created_at' => '2024-07-17 13:00:03',
                'updated_at' => '2024-07-17 13:12:29',
                'deleted_at' => NULL,
            ),
            94 => 
            array (
                'id' => 95,
                'attribute_id' => 36,
                'alternames' => '{"cs": "V rámci zemědělství", "en": "For agriculture", "ru": "Под сельское хозяйство"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 13:00:03',
                'updated_at' => '2024-07-17 13:12:29',
                'deleted_at' => NULL,
            ),
            95 => 
            array (
                'id' => 96,
                'attribute_id' => 36,
                'alternames' => '{"cs": "Průmyslové", "en": "Industrial", "ru": "Промышленного назначения"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 13:00:03',
                'updated_at' => '2024-07-17 13:12:29',
                'deleted_at' => NULL,
            ),
            96 => 
            array (
                'id' => 97,
                'attribute_id' => 37,
                'alternames' => '{"cs": "Soukromé", "en": "Private", "ru": "Частный"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 13:06:54',
                'updated_at' => '2024-07-17 13:08:24',
                'deleted_at' => NULL,
            ),
            97 => 
            array (
                'id' => 98,
                'attribute_id' => 37,
                'alternames' => '{"cs": "Realitní kancelář", "en": "Agency", "ru": "Агентство"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-17 13:06:54',
                'updated_at' => '2024-07-17 13:08:24',
                'deleted_at' => NULL,
            ),
            98 => 
            array (
                'id' => 99,
                'attribute_id' => 37,
                'alternames' => '{"cs": "Nevadí", "en": "No matter", "ru": "Не важно"}',
                'is_default' => 1,
                'is_null' => 1,
                'created_at' => '2024-07-17 13:06:54',
                'updated_at' => '2024-07-17 13:08:24',
                'deleted_at' => NULL,
            ),
            99 => 
            array (
                'id' => 100,
                'attribute_id' => 40,
                'alternames' => '{"cs": "1", "en": "1", "ru": "1"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-26 12:53:24',
                'updated_at' => '2024-07-28 10:37:46',
                'deleted_at' => '2024-07-28 10:37:46',
            ),
            100 => 
            array (
                'id' => 101,
                'attribute_id' => 40,
                'alternames' => '{"cs": "2", "en": "2", "ru": "2"}',
                'is_default' => 0,
                'is_null' => 0,
                'created_at' => '2024-07-26 12:53:24',
                'updated_at' => '2024-07-28 10:37:46',
                'deleted_at' => '2024-07-28 10:37:46',
            ),
            101 => 
            array (
                'id' => 102,
                'attribute_id' => 40,
                'alternames' => '{"cs": "3", "en": "3", "ru": "3"}',
                'is_default' => 1,
                'is_null' => 1,
                'created_at' => '2024-07-26 12:53:24',
                'updated_at' => '2024-07-28 10:37:46',
                'deleted_at' => '2024-07-28 10:37:46',
            ),
        ));
        
        
    }
}