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
                'id' => 4,
                'attribute_id' => 4,
                'category_id' => 1,
            ),
            2 => 
            array (
                'id' => 5,
                'attribute_id' => 5,
                'category_id' => 1,
            ),
            3 => 
            array (
                'id' => 8,
                'attribute_id' => 8,
                'category_id' => 2,
            ),
            4 => 
            array (
                'id' => 9,
                'attribute_id' => 9,
                'category_id' => 2,
            ),
            5 => 
            array (
                'id' => 10,
                'attribute_id' => 10,
                'category_id' => 2,
            ),
            6 => 
            array (
                'id' => 11,
                'attribute_id' => 11,
                'category_id' => 2,
            ),
            7 => 
            array (
                'id' => 12,
                'attribute_id' => 12,
                'category_id' => 2,
            ),
            8 => 
            array (
                'id' => 13,
                'attribute_id' => 13,
                'category_id' => 2,
            ),
            9 => 
            array (
                'id' => 14,
                'attribute_id' => 14,
                'category_id' => 2,
            ),
            10 => 
            array (
                'id' => 15,
                'attribute_id' => 15,
                'category_id' => 2,
            ),
            11 => 
            array (
                'id' => 16,
                'attribute_id' => 16,
                'category_id' => 2,
            ),
            12 => 
            array (
                'id' => 17,
                'attribute_id' => 2,
                'category_id' => 4,
            ),
            13 => 
            array (
                'id' => 21,
                'attribute_id' => 2,
                'category_id' => 3,
            ),
            14 => 
            array (
                'id' => 25,
                'attribute_id' => 21,
                'category_id' => 3,
            ),
            15 => 
            array (
                'id' => 26,
                'attribute_id' => 22,
                'category_id' => 5,
            ),
            16 => 
            array (
                'id' => 27,
                'attribute_id' => 23,
                'category_id' => 5,
            ),
            17 => 
            array (
                'id' => 28,
                'attribute_id' => 24,
                'category_id' => 5,
            ),
            18 => 
            array (
                'id' => 29,
                'attribute_id' => 25,
                'category_id' => 5,
            ),
            19 => 
            array (
                'id' => 31,
                'attribute_id' => 27,
                'category_id' => 1,
            ),
            20 => 
            array (
                'id' => 32,
                'attribute_id' => 27,
                'category_id' => 3,
            ),
            21 => 
            array (
                'id' => 33,
                'attribute_id' => 27,
                'category_id' => 4,
            ),
            22 => 
            array (
                'id' => 34,
                'attribute_id' => 6,
                'category_id' => 6,
            ),
            23 => 
            array (
                'id' => 44,
                'attribute_id' => 28,
                'category_id' => 3,
            ),
            24 => 
            array (
                'id' => 45,
                'attribute_id' => 4,
                'category_id' => 4,
            ),
            25 => 
            array (
                'id' => 46,
                'attribute_id' => 5,
                'category_id' => 4,
            ),
            26 => 
            array (
                'id' => 47,
                'attribute_id' => 29,
                'category_id' => 1,
            ),
            27 => 
            array (
                'id' => 51,
                'attribute_id' => 29,
                'category_id' => 8,
            ),
            28 => 
            array (
                'id' => 52,
                'attribute_id' => 6,
                'category_id' => 8,
            ),
            29 => 
            array (
                'id' => 53,
                'attribute_id' => 6,
                'category_id' => 27,
            ),
            30 => 
            array (
                'id' => 56,
                'attribute_id' => 14,
                'category_id' => 18,
            ),
            31 => 
            array (
                'id' => 57,
                'attribute_id' => 16,
                'category_id' => 18,
            ),
            32 => 
            array (
                'id' => 58,
                'attribute_id' => 9,
                'category_id' => 18,
            ),
            33 => 
            array (
                'id' => 59,
                'attribute_id' => 10,
                'category_id' => 18,
            ),
            34 => 
            array (
                'id' => 60,
                'attribute_id' => 11,
                'category_id' => 18,
            ),
            35 => 
            array (
                'id' => 61,
                'attribute_id' => 12,
                'category_id' => 18,
            ),
            36 => 
            array (
                'id' => 62,
                'attribute_id' => 13,
                'category_id' => 18,
            ),
            37 => 
            array (
                'id' => 63,
                'attribute_id' => 15,
                'category_id' => 18,
            ),
            38 => 
            array (
                'id' => 64,
                'attribute_id' => 6,
                'category_id' => 28,
            ),
            39 => 
            array (
                'id' => 65,
                'attribute_id' => 6,
                'category_id' => 29,
            ),
            40 => 
            array (
                'id' => 67,
                'attribute_id' => 30,
                'category_id' => 18,
            ),
            41 => 
            array (
                'id' => 69,
                'attribute_id' => 31,
                'category_id' => 18,
            ),
            42 => 
            array (
                'id' => 71,
                'attribute_id' => 6,
                'category_id' => 1,
            ),
            43 => 
            array (
                'id' => 72,
                'attribute_id' => 7,
                'category_id' => 1,
            ),
            44 => 
            array (
                'id' => 73,
                'attribute_id' => 32,
                'category_id' => 1,
            ),
            45 => 
            array (
                'id' => 74,
                'attribute_id' => 33,
                'category_id' => 19,
            ),
            46 => 
            array (
                'id' => 75,
                'attribute_id' => 16,
                'category_id' => 19,
            ),
            47 => 
            array (
                'id' => 76,
                'attribute_id' => 14,
                'category_id' => 19,
            ),
            48 => 
            array (
                'id' => 77,
                'attribute_id' => 8,
                'category_id' => 19,
            ),
            49 => 
            array (
                'id' => 78,
                'attribute_id' => 11,
                'category_id' => 19,
            ),
            50 => 
            array (
                'id' => 79,
                'attribute_id' => 12,
                'category_id' => 19,
            ),
            51 => 
            array (
                'id' => 80,
                'attribute_id' => 15,
                'category_id' => 19,
            ),
            52 => 
            array (
                'id' => 81,
                'attribute_id' => 13,
                'category_id' => 19,
            ),
            53 => 
            array (
                'id' => 82,
                'attribute_id' => 9,
                'category_id' => 19,
            ),
            54 => 
            array (
                'id' => 83,
                'attribute_id' => 10,
                'category_id' => 19,
            ),
            55 => 
            array (
                'id' => 85,
                'attribute_id' => 34,
                'category_id' => 20,
            ),
            56 => 
            array (
                'id' => 86,
                'attribute_id' => 16,
                'category_id' => 20,
            ),
            57 => 
            array (
                'id' => 87,
                'attribute_id' => 16,
                'category_id' => 21,
            ),
            58 => 
            array (
                'id' => 88,
                'attribute_id' => 16,
                'category_id' => 22,
            ),
            59 => 
            array (
                'id' => 89,
                'attribute_id' => 35,
                'category_id' => 21,
            ),
            60 => 
            array (
                'id' => 90,
                'attribute_id' => 36,
                'category_id' => 22,
            ),
            61 => 
            array (
                'id' => 91,
                'attribute_id' => 37,
                'category_id' => 1,
            ),
            62 => 
            array (
                'id' => 92,
                'attribute_id' => 38,
                'category_id' => 1,
            ),
            63 => 
            array (
                'id' => 93,
                'attribute_id' => 32,
                'category_id' => 3,
            ),
            64 => 
            array (
                'id' => 106,
                'attribute_id' => 42,
                'category_id' => 3,
            ),
            65 => 
            array (
                'id' => 107,
                'attribute_id' => 32,
                'category_id' => 4,
            ),
            66 => 
            array (
                'id' => 108,
                'attribute_id' => 32,
                'category_id' => 9,
            ),
            67 => 
            array (
                'id' => 109,
                'attribute_id' => 32,
                'category_id' => 10,
            ),
            68 => 
            array (
                'id' => 110,
                'attribute_id' => 32,
                'category_id' => 11,
            ),
            69 => 
            array (
                'id' => 111,
                'attribute_id' => 32,
                'category_id' => 12,
            ),
            70 => 
            array (
                'id' => 112,
                'attribute_id' => 32,
                'category_id' => 13,
            ),
            71 => 
            array (
                'id' => 113,
                'attribute_id' => 32,
                'category_id' => 14,
            ),
            72 => 
            array (
                'id' => 114,
                'attribute_id' => 32,
                'category_id' => 15,
            ),
            73 => 
            array (
                'id' => 115,
                'attribute_id' => 32,
                'category_id' => 16,
            ),
            74 => 
            array (
                'id' => 116,
                'attribute_id' => 32,
                'category_id' => 17,
            ),
            75 => 
            array (
                'id' => 117,
                'attribute_id' => 2,
                'category_id' => 9,
            ),
            76 => 
            array (
                'id' => 118,
                'attribute_id' => 2,
                'category_id' => 10,
            ),
            77 => 
            array (
                'id' => 119,
                'attribute_id' => 2,
                'category_id' => 11,
            ),
            78 => 
            array (
                'id' => 120,
                'attribute_id' => 2,
                'category_id' => 12,
            ),
            79 => 
            array (
                'id' => 121,
                'attribute_id' => 2,
                'category_id' => 13,
            ),
            80 => 
            array (
                'id' => 122,
                'attribute_id' => 2,
                'category_id' => 14,
            ),
            81 => 
            array (
                'id' => 123,
                'attribute_id' => 2,
                'category_id' => 15,
            ),
            82 => 
            array (
                'id' => 124,
                'attribute_id' => 2,
                'category_id' => 16,
            ),
            83 => 
            array (
                'id' => 125,
                'attribute_id' => 2,
                'category_id' => 17,
            ),
            84 => 
            array (
                'id' => 127,
                'attribute_id' => 4,
                'category_id' => 9,
            ),
            85 => 
            array (
                'id' => 128,
                'attribute_id' => 4,
                'category_id' => 10,
            ),
            86 => 
            array (
                'id' => 129,
                'attribute_id' => 4,
                'category_id' => 11,
            ),
            87 => 
            array (
                'id' => 130,
                'attribute_id' => 4,
                'category_id' => 12,
            ),
            88 => 
            array (
                'id' => 131,
                'attribute_id' => 4,
                'category_id' => 13,
            ),
            89 => 
            array (
                'id' => 132,
                'attribute_id' => 4,
                'category_id' => 14,
            ),
            90 => 
            array (
                'id' => 133,
                'attribute_id' => 4,
                'category_id' => 15,
            ),
            91 => 
            array (
                'id' => 134,
                'attribute_id' => 4,
                'category_id' => 16,
            ),
            92 => 
            array (
                'id' => 135,
                'attribute_id' => 4,
                'category_id' => 17,
            ),
            93 => 
            array (
                'id' => 136,
                'attribute_id' => 29,
                'category_id' => 3,
            ),
            94 => 
            array (
                'id' => 137,
                'attribute_id' => 29,
                'category_id' => 4,
            ),
            95 => 
            array (
                'id' => 138,
                'attribute_id' => 29,
                'category_id' => 9,
            ),
            96 => 
            array (
                'id' => 139,
                'attribute_id' => 29,
                'category_id' => 10,
            ),
            97 => 
            array (
                'id' => 140,
                'attribute_id' => 29,
                'category_id' => 11,
            ),
            98 => 
            array (
                'id' => 141,
                'attribute_id' => 29,
                'category_id' => 12,
            ),
            99 => 
            array (
                'id' => 142,
                'attribute_id' => 29,
                'category_id' => 13,
            ),
            100 => 
            array (
                'id' => 143,
                'attribute_id' => 29,
                'category_id' => 14,
            ),
            101 => 
            array (
                'id' => 144,
                'attribute_id' => 29,
                'category_id' => 15,
            ),
            102 => 
            array (
                'id' => 145,
                'attribute_id' => 29,
                'category_id' => 16,
            ),
            103 => 
            array (
                'id' => 146,
                'attribute_id' => 29,
                'category_id' => 17,
            ),
        ));
        
        
    }
}