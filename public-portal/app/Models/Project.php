<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'project';

    public function projectStudent()
    {
        return $this->hasOne(Student::class, 'reg_no', 'student');
    }

    public function lecturer()
    {
        return $this->hasOne(Lecturer::class, 'emp_id', 'supervisor');
    }

    public function projectCategory()
    {
        return $this->hasOne(ProjectCategory::class, 'id', 'category');
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class, 'project_id');
    }
}
