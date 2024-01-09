<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMode extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'default',
        'status',
        'company_id',
        'project_id',
        'user_id',
    ];

}
