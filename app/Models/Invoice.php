<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    
    public function profile(){
        return $this->belongsTo(Profile::class, 'profile_id');
    }
    public function country(){
        return $this->belongsTo(Region::class, 'country_id');
    }
    public function province(){
        return $this->belongsTo(Region::class, 'province_id');
    }
    public function area(){
        return $this->belongsTo(Region::class, 'area_id');
    }
    public function subArea(){
        return $this->belongsTo(Region::class,'sub_area_id');
    }
    public function price_group(){
        return $this->belongsTo(PriceGroup::class,'price_group_id');
    }
    public function currency(){
        return $this->belongsTo(Currency::class,'currency_id');
    }

}
