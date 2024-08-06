<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;


    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
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
    public function price_group()
    {
        return $this->belongsTo(PriceGroup::class, 'price_group_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    // Accessor for formatted type
    public function getFormattedTypeAttribute()
    {
        $type = $this->attributes['type'];
        $label = '';
        $badgeClass = '';

        switch ($type) {
            case 'sales':
                $label = 'مبيعات';
                $badgeClass = 'badge-success';
                break;

            case 'sales_return':
                $label = 'مردود مبيعات';
                $badgeClass = 'danger';
                break;

            case 'purchases':
                $label = 'مشتريات';
                $badgeClass = 'primary';
                break;

            case 'purchases_return':
                $label = 'مردود مشتريات';
                $badgeClass = 'warning';
                break;

            default:
                $label = 'غير معروف'; // Unknown
                $badgeClass = 'secondary';
                break;
        }

        return "<span class=\"badge rounded-pill text-bg-{$badgeClass}\">{$label}</span>";
    }

    // Accessor for formatted total_amount
    public function getFormattedTotalAmountAttribute()
    {
        return number_format($this->attributes['total_amount'], 0);
    }

    // Accessor for formatted discount_value
    public function getFormattedDiscountValueAttribute()
    {
        return number_format($this->attributes['discount_value'], 0);
    }

    // Accessor for formatted grand_total
    public function getFormattedGrandTotalAttribute()
    {
        return number_format($this->attributes['grand_total'], 0);
    }

    private static $statusLabels = [
        'pending' => 'قيد المراجعة',
        'confirmed' => 'تمت الموافقة',
        'on_the_way' => 'في الطريق',
        'delivered' => 'تم تسليمه',
        'canceled' => 'ملغي',
    ];

    public function getFormattedStatusAttribute()
    {
        $status = $this->attributes['status'];
        $label = self::$statusLabels[$status] ?? 'غير معروف'; // Default to 'unknown' if status is not found

        // Assign appropriate badge classes based on status
        $badgeClass = match ($status) {
            'pending' => 'warning',
            'confirmed' => 'success',
            'on_the_way' => 'info',
            'delivered' => 'primary',
            'canceled' => 'danger',
            default => 'secondary',
        };

        return "<span class=\"badge rounded-pill text-bg-{$badgeClass}\">{$label}</span>";
    }
}
