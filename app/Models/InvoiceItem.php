<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{



    use HasFactory;

    protected $table = 'invoice_items';
    
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }



    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

}
