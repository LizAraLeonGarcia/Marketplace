<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use TwoFactorAuthenticatable;
    use Notifiable;
    use SoftDeletes;
    // ------------------------------------------------------------------------------------------------------------------ Relacion con productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'user_id');
    }
    // -------------------------------------------------------------------------------------------------------------------- Relacion con carrito
    public function carritos()
    {
        return $this->belongsToMany(Producto::class, 'carritos')
                ->withPivot('cantidad')
                ->withTimestamps();
    }
    // -------------------------------------------------------------------------------------------------------------------- Relacion con compras
    public function compras()
    {
        return $this->hasMany(Sale::class, 'user_id');
    }
    // ----------------------------------------------------------------------------------------------------------------------- Relación con país
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id'); 
    }
    // verificar correo ------------------------------------------------------------------------------------------------------------------------
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\CustomVerifyEmail);
    }
    //
    protected $fillable = [
        'name',
        'email',
        'password',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected $dates = [
        'fecha_nacimiento'
    ];
}
