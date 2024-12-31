<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $fillable = ["sector1","sector2","sector3","sector4","enterprise_id"];
    use HasFactory;
}
