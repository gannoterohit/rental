<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoomRejectedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $room;
    public $owner;
    public $reasons;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($room, $owner, $reasons)
    {
        $this->room = $room;
        $this->owner = $owner;
        $this->reasons = $reasons;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('आपके रूम के लिए कुछ बदलाव करने की आवश्यकता है')
                    ->view('emails.room-rejected')
                    ->with([
                        'roomTitle' => $this->room->title,
                        'ownerName' => $this->owner->name,
                        'roomId' => $this->room->id,
                        'roomAddress' => $this->room->address,
                        'roomPrice' => $this->room->rent,
                        'roomImage' => $this->room->photo ?? (is_array($this->room->photos) && count($this->room->photos) > 0 ? $this->room->photos[0] : null),
                        'reasons' => $this->reasons,
                    ]);
    }
}