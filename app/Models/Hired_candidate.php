<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hired_candidate extends Model
{
    use HasFactory,HasUuids;
    protected $fillable = ["job_id", "cv_id"];

    public function candidacy()
    {
        return $this->hasOne(Candidacy::class);
    }
}
