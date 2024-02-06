<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'voucher_id',
        'type',
        'voucher_no',
        'sr_no',
        'company_id',
        'branch_id',
        'project_id',
        'user_id',
        'posted',
        'form_id',

    ];

}
