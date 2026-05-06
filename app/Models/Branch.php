<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bank_id',
        'name',
        'code',
        'address',
        'city',
        'state',
        'phone',
        'email',
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
        ];
    }

    /**
     * Get the bank that the branch belongs to.
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * Get the branch admins for the branch.
     */
    public function branchAdmins()
    {
        return $this->hasMany(User::class)->where('role', 'branch_admin');
    }

    /**
     * Get all users associated with this branch.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the loans for the branch.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
