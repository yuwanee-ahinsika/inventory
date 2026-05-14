<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

echo "Testing API Routes:\n";

$routes = [
    'GET /api/stocks' => '/api/stocks',
    'GET /api/stocks?department_id=1' => '/api/stocks?department_id=1',
    'GET /api/stocks?stock_id=1' => '/api/stocks?stock_id=1',
    'POST /api/stocks' => '/api/stocks',
    'PUT /api/stocks/1' => '/api/stocks/1',
    'GET /api/stock-requests?department_id=1' => '/api/stock-requests?department_id=1',
    'GET /api/reports/low-stock' => '/api/reports/low-stock',
    'GET /api/reports/department-requests' => '/api/reports/department-requests'
];

$router = app('router');

foreach ($routes as $desc => $uri) {
    echo "Checking route definition for: $desc\n";
    $method = explode(' ', $desc)[0];
    $path = explode(' ', $desc)[1];
    
    $request = Request::create($path, $method);
    try {
        $route = $router->getRoutes()->match($request);
        echo "  -> Found route: " . $route->getActionName() . "\n";
    } catch (\Exception $e) {
        echo "  -> Error: " . $e->getMessage() . "\n";
    }
}
