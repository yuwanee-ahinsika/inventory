<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Http\Request;

$user = User::first();
auth()->login($user);

$controller = app()->make(\App\Http\Controllers\Web\ReportController::class);

$types = ['system-overview', 'stock-availability', 'low-stock', 'department', 'request-status', 'summary', 'movements'];

foreach ($types as $type) {
    echo "Checking Report Type: $type...\n";
    $request = Request::create('/reports', 'GET', ['type' => $type, 'start_date' => '2023-01-01', 'end_date' => '2030-12-31', 'department_id' => 1]);
    try {
        $response = $controller->index($request);
        echo " - Success! View Rendered.\n";
    } catch (\Exception $e) {
        echo " - ERROR: " . $e->getMessage() . " on line " . $e->getLine() . " of " . $e->getFile() . "\n";
    }
}
echo "Done.\n";
