<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Developer Tools', 'Artificial Intelligence', 'Productivity', 'Design Tools', 'Marketing', 'Social Media', 'Writing', 'Health & Fitness', 'SaaS', 'Data & Analytics'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}