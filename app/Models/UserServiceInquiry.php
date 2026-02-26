<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserServiceInquiry extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'userserviceinquiry';
    
    protected $primaryKey = 'sid';
    
    public $timestamps = false;


    protected $fillable = [
        'name',
        'email',
        'looking_for',
        'company_name',
        'user_primary_phone',
        'insert_date_time',
        'flag',
        'user_ip',
        'location',
        'device_type',
        'created_at',
    ];
}
