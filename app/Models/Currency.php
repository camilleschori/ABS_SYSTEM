<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    public function getforeignBadge(){
        if($this->is_foreign == 0){
            return '<span class="badge bg-danger">اجنبية</span>';
        }else{
            return '<span class="badge bg-success">محلية</span>';
        }
    }
}
