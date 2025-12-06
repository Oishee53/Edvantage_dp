<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    public function question() {
    return $this->belongsTo(Question::class);
}

public function selectedOption() {
    return $this->belongsTo(Option::class, 'selected_option_id');
}

public function submission() {
    return $this->belongsTo(QuizSubmission::class);
}
protected $fillable = [
    'quiz_submission_id',
    'question_id',
    'selected_option_id',

    ];
}
