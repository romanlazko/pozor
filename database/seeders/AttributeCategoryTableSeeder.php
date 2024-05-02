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
                'id' => 1,
                'attribute_id' => 1,
                'category_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'attribute_id' => 4,
                'category_id' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'attribute_id' => 2,
                'category_id' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'attribute_id' => 3,
                'category_id' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'attribute_id' => 5,
                'category_id' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'attribute_id' => 6,
                'category_id' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'attribute_id' => 1,
                'category_id' => 2,
            ),
            7 => 
            array (
                'id' => 8,
                'attribute_id' => 4,
                'category_id' => 2,
            ),
            8 => 
            array (
                'id' => 9,
                'attribute_id' => 5,
                'category_id' => 2,
            ),
            9 => 
            array (
                'id' => 10,
                'attribute_id' => 6,
                'category_id' => 2,
            ),
            10 => 
            array (
                'id' => 11,
                'attribute_id' => 7,
                'category_id' => 3,
            ),
            11 => 
            array (
                'id' => 12,
                'attribute_id' => 8,
                'category_id' => 1,
            ),
            12 => 
            array (
                'id' => 13,
                'attribute_id' => 9,
                'category_id' => 4,
            ),
            13 => 
            array (
                'id' => 14,
                'attribute_id' => 10,
                'category_id' => 1,
            ),
            14 => 
            array (
                'id' => 15,
                'attribute_id' => 11,
                'category_id' => 1,
            ),
            15 => 
            array (
                'id' => 16,
                'attribute_id' => 11,
                'category_id' => 2,
            ),
            16 => 
            array (
                'id' => 17,
                'attribute_id' => 8,
                'category_id' => 2,
            ),
            17 => 
            array (
                'id' => 18,
                'attribute_id' => 1,
                'category_id' => 7,
            ),
            18 => 
            array (
                'id' => 19,
                'attribute_id' => 4,
                'category_id' => 7,
            ),
            19 => 
            array (
                'id' => 20,
                'attribute_id' => 11,
                'category_id' => 7,
            ),
            20 => 
            array (
                'id' => 21,
                'attribute_id' => 5,
                'category_id' => 7,
            ),
            21 => 
            array (
                'id' => 22,
                'attribute_id' => 6,
                'category_id' => 7,
            ),
            22 => 
            array (
                'id' => 23,
                'attribute_id' => 8,
                'category_id' => 7,
            ),
            23 => 
            array (
                'id' => 24,
                'attribute_id' => 12,
                'category_id' => 17,
            ),
            24 => 
            array (
                'id' => 25,
                'attribute_id' => 1,
                'category_id' => 18,
            ),
            25 => 
            array (
                'id' => 26,
                'attribute_id' => 4,
                'category_id' => 18,
            ),
            26 => 
            array (
                'id' => 27,
                'attribute_id' => 11,
                'category_id' => 18,
            ),
            27 => 
            array (
                'id' => 28,
                'attribute_id' => 5,
                'category_id' => 18,
            ),
            28 => 
            array (
                'id' => 29,
                'attribute_id' => 6,
                'category_id' => 18,
            ),
            29 => 
            array (
                'id' => 30,
                'attribute_id' => 8,
                'category_id' => 18,
            ),
        ));
        
        
    }
}