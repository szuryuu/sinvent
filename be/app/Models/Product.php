<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ["name", "type", "specification"];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
