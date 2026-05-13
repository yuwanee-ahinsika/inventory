<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['name', 'sku', 'description', 'quantity'];

    public function requests()
    {
        return $this->hasMany(StockRequest::class);
    }
}
