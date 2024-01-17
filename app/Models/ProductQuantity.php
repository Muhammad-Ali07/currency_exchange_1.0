<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductQuantity extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'code',
        'name',
        'quantity',
        'form_type',
        'product_id',
        'company_id',
        'branch_id',
        'user_id',
        // 'is_taxable',
        // 'status',
        // 'supplier_id',
        // 'manufacturer_id',
        // 'brand_id',
        // 'parent_category',
        // 'category_id',
        // 'default_sale_price',
        // 'default_purchase_price',
        // 'stock_on_hand_units',
        // 'stock_on_hand_packages',
        // 'sold_in_quantity',
        // 'sell_by_package_only',
        // 'external_item_id',
        // 'buyable_type_id',
    ];
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

}
