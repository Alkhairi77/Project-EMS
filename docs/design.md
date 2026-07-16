# Design System Guidelines: Event Management System (EMS) MVP

This document establishes the UI/UX design specifications, typographic principles, and component aesthetic standards for the **Event Management System (EMS) MVP**. Based on **Combination 1 (Professional & Vibrant)**, these rules are optimized for rapid, native implementation within **Tailwind CSS** inside **Laravel Blade** templates.

---

## 1. Color Palette (Tailwind CSS Tokens)

The app leverages a professional, high-contrast palette. Muted background slates provide structural clarity for dashboard layouts, vibrant indigos power user interactions, and clean emerald tones anchor status tracking.

### 1.1 Brand & Action Colors
*   **Primary / Brand Action:** `Indigo 600` (`#4f46e5`) & `Indigo 700` (`#4338ca`)
    *   *Usage:* Global navigation items, interactive buttons ("Daftar Sekarang", "Create Event"), focused field borders.
*   **Success / Verification Accent:** `Emerald 500` (`#10b981`) & `Emerald 600` (`#059669`)
    *   *Usage:* Ticket confirmation labels, gate check-in success triggers, total revenue metrics indicators.
*   **Warning / State Accent:** `Amber 500` (`#f59e0b`) & `Amber 600` (`#d97706`)
    *   *Usage:* Imminent capacity alerts, unresolved event drafts.
*   **Danger / Cancellation Accent:** `Rose 500` (`#f43f5e`) & `Rose 600` (`#e11d48`)
    *   *Usage:* Delete triggers, event cancellation alerts, structural input validation error blocks.

### 1.2 Layout & Neutral Tones
*   **App Canvas Background:** `Slate 50` (`#f8fafc`)
*   **Surface Cards / Form Panes:** `White` (`#ffffff`)
*   **Structural Borders & Dividers:** `Slate 200` (`#e2e8f0`)
*   **Primary Body Text:** `Slate 900` (`#0f172a`)
*   **Secondary Context / Subtext:** `Slate 500` (`#64748b`)

---

## 2. Typography & Hierarchy

The application utilizes native system fonts configured out-of-the-box by Tailwind CSS, preventing asset loading latency and maintaining clean interfaces.

*   **Primary Font Family:** `Sans-serif` stack (Inter / System UI) via Tailwind's `font-sans`.
*   **Monospace Font Family (Tickets only):** `Monospace` stack via Tailwind's `font-mono` (Specifically for displaying `registration_code` like `EVT-2026-XXXX`).

### 2.1 Scale Matrix
*   **Application Title / Main Headers:** `text-2xl font-bold tracking-tight text-slate-900` (~24px)
*   **Section Header / Card Titles:** `text-lg font-semibold text-slate-900` (~18px)
*   **Regular Body Text:** `text-sm font-normal text-slate-600` (~14px)
*   **Metadata / Captions / Inline Labels:** `text-xs font-medium text-slate-500` (~12px)

---

## 3. Structural Semantics & Layout Rules

To keep user workflows lightweight, layouts must remain clean, predictable, and clear. Avoid nested layout boxes, floating hero cards, or heavy non-functional graphic shapes.

### 3.1 Global Structural Guidelines
*   **App Canvas:** The base body background is anchored to `bg-slate-50`. Content frames wrap cleanly inside `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`.
*   **Containers & Cards:** Content blocks live within cards set to `bg-white shadow-sm border border-slate-200/80 rounded-lg`.
*   **Form Elements:** Forms share consistent layout classes: `block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm`.

---

## 4. Specific Component Aesthetic Blueprints

### 4.1 Global Navigation Header Bar
A minimalist top header bar pinned to the canvas top boundary:
*   **Background:** `bg-white border-b border-slate-200`
*   **Brand Type:** `text-lg font-bold text-indigo-600 tracking-tight`
*   **Active States:** Link items use `text-slate-900 border-b-2 border-indigo-500`, while secondary elements utilize `text-slate-500 hover:text-slate-700`.

### 4.2 Public Event Feed Cards
Compact grids hosting active listings:
*   **Card Wrapper:** `flex flex-col overflow-hidden bg-white rounded-lg border border-slate-200 transition hover:shadow-md`
*   **Image Framework:** Fixed height ratio container (`aspect-video bg-slate-100 object-cover`).
*   **Category Badge Layer:** Absolute positioning overlay at the frame corner: `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700`.

### 4.3 Interactive Context Status Badges
Status chips displayed in tables and active dashboards:
*   **Published / Checked In:** `bg-emerald-50 text-emerald-700 border border-emerald-200`
*   **Registered / Draft:** `bg-blue-50 text-blue-700 border border-blue-200`
*   **Cancelled:** `bg-rose-50 text-rose-700 border border-rose-200`

### 4.4 Participant Digital Ticket Grid
A physical-looking digital ticket coupon element displayed on the client dashboard screen:
*   **Ticket Body:** `bg-white border-2 border-dashed border-slate-200 rounded-xl p-6 shadow-sm flex items-center justify-between`
*   **Identifier Display:** The `registration_code` is formatted using `font-mono font-bold tracking-wider text-base text-indigo-600 bg-slate-50 px-3 py-1 rounded border border-slate-200`.

### 4.5 Organizer Management Ribbon (Metrics Summary)
High-level summary blocks pinned above administrative list layout wrappers:
*   **Grid Style:** 3-column structural layout wrapper.
*   **Individual Unit Box:** `bg-white border border-slate-200 rounded-lg p-5 flex flex-col`
*   **Label Layout:** Metric description goes on top (`text-xs font-medium text-slate-500 uppercase tracking-wider`). The raw scalar totals live underneath (`text-3xl font-bold text-slate-900 tracking-tight mt-1`).
