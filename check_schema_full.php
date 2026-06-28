<?php
use Illuminate\Support\Facades\Schema;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = [
    'room_type', 'furnishing_type', 'tenant_type', 'amenities', 
    'state', 'country', 'city', 'address', 'latitude', 'longitude',
    'listing_fee_paid', 'listing_payment_id'
];

echo "Checking 'rooms' table schema...\n";
foreach ($columns as $col) {
    echo "$col: " . (Schema::hasColumn('rooms', $col) ? 'OK' : 'MISSING') . "\n";
}
