<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Route 'stocks.index' URL: " . route('stocks.index') . "\n";
echo "Route 'stock-requests.index' URL: " . route('stock-requests.index') . "\n";
echo "Route 'dashboard' URL: " . route('dashboard') . "\n";
