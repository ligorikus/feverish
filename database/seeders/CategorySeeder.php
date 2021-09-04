<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Fundamentals',
            'String',
            'Algorithms',
            'Mathematic',
            'Performance',
            'Booleans',
            'Functions'
        ];

        if (Category::count() === 0) {
            foreach ($categories as $category) {
                Category::create([
                    'name' => $category
                ]);
            }
        }
    }
}
