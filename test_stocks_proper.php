<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'admin@example.com')->first();
auth()->login($user);

$request = Illuminate\Http\Request::create('/stocks', 'GET');
$response = app()->handle($request);

echo "STATUS: " . $response->status() . "\n";
echo substr($response->getContent(), 0, 1500);
