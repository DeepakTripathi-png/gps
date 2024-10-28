<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AlertMail extends Mailable
{
    use Queueable, SerializesModels;
    public  $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data  =$data ;
    }

    public function build()
    {
        $data = $this->data;
        
        $trip_id = $data['trip_id'] ?? '';
        $type = $data['type'] ?? '';


        return $this->subject('Alert/'.$trip_id.'/ '.$type.'')->view('admin.emails.alert_email', $data);
    }
    
}
