<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'contact_no',
        'company_id',
        'user_id',
    ];

    public function addresses(){
        return $this->morphOne(Address::class, 'addressable');
    }

    protected function scopeOrderByName($qry,$dir = 'asc'){
        return $qry->orderby('name',$dir);
    }
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function region(){
        return $this->belongsTo(Region::class);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }

    public function regions(){
        return $this->hasMany(Region::class)->with('cities')->OrderByName();
    }

    public function users(){
        return $this->belongsToMany(User::class,'user_project');
    }
}
