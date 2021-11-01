<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FieldType extends Model
{
    use HasFactory, SoftDeletes;

    const CHECKBOX = 1;
    const RADIO = 2;
    const TEXT = 3;
    const TEXTAREA = 4;

    public function options() {
        return $this->belongsToMany(FieldOption::class,'option_type', 'type_id', 'option_id');
    }
}
