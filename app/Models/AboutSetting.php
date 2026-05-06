<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    use HasFactory;

    protected $table = 'about_us';

    protected $fillable = [
        'who_we_are',
        'our_vision',
        'our_mission',
        'what_we_believe',
        'contact_email',
        'contact_phone',
        'contact_whatsapp',
        'contact_address',
        'working_hours',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'instagram_url',
    ];

    /**
     * Get the about settings instance (singleton pattern)
     */
    public static function settings()
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'who_we_are' => 'Your trusted platform for finding the best loan offers in Bangladesh.',
                'our_vision' => 'To become the leading loan comparison platform in Bangladesh.',
                'our_mission' => 'To help people make informed financial decisions by providing transparent loan comparisons.',
                'what_we_believe' => 'We believe in financial transparency and empowering individuals with information.',
                'contact_email' => 'info@loanlinker.com',
                'contact_phone' => '+880 1234-567890',
                'contact_whatsapp' => '8801234567890',
                'contact_address' => 'Gulshan, Dhaka-1212, Bangladesh',
                'working_hours' => 'Monday - Saturday, 09:00 AM to 06:00 PM',
                'facebook_url' => 'https://facebook.com',
                'twitter_url' => 'https://twitter.com',
                'linkedin_url' => 'https://linkedin.com',
                'instagram_url' => 'https://instagram.com',
            ]
        );
    }
}
