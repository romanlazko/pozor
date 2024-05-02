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
                'name' => 'current_price',
                'label' => 'Цена',
                'alterlabels' => '{"cz": "Cenik", "en": "Price", "ru": "Цена"}',
                'create_type' => 'text_input',
                'search_type' => 'between',
                'attribute_section_id' => 1,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'attribute_option_id' => NULL,
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 1,
                'created_at' => '2024-04-23 10:42:20',
                'updated_at' => '2024-04-25 13:07:59',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'deposit',
                'label' => 'Залог',
                'alterlabels' => '{"cz": "Kauce", "en": "Deposit", "ru": "Залог"}',
                'create_type' => 'text_input',
                'search_type' => 'between',
                'attribute_section_id' => 1,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 5,
                'visible' => '[{"value": "2", "attribute_name": "real_estate_type"}]',
                'attribute_option_id' => NULL,
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 0,
                'searchable' => 1,
                'created_at' => '2024-04-23 10:43:26',
                'updated_at' => '2024-04-29 12:30:04',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'real_estate_type',
                'label' => 'Type',
                'alterlabels' => '{"cz": "Typ", "en": "Type", "ru": "Тип"}',
                'create_type' => 'toggle_buttons',
                'search_type' => 'toggle_buttons',
                'attribute_section_id' => 3,
                'column_span' => '2',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'attribute_option_id' => NULL,
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 1,
                'created_at' => '2024-04-23 10:47:22',
                'updated_at' => '2024-04-23 14:55:37',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'currency_id',
                'label' => 'Валюта',
                'alterlabels' => '{"cz": "Měna", "en": "Currency", "ru": "Валюта"}',
                'create_type' => 'select',
                'search_type' => 'hidden',
                'attribute_section_id' => 1,
                'column_span' => '1',
                'column_start' => '2',
                'order_number' => 2,
                'visible' => '[]',
                'attribute_option_id' => NULL,
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 0,
                'created_at' => '2024-04-23 10:57:51',
                'updated_at' => '2024-04-25 13:07:33',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'title',
                'label' => 'Title',
                'alterlabels' => '{"cz": "Název", "en": "Title", "ru": "Заголовок"}',
                'create_type' => 'text_input',
                'search_type' => 'search',
                'attribute_section_id' => 3,
                'column_span' => '2',
                'column_start' => '1',
                'order_number' => 2,
                'visible' => '[]',
                'attribute_option_id' => NULL,
                'translatable' => 1,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 1,
                'created_at' => '2024-04-23 11:14:20',
                'updated_at' => '2024-04-23 14:55:41',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'description',
                'label' => 'Description',
                'alterlabels' => '{"cz": "Popis", "en": "Description", "ru": "Описание"}',
                'create_type' => 'text_area',
                'search_type' => 'hidden',
                'attribute_section_id' => 3,
                'column_span' => '2',
                'column_start' => '1',
                'order_number' => 3,
                'visible' => '[]',
                'attribute_option_id' => NULL,
                'translatable' => 1,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 0,
                'created_at' => '2024-04-23 11:15:51',
                'updated_at' => '2024-04-23 12:14:21',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'pc_ram',
                'label' => 'RAM',
                'alterlabels' => '{"cz": "RAM", "en": "RAM", "ru": "RAM"}',
                'create_type' => 'select',
                'search_type' => 'checkboxlist',
                'attribute_section_id' => 4,
                'column_span' => '2',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'attribute_option_id' => NULL,
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 0,
                'searchable' => 1,
                'created_at' => '2024-04-23 11:40:03',
                'updated_at' => '2024-04-23 14:55:21',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'location',
                'label' => 'Location',
                'alterlabels' => '{"cz": "Lokalita", "en": "Location", "ru": "Месторасположение"}',
                'create_type' => 'location',
                'search_type' => 'location',
                'attribute_section_id' => 5,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'attribute_option_id' => NULL,
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'searchable' => 1,
                'created_at' => '2024-04-23 12:02:00',
                'updated_at' => '2024-04-23 14:58:28',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'notebooks_display_type',
                'label' => 'Display type',
                'alterlabels' => '{"cz": "Typ displeje", "en": "Display type", "ru": "Тип дисплея"}',
                'create_type' => 'select',
                'search_type' => 'checkboxlist',
                'attribute_section_id' => 6,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'attribute_option_id' => NULL,
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 0,
                'searchable' => 1,
                'created_at' => '2024-04-23 12:07:21',
                'updated_at' => '2024-04-23 14:54:51',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'address',
                'label' => 'Address',
                'alterlabels' => '{"cz": "Adresa", "en": "Address", "ru": "Адрес"}',
                'create_type' => 'text_input',
                'search_type' => 'hidden',
                'attribute_section_id' => 5,
                'column_span' => '2',
                'column_start' => '1',
                'order_number' => 2,
                'visible' => '[]',
                'attribute_option_id' => NULL,
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'searchable' => 0,
                'created_at' => '2024-04-23 12:52:59',
                'updated_at' => '2024-04-30 17:07:23',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'note_on_price',
                'label' => 'Note on price',
                'alterlabels' => '{"cz": "Poznámka k ceně", "en": "Note on price", "ru": "Примечание к цене"}',
                'create_type' => 'text_input',
                'search_type' => 'hidden',
                'attribute_section_id' => 1,
                'column_span' => '2',
                'column_start' => '1',
                'order_number' => 4,
                'visible' => '[]',
                'attribute_option_id' => NULL,
                'translatable' => 1,
                'is_feature' => 1,
                'required' => 0,
                'searchable' => 0,
                'created_at' => '2024-04-23 12:56:35',
                'updated_at' => '2024-04-23 12:56:35',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'tv_display_type',
                'label' => 'Display type',
                'alterlabels' => '{"cz": "Typ displeje", "en": "Display type", "ru": "Тип дисплея"}',
                'create_type' => 'select',
                'search_type' => 'checkboxlist',
                'attribute_section_id' => 7,
                'column_span' => '1',
                'column_start' => '1',
                'order_number' => 1,
                'visible' => '[]',
                'attribute_option_id' => NULL,
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 0,
                'searchable' => 1,
                'created_at' => '2024-04-23 19:57:09',
                'updated_at' => '2024-04-23 19:57:09',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}