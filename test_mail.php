<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

// 1. Clean settings
$username = trim(Setting::get('mail_username'));
$host = trim(Setting::get('mail_host'));
$password = trim(Setting::get('mail_password'));

Setting::set('mail_username', $username);
Setting::set('mail_host', $host);
Setting::set('mail_password', $password);

echo "Settings cleaned. Username: '$username'\n";

// 2. Apply config manually for testing
Setting::setMailConfig();

// 3. Try to send test mail
try {
    Mail::to('rohitgannote9009@gmail.com')->send(new OtpMail('123456'));
    echo "Test mail SENT successfully!\n";
} catch (\Exception $e) {
    echo "Test mail FAILED: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
