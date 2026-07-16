classDiagram
    class User {
        +ObjectId id
        +String name
        +String email
        +String password
        +String role
    }
    class Event {
        +ObjectId id
        +ObjectId user_id
        +String judul
        +String deskripsi
        +String banner
        +String lokasi
        +Integer kapasitas
        +Integer harga
        +String tanggal
        +String jam
        +String kategori
        +String status
    }
    class Registration {
        +ObjectId id
        +ObjectId event_id
        +ObjectId user_id
        +String registration_code
        +String status
    }

    User "1" -- "*" Event : "Membuat (Organizer)"
    Event "1" -- "*" Registration : "Memiliki Pendaftar"
    User "1" -- "*" Registration : "Mengklaim Tiket (Participant)"
