<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'address',
        'contact_no',
        'company_id',
        'user_id',
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function addresses(){
        return $this->morphOne(Address::class, 'addressable');
    }
}
