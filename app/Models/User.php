<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Kolom 'role' WAJIB ditambahkan untuk Mass Assignment.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'loket_id', // <--- DITAMBAHKAN
    ];

    /**
     * Dapatkan loket yang ditugaskan ke petugas ini.
     */
    public function loket()
    {
        return $this->belongsTo(Loket::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}