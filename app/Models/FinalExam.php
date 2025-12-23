<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'instructor_id',
        'title',
        'description',
        'total_marks',
        'passing_marks',
        'duration_minutes',
        'status',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the course this exam belongs to
     */
    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    /**
     * Get the instructor who created this exam
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get all questions for this exam
     */
    public function questions()
    {
        return $this->hasMany(FinalExamQuestion::class)->orderBy('question_number');
    }

    /**
     * Get all submissions for this exam
     */
    public function submissions()
    {
        return $this->hasMany(FinalExamSubmission::class);
    }

    /**
     * Check if exam is published
     */
    public function isPublished()
    {
        return $this->status === 'published';
    }

    /**
     * Check if exam is draft
     */
    public function isDraft()
    {
        return $this->status === 'draft';
    }

    /**
     * Get submission for a specific user
     */
    public function getSubmissionForUser($userId)
    {
        return $this->submissions()->where('user_id', $userId)->first();
    }

    /**
     * Check if a user has submitted the exam
     */
    public function hasUserSubmitted($userId)
    {
        return $this->submissions()
            ->where('user_id', $userId)
            ->where('status', '!=', 'not_started')
            ->exists();
    }

    /**
     * Get total questions count
     */
    public function getTotalQuestionsAttribute()
    {
        return $this->questions()->count();
    }

    /**
     * Get submissions pending grading
     */
    public function pendingGradingSubmissions()
    {
        return $this->submissions()->where('status', 'submitted');
    }

    /**
     * Get graded submissions
     */
    public function gradedSubmissions()
    {
        return $this->submissions()->where('status', 'graded');
    }
}