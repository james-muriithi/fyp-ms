<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;
    protected $table = 'lecturer';

    public function project()
    {
        return $this->hasMany(Project::class, 'supervisor', 'emp_id');
    }

}
