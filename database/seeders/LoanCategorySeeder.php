<?php

namespace Database\Seeders;

use App\Models\LoanCategory;
use Illuminate\Database\Seeder;

class LoanCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Personal Loan',
                'description' => 'Loans for personal use with flexible terms and conditions.',
                'is_active' => true,
            ],
            [
                'name' => 'SME Loan',
                'description' => 'Small and Medium Enterprise loans for business growth and expansion.',
                'is_active' => true,
            ],
            [
                'name' => 'Auto/Car Loan',
                'description' => 'Vehicle financing for purchasing new or used cars.',
                'is_active' => true,
            ],
            [
                'name' => 'Home Loan',
                'description' => 'Housing loans for purchasing or constructing residential properties.',
                'is_active' => true,
            ],
            [
                'name' => 'Corporate Loan',
                'description' => 'Large-scale financing solutions for corporate entities.',
                'is_active' => true,
            ],
            [
                'name' => 'Education Loan',
                'description' => 'Student loans for higher education and professional courses.',
                'is_active' => true,
            ],
            [
                'name' => 'Gold Loan',
                'description' => 'Secured loans against gold jewelry and ornaments.',
                'is_active' => true,
            ],
            [
                'name' => 'Credit Card',
                'description' => 'Credit card offerings with various benefits and rewards.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            LoanCategory::create($category);
        }
    }
}
