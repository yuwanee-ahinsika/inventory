<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$user = App\Models\User::where('email', 'admin@example.com')->first();
auth()->login($user);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::create('/stocks', 'GET')
);

echo "STATUS: " . $response->status() . "\n";
echo substr($response->getContent(), 0, 500);
