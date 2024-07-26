<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Region extends Model
{
    use HasFactory;
    public function getCreatedByUserNameAttribute()
    {
        return $this->createdByUser ? $this->createdByUser->name : 'N/A';
    }


    public function parent()
    {
        return $this->belongsTo(Region::class, 'parent_id');
    }

    /**
     * Get the child regions of the current region.
     */
    public function children()
    {
        return $this->hasMany(Region::class, 'parent_id');
    }

    /**
     * Get the users who created this region.
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the users who last updated this region.
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
