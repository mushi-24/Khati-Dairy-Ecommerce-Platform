<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Demo catalog only — clearly sample data for local development.
 * php artisan db:seed --class=DemoCatalogSeeder
 */
class DemoCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $cats = [
            ['name' => 'Milk', 'desc' => 'Fresh cow milk'],
            ['name' => 'Yogurt', 'desc' => 'Natural yogurt and doi'],
            ['name' => 'Cheese', 'desc' => 'Farm cheese'],
            ['name' => 'Butter', 'desc' => 'Fresh butter'],
            ['name' => 'Ghee', 'desc' => 'Pure desi ghee'],
            ['name' => 'Cream', 'desc' => 'Dairy cream'],
            ['name' => 'Paneer', 'desc' => 'Fresh paneer'],
            ['name' => 'Dairy Sweets', 'desc' => 'Traditional sweets'],
        ];
        $categoryIds = [];
        foreach ($cats as $c) {
            $row = Category::firstOrCreate(
                ['slug' => Str::slug($c['name'])],
                ['name' => $c['name'], 'description' => $c['desc'], 'is_active' => true]
            );
            $categoryIds[$c['name']] = $row->id;
        }

        $shopsData = [
            ['name' => 'Khati Dairy Farm', 'city' => 'Badarganj', 'desc' => 'Flagship farm store '],
            ['name' => 'Satkira Ghosh Dairy', 'city' => 'Nilphamari', 'desc' => 'Morning milk specialist '],
            ['name' => 'Roshai Vandar', 'city' => 'Badarganj', 'desc' => 'Organic-style dairy '],
            ['name' => 'Pure Taste Dairy', 'city' => 'Gazipur', 'desc' => 'Regional seller of fresh milk and products'],
            ['name' => 'Village Fresh Dairy', 'city' => 'Paglapir', 'desc' => 'Village-sourced products'],
        ];
        $shopIds = [];
        foreach ($shopsData as $s) {
            $row = Shop::firstOrCreate(
                ['slug' => Str::slug($s['name'])],
                [
                    'name' => $s['name'],
                    'city' => $s['city'],
                    'description' => $s['desc'],
                    'status' => 'active',
                    'is_verified' => true,
                ]
            );
            $shopIds[] = $row->id;
        }

        $products = [
            ['name' => 'Fresh Farm Milk', 'cat' => 'Milk', 'price' => 90, 'unit' => '1 Liter', 'img' => 'images/products/milk.jpg', 'stock' => 120],
            ['name' => 'Natural Yogurt', 'cat' => 'Yogurt', 'price' => 120, 'unit' => '500g', 'img' => 'images/products/yogurt.jpg', 'stock' => 80],
            ['name' => 'Premium Farm Cheese', 'cat' => 'Cheese', 'price' => 450, 'unit' => '250g', 'img' => 'images/products/cheese.jpg', 'stock' => 40],
            ['name' => 'Fresh Butter', 'cat' => 'Butter', 'price' => 180, 'unit' => '200g', 'img' => 'images/products/butter.jpg', 'stock' => 60],
            ['name' => 'Pure Desi Ghee', 'cat' => 'Ghee', 'price' => 750, 'unit' => '500g', 'img' => 'images/products/ghee.jpg', 'stock' => 35],
            ['name' => 'Fresh Cream', 'cat' => 'Cream', 'price' => 160, 'unit' => '200ml', 'img' => 'images/products/cream.jpg', 'stock' => 50],
            ['name' => 'Soft Paneer', 'cat' => 'Paneer', 'price' => 280, 'unit' => '250g', 'img' => 'images/products/paneer.jpg', 'stock' => 45],
            ['name' => 'Bengali Dairy Sweets Box', 'cat' => 'Dairy Sweets', 'price' => 350, 'unit' => 'Box', 'img' => 'images/products/sweets.jpg', 'stock' => 30],
        ];

        foreach ($products as $i => $p) {
            Product::firstOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'category_id' => $categoryIds[$p['cat']],
                    'shop_id' => $shopIds[$i % count($shopIds)],
                    'name' => $p['name'],
                    'description' => 'Demo product: ' . $p['name'] . ' from Khati Dairy sample catalog. For development only.',
                    'price' => $p['price'],
                    'unit' => $p['unit'],
                    'stock' => $p['stock'],
                    'image' => $p['img'],
                    'status' => 'active',
                ]
            );
        }
    }
}
