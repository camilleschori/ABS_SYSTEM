<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Banner extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
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
                $model->updated_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }
    public function getTypeBadge()
    {

        return match ($this->type) {
            'general' => '<span class="badge bg-success">عام</span>',
            'product' => '<span class="badge bg-warning">منتج</span>',
            'category' => '<span class="badge bg-info">تصنيف</span>',
            'brand' => '<span class="badge bg-dark">وكالة</span>',
            default => '<span class="badge bg-secondary">N/A</span>',
        };
    }
    public function getVisibleBadge()
    {

        return match ($this->is_visible) {
            '1' => '<span class="badge bg-success">مرئي</span>',
            '0' => '<span class="badge bg-warning">مخفي</span>',
            default => '<span class="badge bg-secondary">N/A</span>',
        };
    }
    public function getImageUrl()
    {
        return '<img src="' . url("uploads/banners/{$this->image}") . '" width="100" alt="" >';
    }
}
