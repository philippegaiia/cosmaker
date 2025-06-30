<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Supply\IngredientCategory;

class IngredientCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('ingredient_categories')->delete();
        
        DB::table('ingredient_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Huiles et beurres',
                'code' => 'OB',
                'slug' => 'huiles-et-beurres',
                'parent_id' => NULL,
                'is_visible' => 1,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-12-27 06:33:00',
                'updated_at' => '2020-12-27 07:08:45',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Huiles essentielles',
                'code' => 'EO',
                'slug' => 'huiles-essentielles',
                'parent_id' => NULL,
                'is_visible' => 1,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-12-27 06:34:04',
                'updated_at' => '2020-12-27 07:21:55',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Extraits végétaux',
                'code' => 'BE',
                'slug' => 'extraits-vegetaux',
                'parent_id' => NULL,
                'is_visible' => 1,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-12-27 06:34:59',
                'updated_at' => '2020-12-27 07:42:23',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Parfums et arômes',
                'code' => 'FR',
                'slug' => 'parfums-aromes',
                'parent_id' => NULL,
                'is_visible' => 1,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-12-27 06:35:31',
                'updated_at' => '2020-12-27 07:28:12',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Terres et argiles',
                'code' => 'EC',
                'slug' => 'terres-argiles',
                'parent_id' => NULL,
                'is_visible' => 1,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-12-27 06:37:01',
                'updated_at' => '2020-12-27 07:45:27',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Acides gras',
                'code' => 'FA',
                'slug' => 'acides-gras',
                'parent_id' => NULL,
                'is_visible' => 1,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-12-27 06:44:40',
                'updated_at' => '2020-12-27 07:21:21',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Colorants',
                'code' => 'CO',
                'slug' => 'colorants',
                'parent_id' => NULL,
                'is_visible' => 1,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-12-27 06:51:24',
                'updated_at' => '2020-12-27 07:46:26',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Produits chimiques auxiliaires',
                'code' => 'CH',
                'slug' => 'chimie',
                'parent_id' => NULL,
                'is_visible' => 1,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-12-27 06:52:06',
                'updated_at' => '2020-12-27 07:46:41',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Packaging',
                'code' => 'PK',
                'slug' => 'packaging',
                'parent_id' => NULL,
                'is_visible' => 1,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-12-27 06:52:45',
                'updated_at' => '2020-12-27 07:45:58',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Cires',
                'code' => 'WA',
                'slug' => 'cires',
                'parent_id' => NULL,
                'is_visible' => 1,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-12-27 07:02:49',
                'updated_at' => '2020-12-27 07:36:03',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Glycols',
                'code' => 'GY',
                'slug' => 'glycols',
                'parent_id' => NULL,
                'is_visible' => 1,
                'description' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-12-27 08:30:10',
                'updated_at' => '2020-12-27 08:30:10',
            ),
        ));
        
        
    }
}