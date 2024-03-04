<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('clients')->delete();
        
        \DB::table('clients')->insert(array (
            0 => 
            array (
                'id' => 1,
                'client_key' => '100037145',
            'name' => 'الدسوقى طه غراب (مصنع بورسلين)',
                'address' => 'قطعة 2و3و4و5و6 بلوك ط الصناعية',
            'letter_heading' => 'السادة/ مصنع الدسوقى طه غراب (مصنع بورسلين)',
                'last_consumption' => 832,
                'is_active' => true,
                'created_at' => '2024-03-04 07:04:16',
                'updated_at' => '2024-03-04 07:04:16',
            ),
        ));
        
        
    }
}