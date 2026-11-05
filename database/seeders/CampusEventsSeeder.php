<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venue;
use App\Models\Event;
use App\Models\Participant;

class CampusEventsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create 3 Venues
        $venues = [
            Venue::create([
                'name' => 'PUP Main Auditorium',
                'location' => 'Calauan, Laguna',
                'capacity' => 500,
            ]),
            Venue::create([
                'name' => 'Computer Laboratory',
                'location' => 'PUP Calauan Campus',
                'capacity' => 100,
            ]),
            Venue::create([
                'name' => 'Campus Gymnasium',
                'location' => 'PUP Calauan Campus',
                'capacity' => 300,
            ]),
        ];

        // 2. Create 6 Events through Venue relationships
        $events = [
            $venues[0]->events()->create([
                'title' => 'Campus Foundation Day',
                'description' => 'Annual campus celebration.',
                'event_date' => '2026-11-15',
            ]),
            $venues[0]->events()->create([
                'title' => 'Student Leadership Seminar',
                'description' => 'Leadership training for students.',
                'event_date' => '2026-11-18',
            ]),
            $venues[1]->events()->create([
                'title' => 'Web Development Workshop',
                'description' => 'Introduction to web development.',
                'event_date' => '2026-11-20',
            ]),
            $venues[1]->events()->create([
                'title' => 'Programming Competition',
                'description' => 'Programming challenge for students.',
                'event_date' => '2026-11-22',
            ]),
            $venues[2]->events()->create([
                'title' => 'Sports Festival',
                'description' => 'Annual campus sports activities.',
                'event_date' => '2026-11-25',
            ]),
            $venues[2]->events()->create([
                'title' => 'Community Outreach',
                'description' => 'Community service program.',
                'event_date' => '2026-11-28',
            ]),
        ];

        // 3. Create 8 Participants
        $participants = [];

        $names = [
            'Juan Dela Cruz',
            'Maria Santos',
            'Pedro Reyes',
            'Ana Garcia',
            'Mark Lopez',
            'Sofia Ramos',
            'Carlo Mendoza',
            'Angela Flores',
        ];

        foreach ($names as $index => $name) {
            $participants[] = Participant::create([
                'name' => $name,
                'email' => 'participant' . ($index + 1) . '@example.com',
            ]);
        }

        // 4. Create registrations through Event relationships
        // Both registered and waitlisted statuses are used.

        $registrations = [
            0 => [
                0 => 'registered',
                1 => 'registered',
                2 => 'waitlisted',
            ],
            1 => [
                1 => 'registered',
                3 => 'waitlisted',
            ],
            2 => [
                2 => 'registered',
                4 => 'registered',
            ],
            3 => [
                3 => 'registered',
                5 => 'waitlisted',
            ],
            4 => [
                4 => 'registered',
                6 => 'waitlisted',
            ],
            5 => [
                5 => 'registered',
                7 => 'registered',
            ],
        ];

        foreach ($registrations as $eventIndex => $attendees) {
            foreach ($attendees as $participantIndex => $status) {
                $events[$eventIndex]->participants()->attach(
                    $participants[$participantIndex]->id,
                    ['status' => $status]
                );
            }
        }

        // 5. Create 6 Notes using polymorphic relationships

        $events[0]->notes()->create([
            'content' => 'Prepare the program and event materials.',
        ]);

        $events[2]->notes()->create([
            'content' => 'Check all computers before the workshop.',
        ]);

        $events[4]->notes()->create([
            'content' => 'Prepare sports equipment.',
        ]);

        $venues[0]->notes()->create([
            'content' => 'Main auditorium requires sound system testing.',
        ]);

        $venues[1]->notes()->create([
            'content' => 'Computer laboratory has 50 available computers.',
        ]);

        $venues[2]->notes()->create([
            'content' => 'Gymnasium must be cleaned before events.',
        ]);

        $this->command->info('Campus Events sample data created successfully!');
    }
}
