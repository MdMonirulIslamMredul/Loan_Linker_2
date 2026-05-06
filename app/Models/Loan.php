<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id',
        'branch_admin_id',
        'category_id',
        'name',
        'description',
        'details1',
        'details2',
        'details3',
        'details4',
        'banner',
        'interest_rate',
        'processing_fee',
        'min_amount',
        'max_amount',
        'min_tenure_months',
        'max_tenure_months',
        'eligibility',
        'features',
        'documents_required',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'interest_rate' => 'decimal:2',
            'min_amount' => 'decimal:2',
            'max_amount' => 'decimal:2',
        ];
    }

    /**
     * Get the branch that the loan belongs to.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the branch admin (user) who created the loan.
     */
    public function branchAdmin()
    {
        return $this->belongsTo(User::class, 'branch_admin_id');
    }

    /**
     * Get the category that the loan belongs to.
     */
    public function category()
    {
        return $this->belongsTo(LoanCategory::class, 'category_id');
    }
}
