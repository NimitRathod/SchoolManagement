<?php

namespace App\Mail;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AnnouncementMail extends Mailable
{
    use Queueable, SerializesModels;

    public $announcement;
    
    /**
     * Create a new message instance.
     */
    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }
    
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Announcement of '.$this->announcement->title,
        );
    }
    
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // return $this->view('emails.announcement');    
        return new Content(
            view: 'emails.announcement',
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
