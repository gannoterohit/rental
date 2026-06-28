<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;

$settings = [
    'mail_host' => Setting::get('mail_host'),
    'mail_port' => Setting::get('mail_port'),
    'mail_username' => Setting::get('mail_username'),
    'mail_password' => Setting::get('mail_password'),
];

print_r($settings);
