<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'text',
        'sort',
        'survey_id',
        'type_id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    //protected $with = ['fields'];

    public function fields() {
        return $this->hasMany(Field::class);
    }

    public function type() {
        return $this->belongsTo(QuestionType::class);
    }
}
