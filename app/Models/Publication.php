<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'desc',
        'open',
        'type',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('seen_date');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
