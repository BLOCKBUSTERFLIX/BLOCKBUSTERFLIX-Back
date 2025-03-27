<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Staff extends Authenticatable implements JWTSubject
{
    use HasFactory;

    /**
     * Protected fields when mass assigning
     * @var string[]
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the Store for this Staff.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the Address for this Staff.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get the Rentals for the Staff.
     */
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get the Payments taken by the Staff.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function role(): BelongsTo{
        return $this->belongsTo(Role::class);
    }

    /**
     * Obtener el identificador del JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Obtener los claims personalizados del JWT.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
