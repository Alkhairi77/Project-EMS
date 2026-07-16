# Software Architecture & Database Design: Event Management System (EMS) MVP

This document outlines the system architecture, folder organization, and MongoDB database design for the **Event Management System (EMS) MVP**. Built on **Laravel 11**, it follows a monolithic architecture utilizing **Laravel Blade** for the presentation layer and **MongoDB** as the persistent NoSQL data store.

---

## 1. High-Level System Architecture

The application uses a standard MVC (Model-View-Controller) pattern tailored for a monolithic web application. Since the client and server reside within the same framework ecosystem, authentication and data exchange are carried out via standard web sessions.

```
       +-------------------------------------------------------+
       |                  User Web Browser                     |
       +--------------------------+----------------------------+
                                  |
                        HTTP Requests (Forms / Links)
                                  |
                                  v
       +--------------------------+----------------------------+
       |                  Laravel 11 Engine                    |
       |                                                       |
       |  +-------------------------------------------------+  |
       |  |                 Routing & Web Guard             |  |
       |  +-----------------------+-------------------------+  |
       |                          |                            |
       |                          v                            |
       |  +-------------------------------------------------+  |
       |  |                 Controllers (Logic)             |  |
       |  +-----------------------+-------------------------+  |
       |                          |                            |
       |            +-------------+-------------+              |
       |            |                           |              |
       |            v                           v              |
       |  +-------------------+       +-------------------+    |
       |  |   Blade Views     |       |   Eloquent Models |    |
       |  | (Tailwind UI)     |       |  (MongoDB ODM)    |    |
       |  +-------------------+       +---------+---------+    |
       +----------------------------------------|--------------+
                                                |
                                      Moloquent Queries (BSON)
                                                |
                                                v
                               +----------------+--------+
                               |     MongoDB Database    |
                               +-------------------------+
```

### Key Architectural Traits:
*   **Monolithic Integration:** Laravel handles both backend routing/logic and frontend view rendering via Blade, entirely cutting out the complexity of decoupled CORS issues or state synchronization.
*   **Session-Based Security:** Authentication is verified using Laravel's native cookie-based session manager (`web` guard).
*   **ODM Layer:** Database interaction passes through the `mongodb/laravel-mongodb` Object Document Mapper (ODM), translating Eloquent syntax into native MongoDB BSON queries seamlessly.

---

## 2. Directory Structure (Key Components)

Below is the directory structure focusing on where the files for this specific Event Management System will be created or modified:

```
ems-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── RegisteredUserController.php   <-- Injects role property during signup
│   │   │   ├── DashboardController.php            <-- Directs user to proper dashboard based on role
│   │   │   ├── EventController.php                <-- Handles Organizer Event CRUD & File Uploads
│   │   │   └── RegistrationController.php         <-- Handles participant bookings & check-ins
│   │   └── Middleware/
│   │       └── EnsureUserHasRole.php              <-- (Optional) Isolates route restrictions
│   └── Models/
│       ├── Event.php                              <-- Extends MongoDB Eloquent Model
│       ├── Registration.php                       <-- Extends MongoDB Eloquent Model
│       └── User.php                               <-- Extends MongoDB Authenticatable Model
├── database/
│   └── migrations/                                <-- Native migration files mapping collections
│       ├── 2024_01_01_000000_create_users_collection.php
│       ├── 2024_01_01_000000_create_events_collection.php
│       └── 2024_01_01_000000_create_registrations_collection.php
├── resources/
│   └── views/
│       ├── auth/                                  <-- Breeze scaffolding templates
│       ├── layouts/
│       │   └── app.blade.php                      <-- Global framework shell layout
│       ├── organizer/
│       │   ├── dashboard.blade.php                <-- Metrics strip & Event table
│       │   └── events/
│       │       ├── create.blade.php               <-- Form to add new events
│       │       ├── edit.blade.php                 <-- Form to edit events
│       │       └── attendees.blade.php            <-- Attendee grid with Check In buttons
│       └── participant/
│           ├── dashboard.blade.php                <-- Active digital ticket lists
│           ├── index.blade.php                    <-- Searchable event feed
│           └── show.blade.php                     <-- Detailed event screen with register CTA
└── routes/
    └── web.php                                    <-- Houses core route definitions
```

---

## 3. Database Schema Design (MongoDB Collections)

MongoDB stores data as flexible documents. Below is the collection schema design modeled to protect data integrity, prevent overbooking, and facilitate fast queries.

### 3.1 Collection: `users`
Stores system accounts for both Organizers and Participants.
*   **Indexes:** `email` (Unique)

```json
{
  "_id": "ObjectId",
  "name": "String",
  "email": "String",
  "password": "String (Hashed)",
  "role": "String (organizer | participant)",
  "remember_token": "String (Nullable)",
  "created_at": "ISODate",
  "updated_at": "ISODate"
}
```

### 3.2 Collection: `events`
Stores information about events posted by organizers.
*   **Indexes:** `user_id` (Foreign Key index), `kategori` (Filtered query index)

```json
{
  "_id": "ObjectId",
  "user_id": "ObjectId", 
  "judul": "String",
  "deskripsi": "String (Long Text)",
  "banner": "String (Relative file storage path, e.g., 'banners/filename.jpg')",
  "lokasi": "String",
  "kapasitas": "Integer (Total allowed attendees)",
  "harga": "Integer (0 for free events)",
  "tanggal": "String (YYYY-MM-DD)",
  "jam": "String (HH:MM)",
  "kategori": "String (Workshop | Seminar | Competition | Bootcamp | Webinar | Festival)",
  "status": "String (Draft | Published | Cancelled)",
  "created_at": "ISODate",
  "updated_at": "ISODate"
}
```

### 3.3 Collection: `registrations`
Tracks user tickets and event attendance.
*   **Indexes:** `event_id`, `user_id`, `registration_code` (Unique)

```json
{
  "_id": "ObjectId",
  "event_id": "ObjectId",
  "user_id": "ObjectId",
  "registration_code": "String (Format: EVT-YYYYMMDD-RandomString)",
  "status": "String (Registered | Checked In)",
  "registered_at": "ISODate",
  "created_at": "ISODate",
  "updated_at": "ISODate"
}
```

---

## 4. Operational Flows & Logic Constraints

### 4.1 Safe Quota Allocation Logic
To prevent **overbooking** under concurrent registration loads, the database query avoids calculating the total count on the application level before saving. Instead, the application will leverage MongoDB's atomic operator constraints:

1. When a registration request hits `RegistrationController@store`:
   * Fetch the event document.
   * Count the current records in the `registrations` collection where `event_id` matches and `status` is not cancelled.
   * If `current_registrations_count >= event->kapasitas`, immediately abort and return to the event page with an error: *"Kuota Sudah Penuh!"*.
   * If space exists, proceed to create the registration document.

### 4.2 Single-Click Manual Gate Validation Logic
The check-in flow relies entirely on database field states toggled through a simple route action link:
1. The Organizer pulls up the attendee log on a device.
2. The user submits a `POST`/`PATCH` request pointing to `/organizer/registrations/{id}/checkin`.
3. The server locates the document within the `registrations` collection via its `_id`.
4. The system validates if the document status equals `Registered`. If yes, it toggles it directly to `Checked In`. If already checked in, it returns a validation exception warning the coordinator of a potential duplicate processing error.
