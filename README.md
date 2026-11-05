# Campus Events Management System

A Laravel-based Campus Events Management System developed for the Web Development Week 10 assessment. This project demonstrates relational database design, PostgreSQL constraints, Eloquent ORM relationships, database seeding, and polymorphic relationships.

## Technologies Used

- Laravel 13
- PHP 8.4
- PostgreSQL
- Eloquent ORM
- Blade Templates

## Database Relationships

The database consists of five main tables: `venues`, `events`, `participants`, `event_participant`, and `notes`.

### Relationship Summary

| Relationship | Type | Foreign Key Owner | Eloquent Methods | ON DELETE |
|---|---|---|---|---|
| Venue → Events | One-to-Many | `events.venue_id` | `Venue::events()`, `Event::venue()` | RESTRICT |
| Events ↔ Participants | Many-to-Many | `event_participant.event_id`, `event_participant.participant_id` | `Event::participants()`, `Participant::events()` | CASCADE |
| Event → Notes | One-to-Many Polymorphic | `notes.noteable_id`, `notes.noteable_type` | `Event::notes()`, `Note::noteable()` | No database FK |
| Venue → Notes | One-to-Many Polymorphic | `notes.noteable_id`, `notes.noteable_type` | `Venue::notes()`, `Note::noteable()` | No database FK |

### Table Descriptions

**1. venues**

Stores campus venue information.

- `id` – Primary key
- `name` – Venue name
- `location` – Venue location
- `capacity` – Maximum venue capacity

**2. events**

Stores campus event information.

- `id` – Primary key
- `venue_id` – Foreign key referencing `venues.id`
- `title` – Event title
- `description` – Event description
- `event_date` – Event schedule

**3. participants**

Stores information about event participants.

- `id` – Primary key
- `name` – Participant name
- `email` – Participant email

**4. event_participant**

Pivot table connecting events and participants.

- `id` – Primary key
- `event_id` – Foreign key referencing `events.id`
- `participant_id` – Foreign key referencing `participants.id`
- `status` – Registration status (`registered` or `waitlisted`)

A composite unique constraint prevents the same participant from registering for the same event more than once.

**5. notes**

Stores notes associated with either an event or a venue through a polymorphic relationship.

- `id` – Primary key
- `noteable_id` – ID of the related record
- `noteable_type` – Model type of the related record
- `content` – Note content

## Eloquent Relationships

The project uses Laravel Eloquent relationships:

- `Venue` has many `Event` records.
- `Event` belongs to one `Venue`.
- `Event` belongs to many `Participant` records.
- `Participant` belongs to many `Event` records.
- `Event` has many polymorphic `Note` records.
- `Venue` has many polymorphic `Note` records.
- `Note` morphs to either an `Event` or a `Venue`.

## Database Constraints and Delete Behavior

- **Foreign Key Restrict:** A venue cannot be deleted while events are still referencing it.
- **Cascade Delete:** Deleting an event or participant automatically deletes its related pivot registrations.
- **Unique Constraint:** Duplicate event-participant registrations are not allowed.
- **Check Constraint:** Registration status must