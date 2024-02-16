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
        'sale_invoice_id',
        'customer_id',

        'company_id',
        'branch_id',
        'project_id',
        'branch_id',
        'user_id',
    ];

}
