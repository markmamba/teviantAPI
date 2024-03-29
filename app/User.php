<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Backpack\CRUD\CrudTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use CrudTrait;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function reservationPickings()
    {
        return $this->hasMany('App\Models\OrderProductReservation', 'picked_by');
    }

    public function productPickings()
    {
        return $this->hasMany('App\Models\OrderProductPicking', 'picker_id');
    }

    public function packs()
    {
        return $this->hasMany('App\Models\Order', 'packer_id');
    }
}
