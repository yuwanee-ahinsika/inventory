<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;

class DummyStockSeeder extends Seeder
{
    public function run()
    {
        if (Stock::count() == 0) {
            Stock::create(['name' => 'Laptops', 'sku' => 'LAP-001', 'quantity' => 15]);
            Stock::create(['name' => 'Office Chairs', 'sku' => 'CHR-002', 'quantity' => 45]);
            Stock::create(['name' => 'A4 Paper Reams', 'sku' => 'PPR-003', 'quantity' => 100]);
        }
    }
}
