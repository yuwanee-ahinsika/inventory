<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Stock;
use App\Models\StockRequest;
use Illuminate\Support\Facades\View;

$user = User::first();
if (!$user) {
    echo "ERROR: No users in database.\n";
    exit(1);
}
auth()->login($user);

try {
    echo "Checking Stocks Index...\n";
    $stocks = Stock::paginate(10);
    $stats = [
        'total_items' => 10,
        'total_quantity' => 100,
        'low_stock' => 2,
        'out_of_stock' => 1,
    ];
    $html = View::make('stocks.index', compact('stocks', 'stats'))->render();
    echo "Stocks Index Rendered Successfully. Size: " . strlen($html) . " bytes.\n";

    echo "Checking Stock Requests Index...\n";
    $requests = StockRequest::paginate(10);
    $roleName = 'Admin';
    $stats = [
        'total_requests' => 5,
        'pending' => 2,
        'approved' => 2,
        'rejected' => 1,
    ];
    $html = View::make('stock-requests.index', compact('requests', 'roleName', 'stats'))->render();
    echo "Stock Requests Index Rendered Successfully. Size: " . strlen($html) . " bytes.\n";

} catch (\Exception $e) {
    echo "RENDER ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
