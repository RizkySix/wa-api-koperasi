<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Koperasi;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         /* $myKoperasi = Koperasi::factory()->create([
            'name' => 'Moka Koperasi',
            'phone' => '6287762582176'
         ]);

         $myKoperasi->bot()->create([
            'wa_phone' => '6287762582176',
            'app_key' => 'd554c3fb-43af-41c2-8a8a-5a46490470e7'
         ]); */

         $myKoperasi2 = Koperasi::factory()->create([
            'name' => 'Parau Koperasi',
            'phone' => '6285792718157'
         ]);

         $myKoperasi2->bot()->create([
            'wa_phone' => '6285792718157',
            'app_key' => '1f2547c1-4b06-4eb3-8025-8db758871331'
         ]);


        

          $koperasies = Koperasi::factory(5)->create()
            ->each(function($koperasi) {
                $koperasi->bot()->create([
                    'wa_phone' => fake()->phoneNumber()
                ]);
            });
      
        $users = User::factory(25)->create()
        ->each(function ($user) use ($koperasies) {
          
            $koperasi = $koperasies->random();
    
           
            $user->koperasies()->attach($koperasi, ['user_nik' => $user->nik]);
        });

          
    }
}
