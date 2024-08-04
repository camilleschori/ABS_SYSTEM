<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    use HasFactory;


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function prices()
    {
        return $this->hasMany(ItemPrice::class);
    }

    public function views()
    {
        return $this->hasMany(ItemView::class);
    }

    public function attachments()
    {
        return $this->hasMany(ItemAttachment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_categories');
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

    public function getIsVisibleBadge()
    {
        return match ($this->is_visible) {
            '1' => '<span class="badge bg-success">مرئي</span>',
            '0' => '<span class="badge bg-danger">مخفي</span>',
            default => '<span class="badge bg-secondary">N/A</span>',
        };
    }
    public function getIsOutOfStockBadge()
    {
        return match ($this->is_out_of_stock) {
            '1' => '<span class="badge bg-danger">نافذ</span>',
            '0' => '<span class="badge bg-success">متاح</span>',
            default => '<span class="badge bg-secondary">N/A</span>',
        };
    }

    public static function Form($values = [])
    {
        return [
            'brand_id' => [
                'name' => 'brand_id',
                'label' => 'الوكالة',
                'class' => 'col-md-3',
                'type' => 'select',
                'options' => Brand::get(['id', 'name'])->pluck('name', 'id')->toArray() ??  ['' => ''],
                'required' => true,
                'value' => $values['brand_id'] ?? ''
            ],
            'code' => [
                'name' => 'code',
                'label' => 'الكود',
                'class' => 'col-md-3',
                'type' => 'text',
                'required' => true,
                'value' => $values['code'] ?? ''
            ],
            'barcode' => [
                'name' => 'barcode',
                'label' => 'الباركود',
                'class' => 'col-md-3',
                'type' => 'text',
                'required' => true,
                'value' => $values['barcode'] ?? ''
            ],
            'name' => [
                'name' => 'name',
                'label' => 'الاسم',
                'class' => 'col-md-3',
                'type' => 'text',
                'required' => true,
                'value' => $values['name'] ?? ''
            ],
            'description' => [
                'name' => 'description',
                'label' => 'الوصف',
                'class' => 'col-md-3',
                'type' => 'textarea',
                'value' => $values['description'] ?? ''
            ],
            'country_id' => [
                'name' => 'country_id',
                'label' => 'الدولة',
                'class' => 'col-md-3',
                'type' => 'select',
                'options' => Country::get(['id', 'name'])->pluck('name', 'id')->toArray() ??  ['' => ''],
                'required' => true,
                'value' => $values['country_id'] ?? ''
            ],
            'current_quantity' => [
                'name' => 'current_quantity',
                'label' => 'الكمية الحالية',
                'class' => 'col-md-3',
                'type' => 'number',
                'value' => $values['current_quantity'] ?? 0,
                'readonly' => true
            ],
            'price' => [
                'name' => 'price',
                'label' => 'السعر',
                'class' => 'col-md-3',
                'type' => 'number',
                'value' => $values['price'] ?? 0,
                'required' => true
            ],
            'discount' => [
                'name' => 'discount',
                'label' => 'الخصم',
                'class' => 'col-md-3',
                'type' => 'number',
                'value' => $values['discount'] ?? 0,
                'required' => true
            ],
            'is_out_of_stock' => [
                'name' => 'is_out_of_stock',
                'label' => 'حالة المنتج في المخزون',
                'class' => 'col-md-3',
                'type' => 'select',
                'options' => [
                    1 => 'نافذ',
                    0 => 'متاح',
                ],
                'value' => $values['is_out_of_stock'] ?? 1,
                'required' => true
            ],
            'is_visible' => [
                'name' => 'is_visible',
                'label' => 'حالة الظهور للمنتج',
                'class' => 'col-md-3',
                'type' => 'select',
                'options' => [
                    1 => 'مرئي',
                    0 => 'مخفي',
                ],
                'value' => $values['is_visible'] ?? 1,
                'required' => true
            ],
            'item_categories' => [
                'name' => 'item_categories',
                'label' => 'التصنيفات',
                'class' => 'col-md-3',
                'type' => 'select',
                'multiple' => true,
                'options' => Category::get(['id', 'name'])->pluck('name', 'id')->toArray() ??  ['' => ''],
                'value' => $values['item_categories'] ?? []

            ]
        ];
    }
}
