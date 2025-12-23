<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FinalExamSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'final_exam_id',
        'user_id',
        'started_at',
        'submitted_at',
        'status',
        'total_score',
        'percentage',
        'instructor_feedback',
        'graded_at',
        'graded_by'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
        'percentage' => 'decimal:2'
    ];

    /**
     * Get the exam this submission belongs to
     */
    public function exam()
    {
        return $this->belongsTo(FinalExam::class, 'final_exam_id');
    }

    /**
     * Get the student who made this submission
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the instructor who graded this submission
     */
    public function grader()
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    /**
     * Get all answers for this submission
     */
    public function answers()
    {
        return $this->hasMany(FinalExamAnswer::class, 'submission_id');
    }

    /**
     * Check if submission is graded
     */
    public function isGraded()
    {
        return $this->status === 'graded';
    }

    /**
     * Check if submission is pending grading
     */
    public function isPendingGrading()
    {
        return $this->status === 'submitted';
    }

    /**
     * Check if student passed (70% or more)
     */
    public function isPassed()
    {
        return $this->isGraded() && $this->percentage >= 70;
    }

    /**
     * Get time remaining for grading (7 days from submission)
     */
    public function getGradingDeadline()
    {
        if (!$this->submitted_at) {
            return null;
        }

        return $this->submitted_at->addDays(7);
    }

    /**
     * Check if grading is overdue
     */
    public function isGradingOverdue()
    {
        $deadline = $this->getGradingDeadline();
        
        return $deadline && now()->gt($deadline) && !$this->isGraded();
    }

    /**
     * Get days remaining for grading
     */
    public function getDaysRemainingForGrading()
    {
        $deadline = $this->getGradingDeadline();
        
        if (!$deadline || $this->isGraded()) {
            return null;
        }

        return now()->diffInDays($deadline, false); // negative if overdue
    }

    /**
     * Calculate and update total score
     */
    public function calculateTotalScore()
    {
        $totalScore = $this->answers()->sum('marks_obtained');
        $totalMarks = $this->exam->total_marks;
        
        $percentage = $totalMarks > 0 ? ($totalScore / $totalMarks) * 100 : 0;

        $this->update([
            'total_score' => $totalScore,
            'percentage' => round($percentage, 2),
            'status' => 'graded',
            'graded_at' => now(),
            'graded_by' => auth()->id()
        ]);

        return $this;
    }
}