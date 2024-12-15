<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
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

    public function deUserData()
    {
        return $this->hasOne(DeUserData::class, 'user_id', 'id');
    }

    public function userNews()
    {
        return $this->hasMany(DeUserNews::class, 'user_id')->orderBy('id', 'DESC')->limit(10);
    }

    public function userNewNews()
    {
        return $this->hasMany(DeUserNews::class, 'user_id')->where('seen', 0);
    }

    public function userHF()
    {
        return $this->hasMany(DeUserHyper::class, 'empfaenger', 'id')->orderBy('gelesen', 'ASC')->orderBy('id', 'DESC')->where('sender', 0)->limit(10);
    }

    public function userNewHF()
    {
        return $this->hasMany(DeUserHyper::class, 'empfaenger', 'id')->where('gelesen', 0)->where('sender', 0);
    }
}
