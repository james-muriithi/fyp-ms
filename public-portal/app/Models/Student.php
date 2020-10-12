<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'student';

    public function projects()
    {
        return $this->hasMany(Project::class, 'student', 'reg_no');
    }

}
