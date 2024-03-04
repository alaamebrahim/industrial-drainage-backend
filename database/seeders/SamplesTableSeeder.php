<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SamplesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('samples')->delete();
        
        \DB::table('samples')->insert(array (
            0 => 
            array (
                'id' => 1,
            'name' => 'الأكسجين الحيوي الممتص (BOD)',
                'created_at' => '2024-03-04 07:52:33',
                'updated_at' => '2024-03-04 07:52:33',
            ),
            1 => 
            array (
                'id' => 2,
            'name' => 'المواد الصلبة العالقة (TSS)',
                'created_at' => '2024-03-04 07:54:22',
                'updated_at' => '2024-03-04 07:54:22',
            ),
            2 => 
            array (
                'id' => 3,
            'name' => 'الأكسجين الكيميائي الممتص (COD)',
                'created_at' => '2024-03-04 07:54:42',
                'updated_at' => '2024-03-04 07:54:42',
            ),
            3 => 
            array (
                'id' => 4,
            'name' => 'الأس الهيدروجيني (PH)',
                'created_at' => '2024-03-04 07:55:22',
                'updated_at' => '2024-03-04 07:55:22',
            ),
            4 => 
            array (
                'id' => 5,
            'name' => 'الزيوت والشحوم (o & G)',
                'created_at' => '2024-03-04 07:56:08',
                'updated_at' => '2024-03-04 07:56:08',
            ),
        ));
        
        
    }
}