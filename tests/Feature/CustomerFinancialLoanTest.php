<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\CustomerFinancial;
use App\Models\CustomerFinancialLoan;
use App\Models\ServiceCategory;
use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerFinancialLoanTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_the_edit_financial_loan_page(): void
    {
        $user = User::factory()->create([
            'role' => 'customer',
        ]);

        $financial = CustomerFinancial::create();
        $user->customer_financial_id = $financial->id;
        $user->save();

        $bank = Bank::create([
            'name' => 'Test Bank',
            'is_active' => true,
        ]);

        $category = ServiceCategory::create([
            'name' => 'Credit Card',
            'is_active' => true,
        ]);

        $serviceType = ServiceType::create([
            'name' => 'Premium Card',
            'service_category_id' => $category->id,
            'is_active' => true,
        ]);

        $loan = CustomerFinancialLoan::create([
            'customer_financial_id' => $financial->id,
            'service_category_id' => $category->id,
            'service_type_id' => $serviceType->id,
            'bank_id' => $bank->id,
            'loan_amount' => 25000.50,
            'tenure_months' => 12,
        ]);

        $response = $this->actingAs($user)->get("/customer/financial/loans/{$loan->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Edit Loan');
        $response->assertSee('Premium Card');
        $response->assertSee('25000.50');
    }
}
