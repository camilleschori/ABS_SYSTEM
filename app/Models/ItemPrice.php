<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPrice extends Model
{
    use HasFactory;


    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function priceGroup()
    {
        return $this->belongsTo(PriceGroup::class);
    }
}
