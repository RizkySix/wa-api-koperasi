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
            'name' => 'Parau Koperasi',
            'phone' => '6285792718157'
         ]);

         $myKoperasi->bot()->create([
            'wa_phone' => '6285792718157',
            'app_key' => 'acaceea1-7480-4620-8284-d5cfb120d6df'
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
