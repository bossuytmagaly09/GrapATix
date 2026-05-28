<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class TicketPurchaseConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Order $order,
        public string $recipientName = 'daar',
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Jouw tickets voor ' . ($this->order->event->title ?? 'het evenement') . ' 🎉',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ticket-purchase',
            with: [
                'order' => $this->order,
                'tickets' => $this->order->tickets()->with('ticketType')->get(),
                'event' => $this->order->event,
                'recipientName' => $this->recipientName,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $attachments = [];

        foreach ($this->order->tickets as $ticket) {
            if ($ticket->qr_image_path && Storage::disk('public')->exists($ticket->qr_image_path)) {
                $attachments[] = Attachment::fromStorageDisk('public', $ticket->qr_image_path)
                    ->as('ticket-' . strtoupper(substr(md5($ticket->id), 0, 8)) . '.svg')
                    ->withMime('image/svg+xml');
            }
        }

        return $attachments;
    }
}
