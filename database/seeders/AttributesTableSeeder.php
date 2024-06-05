<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('attributes')->delete();
        
        \DB::table('attributes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'title',
                'alterlabels' => '{"cs": "Nazev", "en": "Title", "ru": "Заголовок"}',
                'altersyffixes' => NULL,
                'create_type' => 'text_input',
                'search_type' => 'search',
                'default' => NULL,
                'attribute_section_id' => 1,
                'column_span' => '2',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'translatable' => 1,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 1,
                'rules' => '["string"]',
                'created_at' => '2024-05-21 16:49:21',
                'updated_at' => '2024-05-25 14:20:06',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'description',
                'alterlabels' => '{"cs": "Popis", "en": "Description", "ru": "Описание"}',
                'altersyffixes' => NULL,
                'create_type' => 'markdown_editor',
                'search_type' => 'hidden',
                'default' => NULL,
                'attribute_section_id' => 1,
                'column_span' => '2',
                'column_start' => '1',
                'order_number' => 2,
                'visible' => '[]',
                'translatable' => 1,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 0,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '["string"]',
                'created_at' => '2024-05-21 17:33:41',
                'updated_at' => '2024-05-25 14:20:11',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'currency',
                'alterlabels' => '{"cs": "Mena", "en": "Currency", "ru": "Валюта"}',
                'altersyffixes' => NULL,
                'create_type' => 'select',
                'search_type' => 'hidden',
                'default' => NULL,
                'attribute_section_id' => 2,
                'column_span' => '1',
                'column_start' => '2',
                'order_number' => 2,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 0,
                'filterable' => 0,
                'always_required' => 1,
                'rules' => '[]',
                'created_at' => '2024-05-21 17:37:31',
                'updated_at' => '2024-05-25 14:19:46',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'current_price',
                'alterlabels' => '{"cs": "Cena", "en": "Price", "ru": "Стоимость"}',
                'altersyffixes' => NULL,
                'create_type' => 'text_input',
                'search_type' => 'between',
                'default' => NULL,
                'attribute_section_id' => 2,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 1,
                'rules' => '["string"]',
                'created_at' => '2024-05-21 17:39:42',
                'updated_at' => '2024-05-26 15:03:41',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'note_on_price',
                'alterlabels' => '{"cs": "Poznámka k ceně", "en": "Note on price", "ru": "Пометка к цене"}',
                'altersyffixes' => NULL,
                'create_type' => 'text_input',
                'search_type' => 'hidden',
                'default' => NULL,
                'attribute_section_id' => 2,
                'column_span' => '2',
                'column_start' => '1',
                'order_number' => 3,
                'visible' => '[]',
                'translatable' => 1,
                'is_feature' => 1,
                'required' => 0,
                'searchable' => 0,
                'filterable' => 0,
                'always_required' => 1,
                'rules' => '["string"]',
                'created_at' => '2024-05-21 17:44:16',
                'updated_at' => '2024-05-21 17:45:39',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'real_estate_deposit',
                'alterlabels' => '{"cs": "Kauce", "en": "Deposit", "ru": "Залог"}',
                'altersyffixes' => '[]',
                'create_type' => 'text_input',
                'search_type' => 'between',
                'default' => NULL,
                'attribute_section_id' => 2,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 4,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 0,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '["numeric"]',
                'created_at' => '2024-05-21 17:46:53',
                'updated_at' => '2024-05-30 18:36:41',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'real_estate_type',
                'alterlabels' => '{"cs": "Typ", "en": "Type", "ru": "Тип"}',
                'altersyffixes' => NULL,
                'create_type' => 'toggle_buttons',
                'search_type' => 'toggle_buttons',
                'default' => NULL,
                'attribute_section_id' => 1,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-21 17:49:37',
                'updated_at' => '2024-05-25 14:20:07',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'real_estate_configuration',
                'alterlabels' => '{"cs": "Konfigurace", "en": "Configuration", "ru": "Конфигурация"}',
                'altersyffixes' => NULL,
                'create_type' => 'select',
                'search_type' => 'multiple_select',
                'default' => NULL,
                'attribute_section_id' => 5,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-21 18:31:00',
                'updated_at' => '2024-05-25 14:19:56',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'building',
                'alterlabels' => '{"cs": "Budova", "en": "Building", "ru": "Здание"}',
                'altersyffixes' => '[]',
                'create_type' => 'select',
                'search_type' => 'multiple_select',
                'default' => NULL,
                'attribute_section_id' => 4,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 0,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-21 18:41:59',
                'updated_at' => '2024-06-05 13:50:26',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'condition',
                'alterlabels' => '{"cs": "Stav", "en": "Condition", "ru": "Состояние"}',
                'altersyffixes' => '[]',
                'create_type' => 'select',
                'search_type' => 'multiple_select',
                'default' => NULL,
                'attribute_section_id' => 4,
                'column_span' => '1',
                'column_start' => '2',
                'order_number' => 2,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 0,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-21 18:45:41',
                'updated_at' => '2024-06-05 16:04:09',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'number_of_floors',
                'alterlabels' => '{"cs": "Počet podlaží", "en": "Number of floors", "ru": "Количество этажей"}',
                'altersyffixes' => '{"cs": "podlaží", "en": "flors", "ru": "этажей"}',
                'create_type' => 'text_input',
                'search_type' => 'between',
                'default' => NULL,
                'attribute_section_id' => 4,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 3,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 0,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '["numeric"]',
                'created_at' => '2024-05-21 18:47:28',
                'updated_at' => '2024-06-05 16:04:29',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'number_of_underground_floors',
                'alterlabels' => '{"cs": "Počet podzemních podlaží", "en": "Number of underground floors", "ru": "Количество подземных этажей"}',
                'altersyffixes' => '{"cs": "podlaží", "en": "floors", "ru": "этажей"}',
                'create_type' => 'text_input',
                'search_type' => 'between',
                'default' => NULL,
                'attribute_section_id' => 4,
                'column_span' => '1',
                'column_start' => '2',
                'order_number' => 4,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 0,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '["numeric"]',
                'created_at' => '2024-05-21 18:48:21',
                'updated_at' => '2024-05-25 17:27:52',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'elevator',
                'alterlabels' => '{"cs": "Výtah", "en": "Elevator", "ru": "Лифт"}',
                'altersyffixes' => '[]',
                'create_type' => 'toggle_buttons',
                'search_type' => 'toggle_buttons',
                'default' => NULL,
                'attribute_section_id' => 4,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 5,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-21 18:50:35',
                'updated_at' => '2024-06-04 10:48:09',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'balcony',
                'alterlabels' => '{"cs": "Balkon", "en": "Balcony", "ru": "Балкон"}',
                'altersyffixes' => '[]',
                'create_type' => 'toggle_buttons',
                'search_type' => 'toggle_buttons',
                'default' => NULL,
                'attribute_section_id' => 5,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 3,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-21 18:51:39',
                'updated_at' => '2024-05-26 12:49:22',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'parking',
                'alterlabels' => '{"cs": "Parkoviště", "en": "Parking", "ru": "Паркинг"}',
                'altersyffixes' => '[]',
                'create_type' => 'toggle_buttons',
                'search_type' => 'toggle_buttons',
                'default' => NULL,
                'attribute_section_id' => 4,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 7,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-21 18:53:35',
                'updated_at' => '2024-05-26 13:06:00',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'floor_area',
                'alterlabels' => '{"cs": "Podlahová plocha", "en": "Floor area", "ru": "Площадь помещения"}',
                'altersyffixes' => '{"en": "m²"}',
                'create_type' => 'text_input',
                'search_type' => 'between',
                'default' => NULL,
                'attribute_section_id' => 5,
                'column_span' => '1',
                'column_start' => '2',
                'order_number' => 2,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '["numeric"]',
                'created_at' => '2024-05-22 11:11:59',
                'updated_at' => '2024-05-25 14:19:57',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 's_i_m_card_count',
                'alterlabels' => '{"cs": "SIM card množství", "en": "SIM card count", "ru": "Количество сим карт"}',
                'altersyffixes' => NULL,
                'create_type' => 'select',
                'search_type' => 'multiple_select',
                'default' => NULL,
                'attribute_section_id' => 6,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 0,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-23 18:48:58',
                'updated_at' => '2024-05-25 14:19:42',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'salary_to',
                'alterlabels' => '{"cs": "Mzda do", "en": "Salary to", "ru": "Зарплата до"}',
                'altersyffixes' => '[]',
                'create_type' => 'text_input',
                'search_type' => 'hidden',
                'default' => NULL,
                'attribute_section_id' => 7,
                'column_span' => '1',
                'column_start' => '2',
                'order_number' => 2,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 0,
                'filterable' => 0,
                'always_required' => 0,
                'rules' => '["numeric"]',
                'created_at' => '2024-05-23 19:48:55',
                'updated_at' => '2024-05-26 15:00:42',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'currency',
                'alterlabels' => '{"cs": "Mena", "en": "Currency", "ru": "Валюта"}',
                'altersyffixes' => '[]',
                'create_type' => 'select',
                'search_type' => 'hidden',
                'default' => NULL,
                'attribute_section_id' => 7,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 3,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 0,
                'filterable' => 0,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-24 09:50:31',
                'updated_at' => '2024-05-26 14:42:26',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'title',
                'alterlabels' => '{"cs": "Nazev", "en": "Title", "ru": "Заголовок"}',
                'altersyffixes' => NULL,
                'create_type' => 'text_input',
                'search_type' => 'hidden',
                'default' => NULL,
                'attribute_section_id' => 1,
                'column_span' => '2',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'translatable' => 1,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 0,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '["string"]',
                'created_at' => '2024-05-24 11:26:12',
                'updated_at' => '2024-05-25 14:20:09',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'salary_type',
                'alterlabels' => '{"cs": "Typ platby", "en": "Salary type", "ru": "Тип оплаты"}',
                'altersyffixes' => '[]',
                'create_type' => 'select',
                'search_type' => 'multiple_select',
                'default' => NULL,
                'attribute_section_id' => 7,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 4,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 1,
                'filterable' => 0,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-24 16:48:19',
                'updated_at' => '2024-05-26 14:42:43',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'phone_ram',
            'alterlabels' => '{"cs": "RAM (operační paměť)", "en": "RAM (operating memory)", "ru": "RAM (оперативная память)"}',
                'altersyffixes' => '{"cs": "RAM", "en": null, "ru": null}',
                'create_type' => 'select',
                'search_type' => 'multiple_select',
                'default' => NULL,
                'attribute_section_id' => 8,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 0,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-25 14:58:39',
                'updated_at' => '2024-05-25 15:24:49',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'phone_rom',
            'alterlabels' => '{"cs": "ROM (zabudovaná paměť)", "en": "ROM (integrated memory)", "ru": "ROM (встроенная память)"}',
                'altersyffixes' => '{"cs": "ROM", "en": null, "ru": null}',
                'create_type' => 'select',
                'search_type' => 'multiple_select',
                'default' => NULL,
                'attribute_section_id' => 8,
                'column_span' => '1',
                'column_start' => '2',
                'order_number' => 2,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 0,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-25 15:08:54',
                'updated_at' => '2024-05-25 15:24:57',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'display_diagonal',
                'alterlabels' => '{"cs": "Úhlopříčka displeje", "en": "Display diagonal", "ru": "Диагональ дисплея"}',
                'altersyffixes' => '{"cs": null, "en": "\\"", "ru": null}',
                'create_type' => 'select',
                'search_type' => 'multiple_select',
                'default' => NULL,
                'attribute_section_id' => 9,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 0,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-25 15:15:31',
                'updated_at' => '2024-05-25 15:15:31',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'display_type',
                'alterlabels' => '{"cs": "Typ displeje ", "en": "Display type", "ru": "Тип дисплея"}',
                'altersyffixes' => '{"cs": null, "en": null, "ru": null}',
                'create_type' => 'select',
                'search_type' => 'multiple_select',
                'default' => NULL,
                'attribute_section_id' => 9,
                'column_span' => '1',
                'column_start' => '2',
                'order_number' => 2,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 0,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-25 15:17:15',
                'updated_at' => '2024-05-25 15:17:15',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'salary_from',
                'alterlabels' => '{"cs": "Mzda od", "en": "Salary from", "ru": "Зарплата от"}',
                'altersyffixes' => '{"cs": null, "en": null, "ru": null}',
                'create_type' => 'from',
                'search_type' => 'from',
                'default' => NULL,
                'attribute_section_id' => 7,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '[]',
                'created_at' => '2024-05-26 14:27:52',
                'updated_at' => '2024-06-03 13:51:55',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'location',
                'alterlabels' => '{"cs": "Lokace", "en": "Location", "ru": "Расположение"}',
                'altersyffixes' => '{"cs": null, "en": null, "ru": null}',
                'create_type' => 'location',
                'search_type' => 'location',
                'default' => NULL,
                'attribute_section_id' => 10,
                'column_span' => '2',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 1,
                'rules' => '[]',
                'created_at' => '2024-05-28 09:01:30',
                'updated_at' => '2024-05-28 09:01:30',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'salary',
                'alterlabels' => '{"cs": "Mzda", "en": "Salary", "ru": "Зарплата"}',
                'altersyffixes' => '{"cs": null, "en": null, "ru": null}',
                'create_type' => 'from',
                'search_type' => 'from',
                'default' => NULL,
                'attribute_section_id' => 7,
                'column_span' => '2',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 1,
                'filterable' => 1,
                'always_required' => 0,
                'rules' => '["numeric"]',
                'created_at' => '2024-06-03 13:54:15',
                'updated_at' => '2024-06-03 13:54:15',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}