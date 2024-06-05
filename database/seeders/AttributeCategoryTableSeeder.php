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
                'id' => 20,
                'attribute_id' => 1,
                'category_id' => 3,
            ),
            16 => 
            array (
                'id' => 21,
                'attribute_id' => 2,
                'category_id' => 3,
            ),
            17 => 
            array (
                'id' => 23,
                'attribute_id' => 19,
                'category_id' => 3,
            ),
            18 => 
            array (
                'id' => 24,
                'attribute_id' => 20,
                'category_id' => 1,
            ),
            19 => 
            array (
                'id' => 25,
                'attribute_id' => 21,
                'category_id' => 3,
            ),
            20 => 
            array (
                'id' => 26,
                'attribute_id' => 22,
                'category_id' => 5,
            ),
            21 => 
            array (
                'id' => 27,
                'attribute_id' => 23,
                'category_id' => 5,
            ),
            22 => 
            array (
                'id' => 28,
                'attribute_id' => 24,
                'category_id' => 5,
            ),
            23 => 
            array (
                'id' => 29,
                'attribute_id' => 25,
                'category_id' => 5,
            ),
            24 => 
            array (
                'id' => 31,
                'attribute_id' => 27,
                'category_id' => 1,
            ),
            25 => 
            array (
                'id' => 32,
                'attribute_id' => 27,
                'category_id' => 3,
            ),
            26 => 
            array (
                'id' => 33,
                'attribute_id' => 27,
                'category_id' => 4,
            ),
            27 => 
            array (
                'id' => 34,
                'attribute_id' => 6,
                'category_id' => 6,
            ),
            28 => 
            array (
                'id' => 44,
                'attribute_id' => 28,
                'category_id' => 3,
            ),
        ));
        
        
    }
}