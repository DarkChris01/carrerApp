<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence_job extends Model
{
    protected $fillable = [
        "competence",
        "job_id",
    ];
    use HasFactory;
}
