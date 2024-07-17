<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeCategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('attribute_category')->delete();
        
        \DB::table('attribute_category')->insert(array (
            0 => 
            array (
                'id' => 2,
                'attribute_id' => 2,
                'category_id' => 1,
            ),
            1 => 
            array (
                'id' => 3,
                'attribute_id' => 3,
                'category_id' => 1,
            ),
            2 => 
            array (
                'id' => 4,
                'attribute_id' => 4,
                'category_id' => 1,
            ),
            3 => 
            array (
                'id' => 5,
                'attribute_id' => 5,
                'category_id' => 1,
            ),
            4 => 
            array (
                'id' => 8,
                'attribute_id' => 8,
                'category_id' => 2,
            ),
            5 => 
            array (
                'id' => 9,
                'attribute_id' => 9,
                'category_id' => 2,
            ),
            6 => 
            array (
                'id' => 10,
                'attribute_id' => 10,
                'category_id' => 2,
            ),
            7 => 
            array (
                'id' => 11,
                'attribute_id' => 11,
                'category_id' => 2,
            ),
            8 => 
            array (
                'id' => 12,
                'attribute_id' => 12,
                'category_id' => 2,
            ),
            9 => 
            array (
                'id' => 13,
                'attribute_id' => 13,
                'category_id' => 2,
            ),
            10 => 
            array (
                'id' => 14,
                'attribute_id' => 14,
                'category_id' => 2,
            ),
            11 => 
            array (
                'id' => 15,
                'attribute_id' => 15,
                'category_id' => 2,
            ),
            12 => 
            array (
                'id' => 16,
                'attribute_id' => 16,
                'category_id' => 2,
            ),
            13 => 
            array (
                'id' => 17,
                'attribute_id' => 2,
                'category_id' => 4,
            ),
            14 => 
            array (
                'id' => 18,
                'attribute_id' => 1,
                'category_id' => 4,
            ),
            15 => 
            array (
                'id' => 21,
                'attribute_id' => 2,
                'category_id' => 3,
            ),
            16 => 
            array (
                'id' => 23,
                'attribute_id' => 19,
                'category_id' => 3,
            ),
            17 => 
            array (
                'id' => 24,
                'attribute_id' => 20,
                'category_id' => 1,
            ),
            18 => 
            array (
                'id' => 25,
                'attribute_id' => 21,
                'category_id' => 3,
            ),
            19 => 
            array (
                'id' => 26,
                'attribute_id' => 22,
                'category_id' => 5,
            ),
            20 => 
            array (
                'id' => 27,
                'attribute_id' => 23,
                'category_id' => 5,
            ),
            21 => 
            array (
                'id' => 28,
                'attribute_id' => 24,
                'category_id' => 5,
            ),
            22 => 
            array (
                'id' => 29,
                'attribute_id' => 25,
                'category_id' => 5,
            ),
            23 => 
            array (
                'id' => 31,
                'attribute_id' => 27,
                'category_id' => 1,
            ),
            24 => 
            array (
                'id' => 32,
                'attribute_id' => 27,
                'category_id' => 3,
            ),
            25 => 
            array (
                'id' => 33,
                'attribute_id' => 27,
                'category_id' => 4,
            ),
            26 => 
            array (
                'id' => 34,
                'attribute_id' => 6,
                'category_id' => 6,
            ),
            27 => 
            array (
                'id' => 44,
                'attribute_id' => 28,
                'category_id' => 3,
            ),
            28 => 
            array (
                'id' => 45,
                'attribute_id' => 4,
                'category_id' => 4,
            ),
            29 => 
            array (
                'id' => 46,
                'attribute_id' => 5,
                'category_id' => 4,
            ),
            30 => 
            array (
                'id' => 47,
                'attribute_id' => 29,
                'category_id' => 1,
            ),
            31 => 
            array (
                'id' => 51,
                'attribute_id' => 29,
                'category_id' => 8,
            ),
            32 => 
            array (
                'id' => 52,
                'attribute_id' => 6,
                'category_id' => 8,
            ),
            33 => 
            array (
                'id' => 53,
                'attribute_id' => 6,
                'category_id' => 27,
            ),
            34 => 
            array (
                'id' => 56,
                'attribute_id' => 14,
                'category_id' => 18,
            ),
            35 => 
            array (
                'id' => 57,
                'attribute_id' => 16,
                'category_id' => 18,
            ),
            36 => 
            array (
                'id' => 58,
                'attribute_id' => 9,
                'category_id' => 18,
            ),
            37 => 
            array (
                'id' => 59,
                'attribute_id' => 10,
                'category_id' => 18,
            ),
            38 => 
            array (
                'id' => 60,
                'attribute_id' => 11,
                'category_id' => 18,
            ),
            39 => 
            array (
                'id' => 61,
                'attribute_id' => 12,
                'category_id' => 18,
            ),
            40 => 
            array (
                'id' => 62,
                'attribute_id' => 13,
                'category_id' => 18,
            ),
            41 => 
            array (
                'id' => 63,
                'attribute_id' => 15,
                'category_id' => 18,
            ),
            42 => 
            array (
                'id' => 64,
                'attribute_id' => 6,
                'category_id' => 28,
            ),
            43 => 
            array (
                'id' => 65,
                'attribute_id' => 6,
                'category_id' => 29,
            ),
            44 => 
            array (
                'id' => 67,
                'attribute_id' => 30,
                'category_id' => 18,
            ),
            45 => 
            array (
                'id' => 69,
                'attribute_id' => 31,
                'category_id' => 18,
            ),
            46 => 
            array (
                'id' => 71,
                'attribute_id' => 6,
                'category_id' => 1,
            ),
            47 => 
            array (
                'id' => 72,
                'attribute_id' => 7,
                'category_id' => 1,
            ),
            48 => 
            array (
                'id' => 73,
                'attribute_id' => 32,
                'category_id' => 1,
            ),
            49 => 
            array (
                'id' => 74,
                'attribute_id' => 33,
                'category_id' => 19,
            ),
            50 => 
            array (
                'id' => 75,
                'attribute_id' => 16,
                'category_id' => 19,
            ),
            51 => 
            array (
                'id' => 76,
                'attribute_id' => 14,
                'category_id' => 19,
            ),
            52 => 
            array (
                'id' => 77,
                'attribute_id' => 8,
                'category_id' => 19,
            ),
            53 => 
            array (
                'id' => 78,
                'attribute_id' => 11,
                'category_id' => 19,
            ),
            54 => 
            array (
                'id' => 79,
                'attribute_id' => 12,
                'category_id' => 19,
            ),
            55 => 
            array (
                'id' => 80,
                'attribute_id' => 15,
                'category_id' => 19,
            ),
            56 => 
            array (
                'id' => 81,
                'attribute_id' => 13,
                'category_id' => 19,
            ),
            57 => 
            array (
                'id' => 82,
                'attribute_id' => 9,
                'category_id' => 19,
            ),
            58 => 
            array (
                'id' => 83,
                'attribute_id' => 10,
                'category_id' => 19,
            ),
            59 => 
            array (
                'id' => 85,
                'attribute_id' => 34,
                'category_id' => 20,
            ),
            60 => 
            array (
                'id' => 86,
                'attribute_id' => 16,
                'category_id' => 20,
            ),
            61 => 
            array (
                'id' => 87,
                'attribute_id' => 16,
                'category_id' => 21,
            ),
            62 => 
            array (
                'id' => 88,
                'attribute_id' => 16,
                'category_id' => 22,
            ),
            63 => 
            array (
                'id' => 89,
                'attribute_id' => 35,
                'category_id' => 21,
            ),
            64 => 
            array (
                'id' => 90,
                'attribute_id' => 36,
                'category_id' => 22,
            ),
            65 => 
            array (
                'id' => 91,
                'attribute_id' => 37,
                'category_id' => 1,
            ),
            66 => 
            array (
                'id' => 92,
                'attribute_id' => 38,
                'category_id' => 1,
            ),
        ));
        
        
    }
}