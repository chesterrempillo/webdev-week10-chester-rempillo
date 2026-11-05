<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Note;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Every venue with the number of events it hosts
        $venues = Venue::withCount('events')->get();

        // Select one venue
        $chosenVenue = Venue::with('events')->first();

        // 2. All events at one chosen venue
        $venueEvents = $chosenVenue
            ? $chosenVenue->events
            : collect();

        // Select one event
        $chosenEvent = Event::with('participants')->first();

        // 3. All participants of one chosen event with status
        $eventParticipants = $chosenEvent
            ? $chosenEvent->participants
            : collect();

        // Select one participant
        $chosenParticipant = Participant::first();

        // 4. All events one chosen participant has joined
        $participantEvents = $chosenParticipant
            ? $chosenParticipant->events
            : collect();

        // 5. All events with at least one waitlisted participant
        $waitlistedEvents = Event::whereHas(
            'participants',
            function ($query) {
                $query->where(
                    'event_participant.status',
                    'waitlisted'
                );
            }
        )->with('participants')->get();

        // 6. Notes of one chosen event and one chosen venue
        $eventNotes = $chosenEvent
            ? $chosenEvent->notes
            : collect();

        $venueNotes = $chosenVenue
            ? $chosenVenue->notes
            : collect();

        // 7. Find the owner and type of one chosen note
        $chosenNote = Note::with('noteable')->first();

        $noteOwner = $chosenNote
            ? $chosenNote->noteable
            : null;

        $noteOwnerType = null;

        if ($noteOwner instanceof Event) {
            $noteOwnerType = 'Event';
        } elseif ($noteOwner instanceof Venue) {
            $noteOwnerType = 'Venue';
        }

        return view('reports.index', compact(
            'venues',
            'chosenVenue',
            'venueEvents',
            'chosenEvent',
            'eventParticipants',
            'chosenParticipant',
            'participantEvents',
            'waitlistedEvents',
            'eventNotes',
            'venueNotes',
            'chosenNote',
            'noteOwner',
            'noteOwnerType'
        ));
    }
}
