<?php

namespace App\Mail;

use App\Models\Angsuran;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PengingatBayarMail extends Mailable
{
    use Queueable, SerializesModels;

    public $angsuran;
    public $pelanggan;
    public $kontrak;

    /**
     * Create a new message instance.
     */
    public function __construct($angsuran)
    {
        $this->angsuran = $angsuran;
        $this->pelanggan = $angsuran->kontrak->pelanggan;
        $this->kontrak = $angsuran->kontrak;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengingat Pembayaran Angsuran',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pengingatbayar',
            with: [
                'angsuran' => $this->angsuran,
                'pelanggan' => $this->pelanggan,
                'kontrak' => $this->kontrak,
            ],
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