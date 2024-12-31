<?php

namespace App\Models;

use App\Models\Competence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formation extends Model
{
    use HasFactory;
    protected $fillable = ["formations"];
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
   
   
    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
