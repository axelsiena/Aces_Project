<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'is_revisor',
        'contact_requested'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    // metodo per ottenere gli annunci preferiti dell'utente
    public function favAds()
    {
        return $this->belongsToMany(Ad::class, 'user_favourite_ad');
    }

    // metodo per verificare se l'utente è l'autore di un'annuncio passato ad argomento
    public function isAdAuthor($adId)
    {
        // Cerca l'annuncio in base all'ID
        $ad = $this->ads()->find($adId);

        // Verifica se l'utente è l'autore dell'annuncio
        return $ad !== null;
    }
      
}
