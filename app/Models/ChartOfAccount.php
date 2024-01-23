<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChartOfAccount extends Model
{
    use SoftDeletes;

    protected $table = 'chart_of_accounts';

    protected $fillable = [
        'uuid',
        'name',
        'code',
        'level',
        'group',
        'parent_account_id',
        'parent_account_code',
        'status',
        'company_id',
        'project_id',
        'branch_id',
        'user_id',
    ];



    public function children(){
        return $this->hasMany(self::class, 'parent_account_code', 'code')->with('children')
            ->select(['id','code','name','parent_account_code'])->orderBy('code');
    }


}
