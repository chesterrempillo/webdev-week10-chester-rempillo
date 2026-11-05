<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Events Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }
        .container {
            max-width: 1100px;
            margin: auto;
        }
        h1 { color: #173b70; }
        .card {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #0001;
        }
        h2 {
            color: #24558c;
            font-size: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th { background: #edf2f8; }
        .empty { color: #888; }
    </style>
</head>
<body>
<div class="container">

    <h1>Campus Events Management System</h1>
    <p>Database Reports</p>

    <div class="card">
        <h2>1. All Venues with Number of Events</h2>
        <table>
            <tr><th>Venue</th><th>Location</th><th>Total Events</th></tr>
            @foreach($venues as $venue)
                <tr>
                    <td>{{ $venue->name }}</td>
                    <td>{{ $venue->location }}</td>
                    <td>{{ $venue->events_count }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="card">
        <h2>2. Events at One Chosen Venue</h2>
        <p><strong>Venue:</strong> {{ $chosenVenue->name ?? 'No venue found' }}</p>
        @forelse($venueEvents as $event)
            <p>{{ $event->title }} — {{ $event->event_date }}</p>
        @empty
            <p class="empty">No events found.</p>
        @endforelse
    </div>

    <div class="card">
        <h2>3. Participants of One Chosen Event</h2>
        <p><strong>Event:</strong> {{ $chosenEvent->title ?? 'No event found' }}</p>
        @forelse($eventParticipants as $participant)
            <p>{{ $participant->name }} — Status: {{ $participant->pivot->status }}</p>
        @empty
            <p class="empty">No participants found.</p>
        @endforelse
    </div>

    <div class="card">
        <h2>4. Events Joined by One Chosen Participant</h2>
        <p><strong>Participant:</strong> {{ $chosenParticipant->name ?? 'No participant found' }}</p>
        @forelse($participantEvents as $event)
            <p>{{ $event->title }}</p>
        @empty
            <p class="empty">No events joined.</p>
        @endforelse
    </div>

    <div class="card">
        <h2>5. Events with Waitlisted Participants</h2>
        @forelse($waitlistedEvents as $event)
            <p>{{ $event->title }}</p>
        @empty
            <p class="empty">No waitlisted events found.</p>
        @endforelse
    </div>

    <div class="card">
        <h2>6A. Notes of One Chosen Event</h2>
        @forelse($eventNotes as $note)
            <p>{{ $note->content ?? $note->body ?? $note->note }}</p>
        @empty
            <p class="empty">No event notes found.</p>
        @endforelse
    </div>

    <div class="card">
        <h2>6B. Notes of One Chosen Venue</h2>
        @forelse($venueNotes as $note)
            <p>{{ $note->content ?? $note->body ?? $note->note }}</p>
        @empty
            <p class="empty">No venue notes found.</p>
        @endforelse
    </div>

    <div class="card">
        <h2>7. Owner and Type of One Chosen Note</h2>
        @if($chosenNote)
            <p><strong>Note:</strong> {{ $chosenNote->content ?? $chosenNote->body ?? $chosenNote->note }}</p>
            <p><strong>Owner Type:</strong> {{ class_basename($chosenNote->noteable_type) }}</p>
            <p><strong>Owner:</strong> {{ $chosenNote->noteable->name ?? $chosenNote->noteable->title ?? 'Unknown' }}</p>
        @else
            <p class="empty">No note found.</p>
        @endif
    </div>

</div>
</body>
</html>