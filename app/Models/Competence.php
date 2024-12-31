<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $fillable = [
        'cv_id',
        'technical_competences',
        'no_technical_competences'
    ];
    use HasFactory;

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}
