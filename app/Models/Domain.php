<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domain extends Model
{
    protected $casts = [
        'id' => 'string'
    ];
    use HasFactory;
    public function metiers()
    {
        return $this->hasMany(Metier::class);
    }
}
