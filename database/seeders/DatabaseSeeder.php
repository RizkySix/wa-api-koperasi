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
         $myKoperasi = Koperasi::factory()->create([
            'name' => 'Moka Koperasi',
            'phone' => '6287861189600'
         ]);

         $myKoperasi->bot()->create([
            'wa_phone' => '6287861189600',
            'app_key' => 'cba02c6f-3dc5-47be-a6f6-ad8e27595f2f'
         ]);

         $myKoperasi2 = Koperasi::factory()->create([
            'name' => 'Parau Koperasi',
            'phone' => '6285792718157'
         ]);

         $myKoperasi2->bot()->create([
            'wa_phone' => '6285792718157',
            'app_key' => 'a821c4aa-afd0-4f72-8809-ef66d0498128'
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
