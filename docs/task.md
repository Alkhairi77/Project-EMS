# Roadmap & Task List: Event Management System (EMS) MVP

This roadmap outlines the step-by-step implementation plan for building the simplified **Event Management System (EMS) MVP** using **Laravel 11**, **Laravel Blade (Tailwind CSS via Breeze)**, and **MongoDB**. 

Each task is structured to be atomic, easily testable, and fully optimized for execution by an AI development agent.

---

## Phase 1: Environment Setup & Foundation (Goal: Ready-to-build Workspace)
*Objective: Prepare the project environment, integrate MongoDB support, and configure the base styling.*

- [ ] **Task 1.1: Initialize Laravel 11 Project**
  - Run `composer create-project laravel/laravel ems-app`.
  - Configure the `.env` file to set up basic application details.
- [ ] **Task 1.2: Install and Configure MongoDB ODM**
  - Install the official MongoDB Laravel package: `composer require mongodb/laravel-mongodb`.
  - Configure the database connection in `config/database.php` under the `mongodb` driver.
  - Update `.env` with the appropriate MongoDB connection details (`DB_CONNECTION=mongodb`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`).
  - Test the database connection by running a simple migration or sanity check.
- [ ] **Task 1.3: Install Laravel Breeze (Session/Blade Version)**
  - Run `composer require laravel/breeze --dev`.
  - Run `php artisan breeze:install blade` to generate standard views, assets, and authentication controllers.
  - Set up build tools: Run `npm install && npm run build` (or keep Vite dev server running).

---

## Phase 2: Database Architecture & Models (Goal: Flexible NoSQL Schema)
*Objective: Create database models and migrations customized for MongoDB collections.*

- [ ] **Task 2.1: Implement User Authentication and Roles**
  - Update the default `User` model to extend `MongoDB\Laravel\Eloquent\Model`.
  - Add a `role` field (with enum values: `organizer`, `participant`) to the registration validation and default creation logic in `RegisteredUserController`.
- [ ] **Task 2.2: Create Event Model & Migration**
  - Generate the model: `php artisan make:model Event`.
  - Configure schema columns: `judul`, `deskripsi`, `banner` (file path string), `lokasi`, `kapasitas` (integer), `harga` (integer), `tanggal` (date), `jam` (time), `kategori`, `status` (`Draft`, `Published`, `Cancelled`), and `user_id` (foreign key pointing to the Organizer).
- [ ] **Task 2.3: Create Registration (Ticket) Model & Migration**
  - Generate the model: `php artisan make:model Registration`.
  - Configure schema columns: `event_id`, `user_id` (Participant ID), `registration_code` (unique formatted string, e.g., `EVT-2026-XXXX`), `status` (`Registered`, `Checked In`), and `registered_at` (timestamp).

---

## Phase 3: Core Application Controller & Routing (Goal: Functional Backend)
*Objective: Write the server-side logic controlling event management, booking, and check-in.*

- [ ] **Task 3.1: Define Web Routes (`routes/web.php`)**
  - Set up group routing with auth middleware.
  - Define separate route groups protected by role-checking middleware (or inline logic matching `$user->role`):
    - **Organizer Routes:** `/organizer/dashboard`, `/organizer/events/*` (Resource CRUD), `/organizer/events/{id}/attendees`, `/organizer/registrations/{id}/checkin`.
    - **Participant Routes:** `/dashboard` (My Tickets), `/events`, `/events/{id}`, `/events/{id}/register`.
- [ ] **Task 3.2: Build Event CRUD Controller (Organizer)**
  - Create `EventController` to handle creating, editing, displaying, and deleting events.
  - Handle banner image uploads: Securely store images in local storage (`public` disk) and save the generated path to the event document.
- [ ] **Task 3.3: Build Event Browse & Search (Participant)**
  - Create a public-facing controller to query all `Published` events.
  - Write simple search query logic targeting the `judul` field.
  - Implement a simple filter query targeting the `kategori` field.
- [ ] **Task 3.4: Build Registration & Quota Subsystem**
  - Implement the registration logic.
  - **Critical Implementation:** Wrap registration inside a robust controller check. Check if sisa kuota (`kapasitas` - existing registrations) is > 0.
  - Decrement the `kapasitas` field or track occupancy using atomic database counters, then save a new record to the `registrations` collection with a generated unique ticket ID.

---

## Phase 4: UI/UX Implementation (Goal: Polished Laravel Blade Dashboard)
*Objective: Design clean, responsive interfaces using Tailwind CSS matching the PRD specification.*

- [ ] **Task 4.1: Design Participant Event Feed & Detail Pages**
  - Create a clean catalog grid showing event cards (thumbnail banner, title, date, category tag).
  - Create an elegant details page showing all event metadata, description text, sisa kuota, and a prominent **"Daftar Sekarang"** action button.
- [ ] **Task 4.2: Design Participant Ticket Dashboard**
  - Design a ticket management page split into two tabs: "Upcoming Events" and "Past Events".
  - Display digital cards representing active tickets featuring the unique registration code (`EVT-2026-XXXX`) and clear state indicator labels (`Registered` / `Checked In`).
- [ ] **Task 4.3: Design Organizer Dashboard & Participant Table**
  - Design an administrative metric strip (Total Events, Total Participants, Active Events).
  - Build an Event Management table showing event metadata with "View Attendees" action links.
  - Create the Attendee Management interface showing list rows containing registered participant names, registration timestamps, and an immediate actionable **"Set Hadir (Check In)"** form submission button.

---

## Phase 5: Testing, Manual Validations, & Handoff (Goal: Production-Ready MVP)
*Objective: Run end-to-end user flows to ensure absolute stability and bug-free execution.*

- [ ] **Task 5.1: Functional Flow Verification**
  - Register as an Organizer and successfully create an event with a banner upload.
  - Register as a Participant, search for the newly created event, and execute registration.
  - Validate that the sisa kuota updates correctly and the registration record is added.
- [ ] **Task 5.2: Attendance Flow Validation**
  - Log back in as the Organizer, navigate to the attendee list of the event, click **"Check In"** next to the participant's name, and confirm that the status updates instantly to `Checked In`.
- [ ] **Task 5.3: Clean Up & Handoff Documentation**
  - Clean up any temporary seeding scripts.
  - Run optimization commands (`php artisan route:cache`, `php artisan view:cache`).
