<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\CustomVerifyEmail;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use TwoFactorAuthenticatable;
    use Notifiable;
    use SoftDeletes;
    use Billable;
    // ------------------------------------------------------------------------------------------------------------------ Relacion con productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'user_id');
    }
    // -------------------------------------------------------------------------------------------------------------------- Relacion con carrito
    public function carritos()
    {
        return $this->belongsToMany(Producto::class, 'carrito_producto')  
                    ->withPivot('cantidad') 
                    ->withTimestamps();
    }
    // -------------------------------------------------------------------------------------------------------------------- Relacion con compras
    public function compras()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }
    // ----------------------------------------------------------------------------------------------------------------------- Relación con país
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id'); 
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewable_id')
                    ->where('reviewable_type', self::class);
    }
    // -------------------------------------------------------------------------------------------------------------------- Relación con reseñas
    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewable_id')
                ->where('reviewable_type', User::class);
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id'); 
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
