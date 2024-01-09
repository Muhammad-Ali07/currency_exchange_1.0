<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'user_status',
        'company_id',
        'branch_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ScopeEntryStatus($q){
        return $q->where('user_status',1);
    }

    public function addresses(){
        return $this->morphOne(Address::class, 'addressable');
    }

    public function project() {
        return $this->hasOne(Project::class,'id','project_id');
    }
    public function branch() {
        return $this->hasOne(Branch::class,'id','branch_id');
    }

    public function company() {
        return $this->hasOne(Company::class,'id','company_id');
    }

    public function projects() {
        return $this->belongsToMany(Project::class,'user_project');
    }
}
