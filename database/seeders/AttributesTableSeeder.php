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
                'id' => 2,
                'name' => 'description',
                'alterlabels' => '{"cz": "Popis", "en": "Description", "ru": "Описание"}',
                'altersuffixes' => '[]',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "markdown_editor", "rules": ["string"], "section_id": "1", "column_span": "4", "column_start": "1", "order_number": "3"}',
                'filter_layout' => '{"type": "hidden"}',
                'show_layout' => '{"type": "markdown_editor", "section_id": "1", "order_number": "1"}',
                'translatable' => 1,
                'is_feature' => 0,
                'required' => 1,
                'created_at' => '2024-05-21 17:33:41',
                'updated_at' => '2024-08-14 10:13:10',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 4,
                'name' => 'current_price',
                'alterlabels' => '{"cz": "Cena", "en": "Price", "ru": "Стоимость"}',
                'altersuffixes' => '[]',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "price", "section_id": "2", "column_span": "3", "column_start": "1", "order_number": "1"}',
                'filter_layout' => '{"type": "between", "section_id": "2", "column_span": "1", "column_start": "1", "order_number": "1"}',
                'show_layout' => '{"type": "price", "section_id": "12", "order_number": "1"}',
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'created_at' => '2024-05-21 17:39:42',
                'updated_at' => '2024-08-14 10:41:27',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 5,
                'name' => 'note_on_price',
                'alterlabels' => '{"cz": "Poznámka k ceně", "en": "Note on price", "ru": "Пометка к цене"}',
                'altersuffixes' => '[]',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "text_input", "section_id": "2", "column_span": "3", "column_start": "1", "order_number": "3"}',
                'filter_layout' => '{"type": "hidden"}',
                'show_layout' => '{"type": "text_input", "section_id": "2", "order_number": "3"}',
                'translatable' => 1,
                'is_feature' => 1,
                'required' => 0,
                'created_at' => '2024-05-21 17:44:16',
                'updated_at' => '2024-08-11 13:46:23',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 6,
                'name' => 'real_estate_deposit',
                'alterlabels' => '{"cz": "Kauce", "en": "Deposit", "ru": "Залог"}',
                'altersuffixes' => '[]',
                'visible' => '[{"value": "5", "attribute_name": "real_estate_type"}, {"value": "78", "attribute_name": "real_estate_type"}]',
                'hidden' => '[{"value": "4", "attribute_name": "real_estate_type"}]',
                'create_layout' => '{"type": "price", "section_id": "2", "column_span": "3", "column_start": "1", "order_number": "4"}',
                'filter_layout' => '{"type": "between", "section_id": "2", "column_span": "4", "column_start": "1", "order_number": "4"}',
                'show_layout' => '{"type": "price", "section_id": "2", "order_number": "4"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-05-21 17:46:53',
                'updated_at' => '2024-08-14 10:08:37',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 7,
                'name' => 'real_estate_type',
                'alterlabels' => '{"cz": "Typ", "en": "Type", "ru": "Тип"}',
                'altersuffixes' => '[]',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "toggle_buttons", "section_id": "1", "column_span": "4", "column_start": "1", "order_number": "1"}',
                'filter_layout' => '{"type": "toggle_buttons", "section_id": "1", "column_span": "4", "column_start": "1", "order_number": "1"}',
                'show_layout' => '{"type": "toggle_buttons", "section_id": "13", "order_number": "1"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-05-21 17:49:37',
                'updated_at' => '2024-08-11 13:42:37',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 8,
                'name' => 'real_estate_configuration',
                'alterlabels' => '{"cz": "Konfigurace", "en": "Configuration", "ru": "Конфигурация"}',
                'altersuffixes' => '[]',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'filter_layout' => '{"type": "checkbox_list", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'show_layout' => '{"type": "select", "section_id": "5", "order_number": "1"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-05-21 18:31:00',
                'updated_at' => '2024-08-11 13:37:35',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 9,
                'name' => 'building',
                'alterlabels' => '{"cs": "Budova", "en": "Building", "ru": "Здание"}',
                'altersuffixes' => '{"cs": null, "en": null}',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "4", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'filter_layout' => '{"type": "checkbox_list", "section_id": "4", "column_span": "4", "column_start": "1", "order_number": "1"}',
                'show_layout' => '{"type": "select", "section_id": "4", "order_number": "1"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-05-21 18:41:59',
                'updated_at' => '2024-08-14 09:44:21',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 10,
                'name' => 'condition',
                'alterlabels' => '{"cs": "Stav", "en": "Condition", "ru": "Состояние"}',
                'altersuffixes' => '[]',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "4", "column_span": "2", "column_start": "3", "order_number": "2"}',
                'filter_layout' => '{"type": "checkbox_list", "section_id": "4", "column_span": "1", "column_start": "2", "order_number": "2"}',
                'show_layout' => '{"type": "select", "section_id": "4", "order_number": "2"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-05-21 18:45:41',
                'updated_at' => '2024-08-14 09:44:28',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 11,
                'name' => 'number_of_floors',
                'alterlabels' => '{"cs": "Počet podlaží", "en": "Number of floors", "ru": "Количество этажей"}',
                'altersuffixes' => '{"cs": "podlaží", "en": "flors", "ru": "этажей"}',
                'visible' => '[]',
                'hidden' => '[]',
                'create_layout' => '{"type": "text_input", "rules": ["numeric"], "section_id": "4", "column_span": "2", "column_start": "1", "order_number": "3"}',
                'filter_layout' => '{"type": "between", "section_id": "4", "column_span": "2", "column_start": "1", "order_number": "3"}',
                'show_layout' => '{"type": "text_input", "section_id": "4", "order_number": "3"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-05-21 18:47:28',
                'updated_at' => '2024-08-14 10:35:42',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 12,
                'name' => 'number_of_underground_floors',
                'alterlabels' => '{"cz": "Počet podzemních podlaží", "en": "Number of underground floors", "ru": "Количество подземных этажей"}',
                'altersuffixes' => '{"cz": "podlaží", "en": "floors", "ru": "этажей"}',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "text_input", "rules": ["numeric"], "section_id": "4", "column_span": "2", "column_start": "3", "order_number": "4"}',
                'filter_layout' => '{"type": "between", "section_id": "4", "column_span": "1", "column_start": "2", "order_number": "4"}',
                'show_layout' => '{"type": "text_input", "section_id": "4", "order_number": "4"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-05-21 18:48:21',
                'updated_at' => '2024-08-14 10:35:51',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 13,
                'name' => 'elevator',
                'alterlabels' => '{"cz": "Výtah", "en": "Elevator", "ru": "Лифт"}',
                'altersuffixes' => '[]',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "toggle_buttons", "section_id": "4", "column_span": "1", "column_start": "1", "order_number": "5"}',
                'filter_layout' => '{"type": "toggle_buttons", "section_id": "4", "column_span": "1", "column_start": "1", "order_number": "5"}',
                'show_layout' => '{"type": "toggle_buttons", "section_id": "4", "order_number": "5"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-05-21 18:50:35',
                'updated_at' => '2024-08-14 09:44:35',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 14,
                'name' => 'balcony',
                'alterlabels' => '{"cz": "Balkon", "en": "Balcony", "ru": "Балкон"}',
                'altersuffixes' => '[]',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "toggle_buttons", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "4"}',
                'filter_layout' => '{"type": "toggle_buttons", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "4"}',
                'show_layout' => '{"type": "toggle_buttons", "section_id": "5", "order_number": "4"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-05-21 18:51:39',
                'updated_at' => '2024-08-11 13:41:13',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 15,
                'name' => 'parking',
                'alterlabels' => '{"cz": "Parkoviště", "en": "Parking", "ru": "Паркинг"}',
                'altersuffixes' => '[]',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "toggle_buttons", "section_id": "4", "column_span": "1", "column_start": "1", "order_number": "6"}',
                'filter_layout' => '{"type": "toggle_buttons", "section_id": "4", "column_span": "1", "column_start": "1", "order_number": "6"}',
                'show_layout' => '{"type": "toggle_buttons", "section_id": "4", "order_number": "6"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-05-21 18:53:35',
                'updated_at' => '2024-08-14 09:44:41',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 16,
                'name' => 'square',
                'alterlabels' => '{"cz": "Plocha", "en": "Square", "ru": "Площадь"}',
                'altersuffixes' => '{"en": "m²"}',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "text_input", "rules": ["numeric"], "section_id": "5", "column_span": "2", "column_start": "3", "order_number": "2"}',
                'filter_layout' => '{"type": "between", "section_id": "5", "column_span": "2", "column_start": "3", "order_number": "2"}',
                'show_layout' => '{"type": "text_input", "section_id": "5", "order_number": "2"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-05-22 11:11:59',
                'updated_at' => '2024-08-14 10:12:03',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 17,
                'name' => 's_i_m_card_count',
                'alterlabels' => '{"cz": "SIM card množství", "en": "SIM card count", "ru": "Количество сим карт"}',
                'altersuffixes' => NULL,
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => NULL,
                'filter_layout' => NULL,
                'show_layout' => NULL,
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-05-23 18:48:58',
                'updated_at' => '2024-08-09 20:25:09',
                'deleted_at' => '2024-08-09 20:25:09',
            ),
            15 => 
            array (
                'id' => 18,
                'name' => 'salary_to',
                'alterlabels' => '{"cz": "Mzda do", "en": "Salary to", "ru": "Зарплата до"}',
                'altersuffixes' => '[]',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => NULL,
                'filter_layout' => NULL,
                'show_layout' => NULL,
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'created_at' => '2024-05-23 19:48:55',
                'updated_at' => '2024-06-06 15:02:42',
                'deleted_at' => '2024-06-06 15:02:42',
            ),
            16 => 
            array (
                'id' => 21,
                'name' => 'salary_type',
                'alterlabels' => '{"cz": "Typ platby", "en": "Salary type", "ru": "Тип оплаты"}',
                'altersuffixes' => '[]',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "7", "column_span": "1", "column_start": "1", "order_number": "4"}',
                'filter_layout' => '{"type": "checkbox_list", "section_id": "7", "column_span": "1", "column_start": "1", "order_number": "4"}',
                'show_layout' => '{"type": "select", "section_id": "7", "order_number": "4"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-05-24 16:48:19',
                'updated_at' => '2024-08-14 09:45:19',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 22,
                'name' => 'phone_ram',
            'alterlabels' => '{"cz": "RAM (operační paměť)", "en": "RAM (operating memory)", "ru": "RAM (оперативная память)"}',
                'altersuffixes' => '[]',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "8", "column_span": "1", "column_start": "1", "order_number": "1"}',
                'filter_layout' => '{"type": "checkbox_list", "section_id": "8", "column_span": "1", "column_start": "1", "order_number": "1"}',
                'show_layout' => '{"type": "select", "section_id": "8", "order_number": "1"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 0,
                'created_at' => '2024-05-25 14:58:39',
                'updated_at' => '2024-08-14 09:44:50',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 23,
                'name' => 'phone_rom',
            'alterlabels' => '{"cz": "ROM (zabudovaná paměť)", "en": "ROM (integrated memory)", "ru": "ROM (встроенная память)"}',
                'altersuffixes' => '[]',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "8", "column_span": "1", "column_start": "2", "order_number": "2"}',
                'filter_layout' => '{"type": "checkbox_list", "section_id": "8", "column_span": "1", "column_start": "2", "order_number": "2"}',
                'show_layout' => '{"type": "select", "section_id": "8", "order_number": "2"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 0,
                'created_at' => '2024-05-25 15:08:54',
                'updated_at' => '2024-08-14 09:44:56',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 24,
                'name' => 'display_diagonal',
                'alterlabels' => '{"cz": "Úhlopříčka displeje", "en": "Display diagonal", "ru": "Диагональ дисплея"}',
                'altersuffixes' => '{"cz": null, "en": "\\"", "ru": null}',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "9", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'filter_layout' => '{"type": "checkbox_list", "section_id": "9", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'show_layout' => '{"type": "select", "section_id": "9", "order_number": "1"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 0,
                'created_at' => '2024-05-25 15:15:31',
                'updated_at' => '2024-08-11 13:33:50',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 25,
                'name' => 'display_type',
                'alterlabels' => '{"cz": "Typ displeje ", "en": "Display type", "ru": "Тип дисплея"}',
                'altersuffixes' => '{"cz": null, "en": null, "ru": null}',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "9", "column_span": "2", "column_start": "3", "order_number": "2"}',
                'filter_layout' => '{"type": "checkbox_list", "section_id": "9", "column_span": "2", "column_start": "3", "order_number": "2"}',
                'show_layout' => '{"type": "select", "section_id": "9", "order_number": "2"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 0,
                'created_at' => '2024-05-25 15:17:15',
                'updated_at' => '2024-08-11 13:34:16',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 26,
                'name' => 'salary_from',
                'alterlabels' => '{"cz": "Mzda od", "en": "Salary from", "ru": "Зарплата от"}',
                'altersuffixes' => '{"cz": null, "en": null, "ru": null}',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => NULL,
                'filter_layout' => NULL,
                'show_layout' => NULL,
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'created_at' => '2024-05-26 14:27:52',
                'updated_at' => '2024-06-06 15:02:32',
                'deleted_at' => '2024-06-06 15:02:32',
            ),
            22 => 
            array (
                'id' => 27,
                'name' => 'geo_id',
                'alterlabels' => '{"cz": "Lokace", "en": "Location", "ru": "Расположение"}',
                'altersuffixes' => '{"cz": null, "en": null, "ru": null}',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "location", "section_id": "10", "column_span": "4", "column_start": "1", "order_number": "1"}',
                'filter_layout' => '{"type": "location", "section_id": "10", "column_span": "4", "column_start": "1", "order_number": "1"}',
                'show_layout' => '{"type": "location", "section_id": "10", "order_number": "1"}',
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'created_at' => '2024-05-28 09:01:30',
                'updated_at' => '2024-08-11 15:29:02',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 28,
                'name' => 'salary',
                'alterlabels' => '{"cz": "Mzda", "en": "Salary", "ru": "Зарплата"}',
                'altersuffixes' => '{"cz": null, "en": null, "ru": null}',
                'visible' => '[]',
                'hidden' => NULL,
                'create_layout' => '{"type": "from_to", "section_id": "7", "column_span": "3", "column_start": "1", "order_number": "1"}',
                'filter_layout' => '{"type": "from_to", "section_id": "7", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'show_layout' => '{"type": "from_to", "section_id": "12", "order_number": "1"}',
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'created_at' => '2024-06-03 13:54:15',
                'updated_at' => '2024-08-11 13:54:16',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 29,
                'name' => 'address',
                'alterlabels' => '{"cs": "Adresa", "en": "Address", "ru": "Адрес"}',
                'altersuffixes' => '[]',
                'visible' => NULL,
                'hidden' => NULL,
                'create_layout' => '{"type": "text_input", "rules": ["string"], "section_id": "10", "column_span": "3", "column_start": "1", "order_number": "2"}',
                'filter_layout' => '{"type": "hidden"}',
                'show_layout' => '{"type": "text_input", "section_id": "10", "order_number": "2"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-06-16 13:22:55',
                'updated_at' => '2024-08-14 10:15:28',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 30,
                'name' => 'type_of_object',
                'alterlabels' => '{"cs": "Typ objektu", "en": "Type of object", "ru": "Вид объекта"}',
                'altersuffixes' => '[]',
                'visible' => NULL,
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'filter_layout' => '{"type": "checkbox_list", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'show_layout' => '{"type": "select", "section_id": "5", "order_number": "1"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-07-15 12:31:43',
                'updated_at' => '2024-08-11 13:37:58',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 31,
                'name' => 'number_of_rooms',
                'alterlabels' => '{"cs": "Počet pokojů", "en": "Number of rooms", "ru": "Количество комнат"}',
                'altersuffixes' => '{"cs": null, "en": null, "ru": null}',
                'visible' => NULL,
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "3"}',
                'filter_layout' => '{"type": "checkbox_list", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "3"}',
                'show_layout' => '{"type": "select", "section_id": "5", "order_number": "3"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-07-15 12:36:20',
                'updated_at' => '2024-08-11 13:40:54',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 32,
                'name' => 'title',
                'alterlabels' => '{"cs": "Název", "en": "Title", "ru": "Заголовок"}',
                'altersuffixes' => '[]',
                'visible' => NULL,
                'hidden' => NULL,
                'create_layout' => '{"type": "text_input", "rules": ["string"], "section_id": "1", "column_span": "4", "column_start": "1", "order_number": "2"}',
                'filter_layout' => '{"type": "hidden"}',
                'show_layout' => '{"type": "text_input", "section_id": "11", "order_number": "1"}',
                'translatable' => 1,
                'is_feature' => 0,
                'required' => 1,
                'created_at' => '2024-07-17 10:42:21',
                'updated_at' => '2024-08-14 10:12:58',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 33,
                'name' => 'type_of_housing',
                'alterlabels' => '{"cs": "Typ ubytování", "en": "Type of housing", "ru": "Тип жилья"}',
                'altersuffixes' => '[]',
                'visible' => NULL,
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'filter_layout' => '{"type": "toggle_buttons", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'show_layout' => '{"type": "select", "section_id": "5", "order_number": "1"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-07-17 11:32:19',
                'updated_at' => '2024-08-11 13:48:20',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 34,
                'name' => 'type_of_object_garage',
                'alterlabels' => '{"cs": "Typ objektu", "en": "Type of object", "ru": "Тип объекта"}',
                'altersuffixes' => '[]',
                'visible' => NULL,
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'filter_layout' => '{"type": "toggle_buttons", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'show_layout' => '{"type": "select", "section_id": "5", "order_number": "1"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-07-17 11:43:59',
                'updated_at' => '2024-08-11 13:45:06',
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 35,
                'name' => 'type_of_object_commercial',
                'alterlabels' => '{"cs": "Typ objektu", "en": "Type of object", "ru": "Тип объекта"}',
                'altersuffixes' => '[]',
                'visible' => NULL,
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'filter_layout' => '{"type": "checkbox_list", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'show_layout' => '{"type": "select", "section_id": "5", "order_number": "1"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-07-17 12:22:20',
                'updated_at' => '2024-08-11 13:38:59',
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 36,
                'name' => 'land_category',
                'alterlabels' => '{"cs": "Kategorie pozemků", "en": "Land category", "ru": "Категория земли"}',
                'altersuffixes' => '[]',
                'visible' => NULL,
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'filter_layout' => '{"type": "checkbox_list", "section_id": "5", "column_span": "2", "column_start": "1", "order_number": "1"}',
                'show_layout' => '{"type": "select", "section_id": "5", "order_number": "1"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-07-17 13:00:03',
                'updated_at' => '2024-08-11 13:39:18',
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 37,
                'name' => 'lessor',
                'alterlabels' => '{"cs": "Pronajímatel", "en": "Lessor", "ru": "Арендодатель"}',
                'altersuffixes' => '[]',
                'visible' => '[{"value": "5", "attribute_name": "real_estate_type"}, {"value": "78", "attribute_name": "real_estate_type"}]',
                'hidden' => NULL,
                'create_layout' => '{"type": "toggle_buttons", "section_id": "2", "column_span": "2", "column_start": "1", "order_number": "5"}',
                'filter_layout' => '{"type": "toggle_buttons", "section_id": "2", "column_span": "4", "column_start": "1", "order_number": "5"}',
                'show_layout' => '{"type": "toggle_buttons", "section_id": "2", "order_number": "5"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-07-17 13:06:54',
                'updated_at' => '2024-08-11 13:35:41',
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 38,
                'name' => 'agency_fee',
                'alterlabels' => '{"cs": "Poplatek realitní kanceláři", "en": "Agency fee", "ru": "Гонорар агентству"}',
                'altersuffixes' => '[]',
                'visible' => '[{"value": "98", "attribute_name": "lessor"}]',
                'hidden' => '[{"value": "97", "attribute_name": "lessor"}]',
                'create_layout' => '{"type": "price", "section_id": "2", "column_span": "3", "column_start": "1", "order_number": "6"}',
                'filter_layout' => '{"type": "hidden"}',
                'show_layout' => '{"type": "price", "section_id": "2", "order_number": "6"}',
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-07-17 13:11:31',
                'updated_at' => '2024-08-14 10:11:47',
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 39,
                'name' => 'ads',
                'alterlabels' => '{"cs": null, "en": null, "ru": null}',
                'altersuffixes' => '{"cs": null, "en": null, "ru": null}',
                'visible' => NULL,
                'hidden' => NULL,
                'create_layout' => NULL,
                'filter_layout' => NULL,
                'show_layout' => NULL,
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 0,
                'created_at' => '2024-07-23 10:14:42',
                'updated_at' => '2024-07-23 10:16:44',
                'deleted_at' => '2024-07-23 10:16:44',
            ),
            35 => 
            array (
                'id' => 40,
                'name' => 'number_of_doors',
                'alterlabels' => '{"cs": "Počet dveří", "en": "Number of doors", "ru": "Количество дверей"}',
                'altersuffixes' => '[]',
                'visible' => NULL,
                'hidden' => NULL,
                'create_layout' => NULL,
                'filter_layout' => NULL,
                'show_layout' => NULL,
                'translatable' => 0,
                'is_feature' => 1,
                'required' => 1,
                'created_at' => '2024-07-26 12:53:24',
                'updated_at' => '2024-07-28 11:48:48',
                'deleted_at' => '2024-07-28 11:48:48',
            ),
            36 => 
            array (
                'id' => 41,
                'name' => 'currency',
                'alterlabels' => '{"cs": "Měna", "en": "Currency", "ru": "Валюта"}',
                'altersuffixes' => '[]',
                'visible' => NULL,
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "2", "column_span": "1", "column_start": "4", "order_number": "2"}',
                'filter_layout' => '{"type": "hidden"}',
                'show_layout' => '{"type": "select", "section_id": "12", "order_number": "2"}',
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'created_at' => '2024-08-10 11:38:44',
                'updated_at' => '2024-08-14 10:25:51',
                'deleted_at' => NULL,
            ),
            37 => 
            array (
                'id' => 42,
                'name' => 'job_currency',
                'alterlabels' => '{"cs": "Měna", "en": "Currency", "ru": "Валюта"}',
                'altersuffixes' => '[]',
                'visible' => NULL,
                'hidden' => NULL,
                'create_layout' => '{"type": "select", "section_id": "7", "column_span": "1", "column_start": "4", "order_number": "2"}',
                'filter_layout' => '{"type": "hidden"}',
                'show_layout' => '{"type": "select", "section_id": "12", "order_number": "2"}',
                'translatable' => 0,
                'is_feature' => 0,
                'required' => 1,
                'created_at' => '2024-08-10 18:07:00',
                'updated_at' => '2024-08-14 09:45:04',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}