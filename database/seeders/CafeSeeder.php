<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CafeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Kategori Dulu
        $categories = [
            ['name' => 'Coffee Based', 'slug' => 'coffee-based'],
            ['name' => 'Non-Coffee', 'slug' => 'non-coffee'],
            ['name' => 'Light Meals', 'slug' => 'light-meals'],
            ['name' => 'Desserts', 'slug' => 'desserts'],
        ];

        foreach ($categories as $cat) {
            $catId = DB::table('categories')->insertGetId([
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Buat Produk untuk setiap kategori (Total 25+)
            $menus = $this->getMenuData($cat['name']);
            
            foreach ($menus as $menu) {
                DB::table('products')->insert([
                    'categorie_id' => $catId,
                    'name' => $menu['name'],
                    'slug' => Str::slug($menu['name']) . '-' . rand(100, 999),
                    'description' => $menu['desc'],
                    'price' => $menu['price'],
                    'stock' => rand(10, 50),
                    'image' => null, // Nanti bisa upload manual di Filament
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function getMenuData($category)
    {
        $data = [
            'Coffee Based' => [
                ['name' => 'Es Kopi Gula Aren', 'price' => 18000, 'desc' => 'Kopi susu murni dengan gula aren asli.'],
                ['name' => 'Caffe Latte', 'price' => 22000, 'desc' => 'Espresso dengan susu uap yang lembut.'],
                ['name' => 'Cappuccino', 'price' => 22000, 'desc' => 'Kopi dengan foam susu yang tebal.'],
                ['name' => 'Americano Ice', 'price' => 15000, 'desc' => 'Espresso shot dengan air dingin.'],
                ['name' => 'Caramel Macchiato', 'price' => 28000, 'desc' => 'Kopi manis dengan sirup caramel.'],
                ['name' => 'Manual Brew V60', 'price' => 25000, 'desc' => 'Kopi filter dengan biji pilihan.'],
            ],
            'Non-Coffee' => [
                ['name' => 'Matcha Latte', 'price' => 20000, 'desc' => 'Teh hijau Jepang dengan susu.'],
                ['name' => 'Chocolate Signature', 'price' => 20000, 'desc' => 'Cokelat pekat premium.'],
                ['name' => 'Red Velvet Ice', 'price' => 22000, 'desc' => 'Minuman varian red velvet yang creamy.'],
                ['name' => 'Earl Grey Tea', 'price' => 12000, 'desc' => 'Teh hitam dengan aroma bergamot.'],
                ['name' => 'Lemon Tea Fresh', 'price' => 10000, 'desc' => 'Teh segar dengan irisan lemon.'],
                ['name' => 'Thai Tea', 'price' => 15000, 'desc' => 'Teh khas Thailand yang manis.'],
            ],
            'Light Meals' => [
                ['name' => 'French Fries', 'price' => 15000, 'desc' => 'Kentang goreng renyah dengan saus sambal.'],
                ['name' => 'Cireng Krispi', 'price' => 12000, 'desc' => 'Cireng gurih dengan bumbu rujak.'],
                ['name' => 'Mix Platter', 'price' => 25000, 'desc' => 'Sosis, nugget, dan kentang dalam satu piring.'],
                ['name' => 'Roti Bakar Cokelat', 'price' => 18000, 'desc' => 'Roti bakar dengan toping cokelat melimpah.'],
                ['name' => 'Dimsum Ayam', 'price' => 20000, 'desc' => 'Dimsum isi 4 pcs dengan saus chili oil.'],
                ['name' => 'Nachos Cheese', 'price' => 22000, 'desc' => 'Keripik jagung dengan siraman saus keju.'],
            ],
            'Desserts' => [
                ['name' => 'Brownies Ice Cream', 'price' => 25000, 'desc' => 'Brownies hangat dengan satu scoop es krim vanilla.'],
                ['name' => 'Croffle Original', 'price' => 15000, 'desc' => 'Croissant waffle yang renyah dan manis.'],
                ['name' => 'Tiramisu Cake', 'price' => 30000, 'desc' => 'Kue khas Italia dengan aroma kopi.'],
                ['name' => 'Banana Split', 'price' => 25000, 'desc' => 'Pisang dengan 3 varian rasa es krim.'],
                ['name' => 'Pancake Strawberry', 'price' => 20000, 'desc' => 'Pancake lembut dengan selai strawberry.'],
                ['name' => 'Mochi Ice Cream', 'price' => 15000, 'desc' => 'Mochi kenyal isi es krim.'],
                ['name' => 'Churro Chocolate', 'price' => 18000, 'desc' => 'Donat spanyol dengan saus cokelat.'],
            ],
        ];

        return $data[$category] ?? [];
    }
}