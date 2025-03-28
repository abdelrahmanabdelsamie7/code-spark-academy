<?php
namespace App\Mail;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnrollmentStatusMail extends Mailable
{
    use Queueable, SerializesModels;
    public $enrollment;
    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }
    public function build()
    {
        return $this->subject('Update on Your Enrollment Status')
            ->view('emails.enrollment_status')
            ->with([
                'name' => $this->enrollment->user->name,
                'course' => $this->enrollment->course->title,
                'status' => $this->enrollment->payment_status,
            ]);
    }
}