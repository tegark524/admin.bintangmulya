@extends('layouts.app')

@section('content')
    <div class="container">
        @if (isset($events) && $events->isNotEmpty())
            @if ($events->first()['extendedProps']['instructor'] === 'Instruktur Contoh')
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle"></i>
                    Menampilkan data contoh. Tambahkan jadwal nyata melalui form.
                </div>
            @endif

            <div id="calendar"></div>
        @else
            <div class="alert alert-warning">
                Tidak ada data jadwal yang tersedia.
            </div>
        @endif
    </div>

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            if (calendarEl) { // Pastikan element ada
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: @json($events ?? []),
                    eventContent: function(info) {
                        return {
                            html: `
                            <div class="fc-event-title">${info.event.title}</div>
                            <div class="fc-event-instructor">
                                ${info.event.extendedProps.instructor}
                            </div>
                        `
                        };
                    }
                });
                calendar.render();
            }
        });
    </script>
@endsection
@endsection
