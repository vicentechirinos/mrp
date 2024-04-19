<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function modules()
    {
        return $this->belongsToMany(Module::class)
            ->using(ActionModule::class);
    }
}
