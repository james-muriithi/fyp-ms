<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadCategory extends Model
{
    use HasFactory;
    protected $table = 'upload_category';
    protected $primaryKey = 'id';

    public function uploads()
    {
        return $this->hasMany(Upload::class, 'category');
    }
}
