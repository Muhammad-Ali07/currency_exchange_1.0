<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'voucher_id',
        'date',
        'type',
        'voucher_no',
        'sr_no',
        'chart_account_id',
        'chart_account_name',
        'chart_account_code',
        'payment_mode_id',
        'debit',
        'credit',
        'description',
        'remarks',
        'tax_perc',
        'tax_amount',
        'cheque_date',
        'cheque_no',
        'invoice_id',
        'invoice_no',
        'company_id',
        'branch_id',
        'project_id',
        'user_id',
        'posted',
        'form_id',
        'amount',
        'rate_per_unit',
        'balance_amount',

    ];

}
