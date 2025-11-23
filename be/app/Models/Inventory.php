<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        "product_id",
        "member_id",
        "serial_number",
        "status",
    ];

    protected $appends = ["inv_code"];

    public function getInvCodeAttribute()
    {
        return "INV-" . str_pad($this->id, 3, "0", STR_PAD_LEFT);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
