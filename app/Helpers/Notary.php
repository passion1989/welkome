<?php

namespace App\Helpers;

use App\Helpers\Writer;
use App\Models\Guest;
use App\Models\Hotel;
use App\Models\Note;
use App\Models\Room;
use App\Models\Tag;
use App\Models\Vehicle;
use App\Models\Voucher;

class Notary
{
    /**
     * Hotel owner of the new note
     *
     * @var \App\Models\Hotel
     */
    private Hotel $hotel;

    /**
     * Construct function
     *
     * @param \App\Models\Hotel $hotel
     */
    public function __construct(Hotel $hotel)
    {
        $this->hotel = $hotel;
    }

    /**
     * Create note for guest check in
     *
     * @param \App\Models\Voucher $voucher
     * @param \App\Models\Guest $guest
     * @param \App\Models\Room $room
     * @return void
     */
    public function checkinGuest(Voucher $voucher, Guest $guest, Room $room): void
    {
        $writer = new Writer();
        $writer->checkin($voucher)
            ->guest($guest)
            ->room($room);

        $this->createNote($writer->write(), 'check-in');
    }

    /**
     * Create note for guest check out
     *
     * @param \App\Models\Voucher $voucher
     * @param \App\Models\Guest $guest
     * @param \App\Models\Room $room
     * @return void
     */
    public function checkoutGuest(Voucher $voucher, Guest $guest, Room $room): void
    {
        $writer = new Writer();
        $writer->checkout($voucher)
            ->guest($guest)
            ->room($room);

        $this->createNote($writer->write(), 'check-out');
    }

    /**
     * Create note for check out of many guests
     *
     * @param \App\Models\Voucher $voucher
     * @return void
     */
    public function checkoutGuests(Voucher $voucher): void
    {
        $writer = new Writer();
        $writer->checkout($voucher)
            ->guests($voucher->guests);

        $this->createNote($writer->write(), 'check-out');
    }

    /**
     * Create note for vehicle entry
     *
     * @param \App\Models\Voucher $voucher
     * @param \App\Models\Guest $guest
     * @param \App\Models\Vehicle $vehicle
     * @return void
     */
    public function vehicleEntry(Voucher $voucher, Guest $guest, Vehicle $vehicle)
    {
        $writer = new Writer;
        $writer->vehicle($voucher, $vehicle)
            ->owner($guest);

        $this->createNote($writer->write(), 'vehicle');
    }

    /**
     * Store new note
     *
     * @param string $content
     * @param string $tag
     * @return void
     */
    private function createNote(string $content, string $tag): void
    {
        $note = new Note();
        $note->content = $content;
        $note->team_member_name = auth()->user()->name;
        $note->team_member_email = auth()->user()->email;
        $note->hotel()->associate($this->hotel->id);
        $note->user()->associate(id_parent());
        $note->save();

        // Attach tag
        $note->tags()->attach($this->getTag($tag)->id);
    }

    /**
     * Return a existing Tag or create Tag
     *
     * @param string $tag
     * @return \App\Models\Tag
     */
    private function getTag(string $tag): Tag
    {
        $tag = Tag::firstOrNew([
            'description' => $tag
        ]);

        $tag->user()->associate(id_parent());
        $tag->saveOrFail();

        return $tag;
    }

    /**
     * Create new Notary object
     *
     * @param \App\Models\Hotel $hotel
     * @return \App\Helpers\Notary
     */
    public static function create(Hotel $hotel): Notary
    {
        return new Notary($hotel);
    }
}
