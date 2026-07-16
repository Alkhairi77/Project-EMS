flowchart LR
    Participant((Participant))
    Organizer((Organizer))

    subgraph Event Management System MVP
        UC1(Registrasi & Login Akun)
        UC2(Menelusuri & Cari Event)
        UC3(Mendaftar Event/Klaim Tiket)
        UC4(Melihat Tiket Web Digital)
        UC5(Kelola Event CRUD)
        UC6(Check-In Manual Peserta)
        UC7(Melihat Dashboard Ringkasan)
    end

    Participant --> UC1
    Participant --> UC2
    Participant --> UC3
    Participant --> UC4

    Organizer --> UC1
    Organizer --> UC2
    Organizer --> UC5
    Organizer --> UC6
    Organizer --> UC7
