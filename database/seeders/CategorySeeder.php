<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Technology',
                'icon' => 'fas fa-laptop-code',
                'description' => 'Software development, IT services, and tech related jobs'
            ],
            [
                'name' => 'Marketing',
                'icon' => 'fas fa-chart-line',
                'description' => 'Digital marketing, SEO, social media, and advertising'
            ],
            [
                'name' => 'Finance',
                'icon' => 'fas fa-hand-holding-usd',
                'description' => 'Accounting, banking, investment, and financial services'
            ],
            [
                'name' => 'Healthcare',
                'icon' => 'fas fa-user-md',
                'description' => 'Medical, nursing, pharmacy, and healthcare services'
            ],
            [
                'name' => 'Design',
                'icon' => 'fas fa-paint-brush',
                'description' => 'UI/UX design, graphic design, and creative roles'
            ],
            [
                'name' => 'Sales',
                'icon' => 'fas fa-shopping-cart',
                'description' => 'Sales executive, business development, and retail'
            ],
            [
                'name' => 'Education',
                'icon' => 'fas fa-graduation-cap',
                'description' => 'Teaching, training, academic, and educational roles'
            ],
            [
                'name' => 'Engineering',
                'icon' => 'fas fa-wrench',
                'description' => 'Civil, mechanical, electrical, and other engineering fields'
            ],
            [
                'name' => 'Human Resources',
                'icon' => 'fas fa-users',
                'description' => 'HR management, recruitment, and talent acquisition'
            ],
            [
                'name' => 'Customer Service',
                'icon' => 'fas fa-headset',
                'description' => 'Customer support, call center, and service roles'
            ],
            [
                'name' => 'Legal',
                'icon' => 'fas fa-balance-scale',
                'description' => 'Lawyer, paralegal, legal advisor, and compliance'
            ],
            [
                'name' => 'Remote',
                'icon' => 'fas fa-home',
                'description' => 'Work from home and remote opportunities'
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name'        => $category['name'],
                'slug'        => Str::slug($category['name']),
                'icon'        => $category['icon'],
                'description' => $category['description'],
            ]);
        }
    }
}
