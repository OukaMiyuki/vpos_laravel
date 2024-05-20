<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use App\Models\UmiRequest;

class SendUmiEmail extends Mailable {
    use Queueable, SerializesModels;

    public $mailData;
    public $store_identifier;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData, $store_identifier) {
        $this->mailData = $mailData;
        $this->store_identifier = $store_identifier;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope {
        return new Envelope(
            subject: 'Formulir pendaftaran UMI',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content {
        return new Content(
            view: 'tenant.auth.umiRequest',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array

     */
    public function attachments(): array {
        $excelFile = UmiRequest::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->where('store_identifier', $this->store_identifier)
                                ->first();
        //dd($this->store_identifier);
        $filename = $excelFile->file_path;
        return [
            Attachment::fromStorage('public/docs/umi/user_doc/'.$filename),
        ];
    }
}
