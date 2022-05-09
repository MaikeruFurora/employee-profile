<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Images;
class Employee extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function diagnos(){
        return $this->hasMany(Diagnos::class);
    }
}
