<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficerDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'picture',
        'nid',
        'office_id',
        'visiting_card',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'officer_document_id');
    }
}
