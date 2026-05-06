<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_logo',
        'footer_logo',
        'favicon',
        'site_name',
    ];

    /**
     * Get the logo settings instance (singleton pattern)
     */
    public static function settings()
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'header_logo' => null,
                'footer_logo' => null,
                'favicon' => null,
                'site_name' => 'Loan Linker',
            ]
        );
    }
}
