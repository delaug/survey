<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'sort',
        'type_id',
        'option_id',
        'question_id',
    ];

    public function type() {
        return $this->belongsTo(FieldType::class);
    }

    public function option() {
        return $this->belongsTo(FieldOption::class);
    }
}
