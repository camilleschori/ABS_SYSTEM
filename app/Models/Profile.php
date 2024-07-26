<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Profile extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(Region::class, 'country_id');
    }

    public function province()
    {
        return $this->belongsTo(Region::class, 'province_id');
    }


    public function area()
    {
        return $this->belongsTo(Region::class, 'area_id');
    }

    public function subArea()
    {
        return $this->belongsTo(Region::class, 'sub_area_id');
    }

    public function priceGroup()
    {
        return $this->belongsTo(PriceGroup::class, 'price_group_id');
    }


    public function getTypeBadge()
    {

        switch ($this->type) {
            case 'admin':
                return '<span class="badge bg-primary">مسؤول</span>';
            case 'customer':
                return '<span class="badge bg-success">زبون</span>';
            case 'supplier':
                return '<span class="badge bg-warning">مورد</span>';
            default:
                return '<span class="badge bg-secondary">N/A</span>';
        }
    }
    public function getStatusBadge()
    {
        switch ($this->status) {
            case 'active':
                return '<span class="badge bg-success">مفعل</span>';
            case 'inactive':
                return '<span class="badge bg-danger">غير مفعل</span>';
            case 'suspended':
                return '<span class="badge bg-warning">معلق</span>';
            default:
                return '<span class="badge bg-secondary">N/A</span>';
        }
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }
    public function getCreatedByUserNameAttribute()
    {
        return $this->createdByUser ? $this->createdByUser->name : 'N/A';
    }
}
