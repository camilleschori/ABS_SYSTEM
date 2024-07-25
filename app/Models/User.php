<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
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
    public function getCreatedByUserNameAttribute()
    {
        return $this->createdByUser ? $this->createdByUser->name : 'N/A';
    }
}
