<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'status'
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
    ];

    public function publications()
    {
        return $this->belongsToMany(Publication::class)
            ->withPivot('seen_date');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class)
            ->withPivot('action');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function parents()
    {
        return $this->hasMany(Family::class, 'child_id');
    }

    public function childs()
    {
        return $this->hasMany(Family::class, 'parent_id');
    }
}
