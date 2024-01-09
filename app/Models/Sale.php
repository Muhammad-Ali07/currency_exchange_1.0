<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'code',
        'customer_id',
        'sale_by_staff',
        'product_id',
        'is_installment',
        'is_booked',
        'is_purchased',
        'property_payment_mode_id',
        'sale_price',
        'booked_price',
        'currency_note_no',
        'company_id',
        'project_id',
        'user_id',
        'down_payment',
        'on_balloting',
        'no_of_bi_annual',
        'installment_bi_annual',
        'no_of_month',
        'installment_amount_monthly',
        'on_possession',
        'file_status_id',
        'sale_discount',
        'seller_commission_perc',
    ];

    protected $morphClass = null;

    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function property_payment_mode(){
        return $this->belongsTo(PropertyPaymentMode::class,'property_payment_mode_id','id');
    }
    public function file_status(){
        return $this->belongsTo(BookingFileStatus::class,'file_status_id','id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id')
            ->with('buyable_type');
    }

    public function getMorphClass()
    {
        return $this->morphClass ?: static::class;
    }
    public function dealer()
    {
        $this->morphClass = 'App\Models\Dealer';
        return $this->morphOne(SaleSeller::class,'sale_sellersable','sale_sellerable_type','sale_id','id')
            ->with('dealer');
    }
    public function staff()
    {
        $this->morphClass = 'App\Models\Staff';
        return $this->morphOne(SaleSeller::class,'sale_sellersable','sale_sellerable_type','sale_id','id')
            ->with('staff');
    }
}
