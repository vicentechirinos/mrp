<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'desc',
        'publication_id',
        'user_id',
    ];

    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
