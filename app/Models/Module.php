<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'path',
    ];

    public function actions()
    {
        return $this->belongsToMany(Action::class)
            ->using(ActionModule::class);
    }
}
