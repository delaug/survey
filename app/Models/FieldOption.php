<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FieldOption extends Model
{
    use HasFactory, SoftDeletes;

    const POSITION_RADIO_VERTICAL = 1;
    const POSITION_RADIO_HORIZONTAL = 2;
    const POSITION_CHECKBOX_VERTICAL = 3;
    const POSITION_CHECKBOX_HORIZONTAL = 4;
}
