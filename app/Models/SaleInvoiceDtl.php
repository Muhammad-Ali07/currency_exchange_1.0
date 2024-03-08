<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoiceDtl extends Model
{
    use HasFactory;

    protected $table = 'sales_dtl';

    protected $fillable = [
        'id',
        'uuid',
        'account_id',
        'account_name',
        'account_code',
        'received_fc',
        'paid_fc',
        'exchange_rate',
        'debit',
        'credit',
        'fc_debit',
        'fc_credit',

        'sale_invoice_id',
        'customer_id',
        'supplier_id',
        'description',
        'company_id',
        'branch_id',
        'project_id',
        'branch_id',
        'user_id',
    ];
    public function sale(){
        return $this->belongsTo(Sale::class,'id');
    }
}
