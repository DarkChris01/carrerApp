<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Employer extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasUuids, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'post_',
        'password',
    ];

    public function enterprise()
    {
        return $this->HasOne(Enterprise::class);
    }

    public function jobs()
    {
        return $this->HasMany(Job::class);
    }

    public function entretiens()
    {
        return $this->hasMany(Entretien::class);
    }
}
