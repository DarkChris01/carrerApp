<?php

namespace App\Models;

use App\Models\Cv;
use App\Models\User;
use App\Models\Archive;
use App\Models\Employer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidacy extends Model
{
    use HasFactory;
    protected $fillable = ["job_id", "cv_id", "status"];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function entretien()
    {
        return $this->hasOne(Entretien::class);
    }


    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function archives()
    {
        return $this->morphMany(Archive::class, "archivable");
    }
}
