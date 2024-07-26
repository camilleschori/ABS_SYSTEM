<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;

    public function getTypeBadge()
    {

        return match ($this->type) {
            'main' => '<span class="badge bg-success">رئيسي</span>',
            'sub' => '<span class="badge bg-warning">فرعي</span>',
            default => '<span class="badge bg-secondary">N/A</span>',
        };
    }
    public function getVisibleBadge()
    {

        return match ($this->is_visible) {
            1 => '<span class="badge bg-success">مرئي</span>',
            0 => '<span class="badge bg-warning">مخفي</span>',
            default => '<span class="badge bg-secondary">N/A</span>',
        };
    }
    public function getImageUrl()
    {
        return '<img src="' . url("uploads/categories/{$this->image}") . '" width="100" alt="" >';
    }

    public function getCreatedByUserNameAttribute()
    {
        return $this->createdByUser ? $this->createdByUser->name : 'N/A';
    }


    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child Categorys of the current Category.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get the users who created this Category.
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the users who last updated this Category.
     */
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
}
