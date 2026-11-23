<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = ['name', 'email', 'password', 'avatar'];

    /**
     * Accessor URL foto profil.
     * Diakses via $user->avatar_url
     */
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }

    /**
     * Kolom yang disembunyikan dari serialisasi (JSON/array).
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Cast kolom ke tipe yang sesuai.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // =========================================================
    // RELASI
    // =========================================================

    /**
     * Satu user bisa punya banyak kontak.
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Satu user bisa punya banyak transaksi.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
