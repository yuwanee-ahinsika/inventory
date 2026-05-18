<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockRequest extends Model
{
    protected $fillable = ['user_id', 'department_id', 'stock_id', 'quantity', 'status', 'hod_status', 'processed_by', 'hod_approved_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function hodApprover()
    {
        return $this->belongsTo(User::class, 'hod_approved_by');
    }
}
