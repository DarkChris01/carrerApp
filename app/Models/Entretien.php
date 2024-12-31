<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entretien extends Model
{
    use HasFactory,HasUuids;
    protected $fillable = ["date", "status", "time", 'lieu', "candidacy_id", "job_id"];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function candidacy()
    {
        return $this->belongsTo(Candidacy::class);
    }
}
