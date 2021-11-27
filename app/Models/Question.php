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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'publish_at' => 'date:Y-m-d H:i:s',
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
    ];

    public function userAnswers()
    {
        return $this->answers()
            ->where('user_id', auth('sanctum')->id())
            ->select(['id','user_id','question_id'])
            ->distinct();
    }

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function fields() {
        return $this->hasMany(Field::class);
    }

    public function type() {
        return $this->belongsTo(QuestionType::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }
}
