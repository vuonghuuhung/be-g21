<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'email',
        'password',
        'password_confirmation',
        'firstname',
        'lastname',
        'city_id',
        'district_id',
        'urban_id',
        'phone',
        'status',
        'role',
        'deleted_by',
        'updated_by',
    ];

    protected $hidden = [
        'password',
        'token',
    ];

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Urban');
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}
