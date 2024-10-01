<?php

namespace App\Mail;

use App\Models\ServiceInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendInquiryEmail extends Mailable
{
    use Queueable, SerializesModels;

    private ServiceInquiry $serviceInquiry;

    /**
     * Create a new message instance.
     */
    public function __construct(ServiceInquiry $serviceInquiry)
    {
        $this->serviceInquiry = $serviceInquiry;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Inquiry',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.inquiry-email',
            with: ['serviceInquiry' => $this->serviceInquiry],
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
