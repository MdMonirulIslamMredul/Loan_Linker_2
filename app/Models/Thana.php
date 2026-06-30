<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thana extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'district_id',
        'name',
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
