<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ["name", "position", "department"];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
