@extends('welcome')

@section('scripts')
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('fullcalendar/lib/main.css') }}">
    <script src="{{ asset('fullcalendar/lib/main.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today Miboton',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                customButtons: {
                    Miboton: {
                        text: 'Botón',
                        click: function() {
                            alert('¡Hola Mundo!');
                            $('#exampleModal').modal('toggle');
                        }
                    }
                },
                dateClick: function(info) {
                    $('#exampleModal').modal();
                    console.log(info);
                    // alert('Date: ' + info.dateStr);
                    // alert('Resource ID: ' + info.resource.id);
                    calendar.addEvent({title: "Evento x", date:info.dateStr})
                },
                eventClick: function(info){
                    console.log(info);
                    console.log(info.event.title);
                    console.log(info.event.start);

                    console.log(info.event.extendedProps.descripcion);
                },
                events: [
                    {
                    id: 'a',
                    title: 'Evento 1',
                    start: '2020-10-26 12:30:00',
                    descripcion: "Descripciòn del evento 1"
                    }
                ]
            });
            calendar.setOption('locale', 'es');
            calendar.render();
        });
    </script>
@endsection

@section('content')
    <div id='calendar-container'>
        <div id='calendar'></div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                ...
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
