<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AssignTripMail extends Mailable
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
        $from_location_point = $data['from_location_point'] ?? '';
        $to_location_point = $data['to_location_point'] ?? '';


        return $this->subject('Assign Trip / '.$trip_id.'/ '.$from_location_point.' To '.$to_location_point.'')->view('admin.emails.assign_trip_email', $data);
    }
    
}
