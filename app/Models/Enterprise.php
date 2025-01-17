<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Enterprise extends Model
{
    protected $fillable = [
        "employer_id",
        "name",
        "company_name",
        "phone",
        "country",
        "region",
        "facebook",
        "linkedin",
        "email",
        "sector",
        "type",
        "postal",
        "logo",
        "address",
        "sectors",
        "aboutUs"
    ];



    use HasFactory, SoftDeletes, HasUuids, Notifiable;

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
}
