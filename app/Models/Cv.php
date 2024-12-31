<?php

namespace App\Models;

use App\Models\Formation;
use App\Models\Competence;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cv extends Model
{
    use HasUuids, Notifiable, HasFactory;

    protected $fillable = [
        "user_id",
        "firstName",
        "lastName",
        "birth_date",
        "phone",
        "email",
        "country",
        "sexe",
        "picture",
        "cv"
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function competence()
    {
        return $this->hasOne(Competence::class);
    }


    public function formation()
    {
        return $this->hasOne(Formation::class);
    }


    public function experience()
    {
        return $this->HasOne(Experience::class);
    }

    public function candidacies(){
        return $this->hasMany(Candidacy::class);
    }
}
