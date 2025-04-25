<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

use Illuminate\Queue\SerializesModels;

class AdminReportMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Report
     *
     * @var array<mixed>
     */
    public array $report;

    /**
     * Create a new message instance.
     *
     * @param array<mixed> $report
     */
    public function __construct(array $report)
    {
        $this->report = $report;
    }

    /** Get the message envelope. */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admin Report Mail',
        );
    }

    /** Get the message content definition. */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
