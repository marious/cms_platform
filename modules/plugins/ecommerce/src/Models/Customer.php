<?php

namespace EG\Ecommerce\Models;

use EG\Base\Supports\Avatar;
use EG\Ecommerce\Notifications\CustomerResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use RvMedia;


class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ec_customers';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'dob',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Send the password reset notification
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomerResetPassword($token));
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? RvMedia::url($this->avatar) : (string)(new Avatar)->create($this->name)->toBase64();
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'customer_id', 'id');
    }
}
