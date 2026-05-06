<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Arif',
                'location' => 'Dhaka',
                'role' => null,
                'message' => 'Loan Linker saved me days of bank visits.',
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'Rahim',
                'location' => null,
                'role' => 'Loan Officer',
                'message' => 'Verified leads helped me reach my monthly target.',
                'is_active' => true,
                'display_order' => 2,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
