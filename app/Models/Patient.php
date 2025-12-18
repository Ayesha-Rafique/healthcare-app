<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\guard;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory; use SoftDeletes; 
    protected $guarded = [];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
