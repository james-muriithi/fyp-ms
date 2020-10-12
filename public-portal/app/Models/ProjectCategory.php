<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    use HasFactory;
    protected $table = 'project_categories';
    protected $primaryKey = 'id';

    public function categoryProjects()
    {
        return $this->hasMany(Project::class, 'category');
    }
}
