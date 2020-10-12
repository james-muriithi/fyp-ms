<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;
    protected $table = 'upload';
    protected $primaryKey = 'id';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function uploadCategory()
    {
        return $this->belongsTo(UploadCategory::class, 'category');
    }
}
