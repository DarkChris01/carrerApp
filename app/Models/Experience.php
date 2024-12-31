<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = ["experience"];
    use HasFactory;

    public function cv()
    {
        return $this->hasOne(Cv::class);
    }
}
