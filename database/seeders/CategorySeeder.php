<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'Računari i komponente', 'slug' => Str::slug('Računari i komponente')]);
        Category::create(['name' => 'Računari', 'parent_id' => '1', 'slug' => Str::slug('Računari')]);
        Category::create(['name' => 'Komponente', 'parent_id' => '1', 'slug' => Str::slug('Komponente')]);
        Category::create(['name' => 'Procesori', 'parent_id' => '3', 'slug' => Str::slug('Procesori')]);
        Category::create(['name' => 'Grafičke kartice', 'parent_id' => '3', 'slug' => Str::slug('Grafičke kartice')]);
        Category::create(['name' => 'Kuleri', 'parent_id' => '3', 'slug' => Str::slug('Kuleri')]);
        Category::create(['name' => 'HDD', 'parent_id' => '3', 'slug' => Str::slug('HDD')]);
        Category::create(['name' => 'Kućišta', 'parent_id' => '3', 'slug' => Str::slug('Kućišta')]);
        Category::create(['name' => 'RAM memorije', 'parent_id' => '3', 'slug' => Str::slug('RAM memorije')]);
        Category::create(['name' => 'Periferije', 'parent_id' => '1', 'slug' => Str::slug('Periferije')]);
        Category::create(['name' => 'Miševi', 'parent_id' => '10', 'slug' => Str::slug('Miševi')]);
        Category::create(['name' => 'Tastature', 'parent_id' => '10', 'slug' => Str::slug('Tastature')]);
        Category::create(['name' => 'USB Memorija', 'parent_id' => '10', 'slug' => Str::slug('USB Memorija')]);
        Category::create(['name' => 'Podloge za miš', 'parent_id' => '10', 'slug' => Str::slug('Podloge za miš')]);
        Category::create(['name' => 'Telefoni', 'slug' => Str::slug('Telefoni')]);
        Category::create(['name' => 'Mobilni telefoni', 'parent_id' => '15', 'slug' => Str::slug('Mobilni telefoni')]);
        Category::create(['name' => 'Mobilni telefoni', 'parent_id' => '16', 'slug' => Str::slug('Mobilni telefoni')]);
        Category::create(['name' => 'Bluetooth slušalice', 'parent_id' => '16', 'slug' => Str::slug('Bluetooth slušalice')]);
        Category::create(['name' => 'Memorijske kartice', 'parent_id' => '16', 'slug' => Str::slug('Memorijske kartice')]);
        Category::create(['name' => 'Torbice za telefon', 'parent_id' => '16', 'slug' => Str::slug('Torbice za telefon')]);
        Category::create(['name' => 'Fiksni telefoni', 'parent_id' => '15', 'slug' => Str::slug('Fiksni telefoni')]);
    }
}
