<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
class Images extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function employees(){
        return $this->belongsTo(Employee::class);
    }
}
