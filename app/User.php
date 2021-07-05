<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'date:Y-m-d'
    ];
    //casts ile bir veri başka bir tipe dönüştürüleblir

    //protected $appends = ['full_name'];
    //ekstra bir kolon oluşturduk veri tabanında olmayan full_name isimli
    //burda tanımlarsak tüm sorulara full_name ekler.

    public function getFullNameAttribute() {
        return $this->first_name . " " . $this->last_name;
    }
    //burda da full_name kolununa çekeceğimiz verileri ve yapısını oluştrdk.
    //get........Attribute() buraya yeni kolon ismini camle case yazyrz
}
