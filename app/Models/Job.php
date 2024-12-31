<?php

namespace App\Models;

use App\Models\Candidacy;
use App\Models\Formation;
use App\Models\Competence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    protected $fillable = [
        'poste',
        'delay',
        'formation',
        'effective',
        'missions',
        'competence',
        'domain_id',
        'town',
        'employer_id',
        'enterprise_id',
        'experience',
        'type',
        'salary',
    ];

    use HasFactory, HasUuids, SoftDeletes;

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }


    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class);
    }


    public function competence()
    {
        return $this->hasOne(Competence_job::class);
    }

    public function candidacies()
    {
        return  $this->hasMany(Candidacy::class);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
