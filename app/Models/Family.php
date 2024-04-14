<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    public function parentUser()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function childUser()
    {
        return $this->belongsTo(User::class, 'child_id');
    }
}
