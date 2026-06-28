<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
    ];

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value
     */
    public static function set($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup($group)
    {
        return self::where('group', $group)->get();
    }

    /**
     * Dynamically apply mail settings from the database to Laravel's configuration
     */
    public static function setMailConfig()
    {
        $host = trim(self::get('mail_host', ''));
        $port = self::get('mail_port', 587);
        $username = trim(self::get('mail_username', ''));
        $password = trim(self::get('mail_password', ''));
        $from_address = trim(self::get('contact_email', 'hello@example.com'));
        $from_name = self::get('website_name', 'RoomRental');

        if ($host && $username && $password) {
            config([
                'mail.mailers.smtp.host' => $host,
                'mail.mailers.smtp.port' => $port,
                'mail.mailers.smtp.username' => $username,
                'mail.mailers.smtp.password' => $password,
                'mail.mailers.smtp.encryption' => ($port == 465) ? 'ssl' : 'tls',
                'mail.from.address' => $from_address,
                'mail.from.name' => $from_name,
                'mail.default' => 'smtp',
            ]);
        }
    }
}

