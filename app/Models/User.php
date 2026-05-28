<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'email', 'password', 'role_id'])]
#[Hidden(['password', 'remember_token'])]

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    // ... (Tus propiedades fillable, hidden, etc. se quedan tal como están)

    /**
     * 3. AGREGA ESTE MÉTODO OBLIGATORIO
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * 4. AGREGA ESTE MÉTODO OBLIGATORIO
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /** @use HasFactory<UserFactory> */
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
