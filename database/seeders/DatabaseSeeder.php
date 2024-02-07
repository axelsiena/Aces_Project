<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Ad;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    protected static ?string $password;

    public function run(): void
    {

        $categories = [
            ['title_it' => 'Elettronica', 'title_en' => 'Electronics', 'title_es' => ' Electrónica', 'icon' => 'fa-laptop'],
            ['title_it' => 'Motori', 'title_en' =>'Vehicles', 'title_es' => 'Motores', 'icon' => 'fa-car-side'],
            ['title_it' => 'Immobili', 'title_en' =>'Real Estate', 'title_es'=> 'Bienes raíces', 'icon' => 'fa-building'],
            ['title_it' => 'Lavoro', 'title_en' =>'Jobs', 'title_es'=> 'Trabajo', 'icon' => 'fa-briefcase'],
            ['title_it' => 'Arredamento', 'title_en' => 'Furniture', 'title_es'=> 'Mobiliario' , 'icon' => 'fa-hammer'],
            ['title_it' => 'Abbigliamento', 'title_en' => 'Clothing', 'title_es'=> 'Ropa','icon' => 'fa-shirt'],
            ['title_it' => 'Sport', 'title_en' =>'Sport' , 'title_es'=> 'Deportes','icon' => 'fa-table-tennis-paddle-ball'],
            ['title_it' => 'Animali', 'title_en' =>'Pets', 'title_es'=> 'Mascotas','icon' => 'fa-cat'],
            ['title_it' => 'Servizi', 'title_en' => 'Services', 'title_es'=> 'Servicios','icon' => 'fa-bell-concierge'],
            ['title_it' => 'Collezionismo', 'title_en' =>'Collectibles', 'title_es'=> 'Coleccionismo','icon' => 'fa-museum'],    
        ];

        foreach($categories as $category) {
            Category::create($category);
        }

        // User::factory(10)->create();

        // User::create([
        //     'name'=>'Revisore',
        //     'email'=>'revisor@presto.it',
        //     'password' => static::$password ??= Hash::make('password'),
        //     'is_revisor'=> true,
        //     'email_verified_at' => now(),            
        // ]);

        // Ad::factory(30)->create(); 
        
    }
}
