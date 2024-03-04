<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SampleDetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sample_details')->delete();
        
        \DB::table('sample_details')->insert(array (
            0 => 
            array (
                'id' => 3,
                'sample_id' => 1,
                'description' => 'من صفر وحتى 600 جم/ل',
                'price' => 1,
                'duration' => NULL,
                'created_at' => '2024-03-04 08:49:44',
                'updated_at' => '2024-03-04 08:49:44',
            ),
            1 => 
            array (
                'id' => 4,
                'sample_id' => 1,
                'description' => 'أكثر من 600 وحتى 660',
                'price' => 3,
                'duration' => '6 شهور',
                'created_at' => '2024-03-04 08:56:16',
                'updated_at' => '2024-03-04 08:56:16',
            ),
            2 => 
            array (
                'id' => 5,
                'sample_id' => 1,
                'description' => 'أكثر من 600 وحتى أقل من 2000',
                'price' => 9,
                'duration' => '3 شهور',
                'created_at' => '2024-03-04 08:57:19',
                'updated_at' => '2024-03-04 08:57:19',
            ),
            3 => 
            array (
                'id' => 6,
                'sample_id' => 1,
                'description' => 'أكثر من 2000',
                'price' => 18,
                'duration' => 'أسبوعين',
                'created_at' => '2024-03-04 08:57:47',
                'updated_at' => '2024-03-04 08:57:47',
            ),
            4 => 
            array (
                'id' => 7,
                'sample_id' => 2,
                'description' => 'من صفر وحتى 800 جم/ل',
                'price' => 1,
                'duration' => NULL,
                'created_at' => '2024-03-04 08:58:14',
                'updated_at' => '2024-03-04 08:58:14',
            ),
            5 => 
            array (
                'id' => 8,
                'sample_id' => 2,
                'description' => 'أكثر من 800 وحتى أقل من 880',
                'price' => 2,
                'duration' => '6 شهور',
                'created_at' => '2024-03-04 08:58:39',
                'updated_at' => '2024-03-04 08:58:39',
            ),
            6 => 
            array (
                'id' => 9,
                'sample_id' => 2,
                'description' => 'أكثر من 880 وحتى أقل من 3000',
                'price' => 5,
                'duration' => '3 شهور',
                'created_at' => '2024-03-04 08:58:58',
                'updated_at' => '2024-03-04 08:58:58',
            ),
            7 => 
            array (
                'id' => 10,
                'sample_id' => 2,
                'description' => 'أكثر من 3000',
                'price' => 15,
                'duration' => 'أسبوع',
                'created_at' => '2024-03-04 08:59:17',
                'updated_at' => '2024-03-04 08:59:17',
            ),
            8 => 
            array (
                'id' => 11,
                'sample_id' => 3,
                'description' => 'أكثر من 1100 وحتى أقل من 2000',
                'price' => 6,
                'duration' => '3 شهور',
                'created_at' => '2024-03-04 09:00:09',
                'updated_at' => '2024-03-04 09:00:09',
            ),
            9 => 
            array (
                'id' => 12,
                'sample_id' => 3,
                'description' => 'أكثر من 2000 وحتى أقل من 5000',
                'price' => 18,
                'duration' => 'شهرين',
                'created_at' => '2024-03-04 09:00:59',
                'updated_at' => '2024-03-04 09:00:59',
            ),
            10 => 
            array (
                'id' => 13,
                'sample_id' => 3,
                'description' => 'أكثر من 5000',
                'price' => 30,
                'duration' => 'أسبوع',
                'created_at' => '2024-03-04 09:01:16',
                'updated_at' => '2024-03-04 09:01:16',
            ),
            11 => 
            array (
                'id' => 14,
                'sample_id' => 4,
                'description' => 'أقل من 2 وأكبر من 12',
                'price' => 60,
                'duration' => 'أسبوع',
                'created_at' => '2024-03-04 09:01:38',
                'updated_at' => '2024-03-04 09:01:38',
            ),
            12 => 
            array (
                'id' => 15,
                'sample_id' => 4,
                'description' => 'من 2 وحتى 6 ومن 9.5 وحتى 12',
                'price' => 30,
                'duration' => 'أسبوعين',
                'created_at' => '2024-03-04 09:01:58',
                'updated_at' => '2024-03-04 09:01:58',
            ),
            13 => 
            array (
                'id' => 17,
                'sample_id' => 5,
                'description' => 'أكثر من 1000',
                'price' => 25,
                'duration' => 'أسبوعين',
                'created_at' => '2024-03-04 09:02:39',
                'updated_at' => '2024-03-04 09:02:39',
            ),
            14 => 
            array (
                'id' => 16,
                'sample_id' => 5,
                'description' => 'أكثر من 100 وأقل من 1000',
                'price' => 10,
                'duration' => 'شهر',
                'created_at' => '2024-03-04 09:02:22',
                'updated_at' => '2024-03-04 09:21:08',
            ),
        ));
        
        
    }
}