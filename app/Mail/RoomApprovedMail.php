<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoomApprovedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $room;
    public $owner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($room, $owner)
    {
        $this->room = $room;
        $this->owner = $owner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('बधाई! आपका रूम लिस्टिंग अप्रूव कर दी गई है')
                    ->view('emails.room-approve')
                    ->with([
                        'room' => $this->room,
                        'roomTitle' => $this->room->title,
                        'ownerName' => $this->owner->name,
                        'roomId' => $this->room->id,
                        'roomAddress' => $this->room->address,
                        'roomPrice' => $this->room->rent,
                        'roomImage' => $this->room->photo,
                    ]);
    }
}