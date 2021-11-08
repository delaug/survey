<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'survey_id',
        'user_id',
        'question_id',
        'field_id',
        'text',
    ];

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function field() {
        return $this->belongsTo(Field::class);
    }
}
