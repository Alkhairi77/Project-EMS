erDiagram
    USERS ||--o{ EVENTS : "mengorganisir"
    EVENTS ||--o{ REGISTRATIONS : "memiliki pendaftaran"
    USERS ||--o{ REGISTRATIONS : "membeli tiket"

    USERS {
        object_id id PK
        string name
        string email
        string password
        string role
    }
    EVENTS {
        object_id id PK
        object_id user_id FK
        string judul
        string deskripsi
        string banner
        string lokasi
        int kapasitas
        int harga
        string tanggal
        string jam
        string kategori
        string status
    }
    REGISTRATIONS {
        object_id id PK
        object_id event_id FK
        object_id user_id FK
        string registration_code
        string status
    }
