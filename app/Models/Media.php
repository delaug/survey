<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'name', 'extension', 'size'];

    protected $appends = ['public_path'];

    public function getPublicPathAttribute()
    {
        return Storage::url($this->path);
    }
}
