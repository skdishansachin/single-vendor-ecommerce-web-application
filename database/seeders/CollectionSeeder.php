<?php

namespace Database\Seeders;

use App\Models\Collection;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = [
            [
                'name' => 'Men',
                'description' => 'High-quality men\'s clothing, expertly designed to marry style with comfort. From elegantly tailored office wear to chic casual pieces perfect for a weekend getaway.',
            ],
            [
                'name' => 'Women',
                'description' => 'High-quality women\'s clothing, expertly designed to marry style with comfort. From elegantly tailored office wear to chic casual pieces perfect for a weekend getaway.',
            ],
            [
                'name' => 'Unisex',
                'description' => 'High-quality unisex clothing, expertly designed to marry style with comfort. From elegantly tailored office wear to chic casual pieces perfect for a weekend getaway.',
            ],
            [
                'name' => 'Tops',
                'description' => 'Our Tops collection offers a range of premium, organic cotton shirts and jackets. Each piece is designed with a minimalist aesthetic, ensuring you stay stylish while feeling comfortable.',
            ],
            [
                'name' => 'Bottoms',
                'description' => 'Our Bottoms collection offers a range of organic cotton pants and shorts. Experience the ultimate comfort and style, designed for both active and relaxed lifestyles.',
            ],
            [
                'name' => 'Featured',
                'description' => 'Discover the pinnacle of Liquid\'s athletic wear in our Featured collection. These pieces encapsulate our commitment to sustainable fashion, merging comfort, style, and eco-consciousness.',
            ],
            [
                'name' => 'Shoes',
                'description' => 'Step into sustainable fashion with Liquid\'s Shoes collection. Crafted for comfort and style, our shoes are the perfect complement to your eco-conscious wardrobe.',
            ],
            [
                'name' => 'Accessories',
                'description' => 'Complete your look with our Accessories collection. From stylish hats and scarves to trendy bags and jewelry, our accessories are designed to elevate your style and add the perfect finishing touch to any outfit.',
            ],
        ];

        foreach ($collections as $collection) {
            Collection::create($collection);
        }
    }
}
