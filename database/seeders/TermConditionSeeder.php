<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TermCondition;

class TermConditionSeeder extends Seeder
{
    public function run(): void
    {
        TermCondition::updateOrCreate(
            ['is_active' => true],
            [
                'title' => 'Loan Linker Terms & Conditions',
                'content' => "Welcome to Loan Linker. By using our services, you agree to the following terms and conditions.\n\n1. Use of Service:\nYou may use Loan Linker to discover loan products and bank offers. Loan Linker is not a bank and does not provide financial advice.\n\n2. Accuracy of Information:\nWe strive to maintain accurate and current information, but we cannot guarantee that all listings, rates, or bank details are up to date. Always verify information directly with the bank.\n\n3. User Conduct:\nYou agree to use Loan Linker responsibly. Misuse, spam, or fraudulent activity is prohibited.\n\n4. Privacy and Data:\nYour personal information will be handled according to our privacy policy. We may collect data to improve service delivery.\n\n5. Limitation of Liability:\nLoan Linker is not responsible for decisions made based on the information provided on this website. Use the platform at your own risk.\n\n6. Changes to Terms:\nWe may update these terms at any time. Continued use of the site after changes means you accept the updated terms.\n\nIf you have questions about these terms, please contact us at the email address listed on the site.",
                'is_active' => true,
            ]
        );
    }
}
