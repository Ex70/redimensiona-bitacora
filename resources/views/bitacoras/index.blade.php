@extends('dashboard')

@section('scripts')
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('fullcalendar/lib/main.css') }}">
    <script src="{{ asset('fullcalendar/lib/main.js') }}" defer></script>
    <style>
            body {
                font-family: 'Nunito';
            }
            #calendar-container {
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
            }
            input,textarea{
                border: 1px solid #000000;
            }
            .fc-header-toolbar {
                /*
                the calendar will be butting up against the edges,
                but let's scoot in the header's buttons
                */
                padding-top: 1em;
                padding-left: 1em;
                padding-right: 1em;
            }
        </style>
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
                        click: function(info) {
                            $('#exampleModal').modal();
                        }
                    }
                },
                dateClick: function(info) {
                    $('#txtFecha').val(info.dateStr);
                    $('#exampleModal').modal();
                    console.log(info);
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
                    descripcion: "Descripción del evento 1"
                    }
                ]
            });
            calendar.setOption('locale', 'es');
            calendar.render();

            $('#btnAgregar').click(function(){
                ObjBitacora=recolectarDatosGUI("POST");

                EnviarInformacion('',ObjBitacora);
            });

            function recolectarDatosGUI(method){
                nuevaBitacora = {
                    id:$('#txtID').val(),
                    title:$('#txtTitle').val(),
                    descripcion:$('#txtDescripcion').val(),
                    color:$('#txtColor').val(),
                    textColor:'#FFFFFF',
                    start:$('#txtFecha').val()+" "+$('#txtHora').val(),
                    end:$('#txtFecha').val()+" "+$('#txtHora').val(),
                    '_token':$("meta[name='csrf-token']").attr("content"),
                    '_method':method
                }
                return (nuevaBitacora);
            }

            function EnviarInformacion(accion,objBitacora){
                $.ajax({
                    type:"POST",
                    url:"{{url('/bitacoras')}}"+accion,
                    data:objBitacora,
                    success:function(msg){console.log(msg);},
                    error: function(){ alert("Hay un error");}
                });
            }
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
                    <h5 class="modal-title" id="exampleModalLabel">Datos de la bitácora</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ID:
                    <input type="text" name="txtID" id="txtID">
                    <br>
                    Fecha:
                    <input type="text" name="txtFecha" id="txtFecha">
                    <br>
                    Título:
                    <input type="text" name="txtTitulo" id="txtTitulo">
                    <br>
                    Hora:
                    <input type="text" name="txtHora" id="txtHora">
                    <br>
                    Descripción:
                    <textarea name="txtDescripcion" id="txtDescripcion" cols="30" rows="10"></textarea>
                    <br>
                    COlor:
                    <input type="color" name="txtColor" id="txtColor">
                    <br>
                </div>
                <div class="modal-footer">
                    <button id="btnAgregar" class="btn btn-success">Agregar</button>
                    <button id="btnModificar" class="btn btn-warning">Modificar</button>
                    <button id="btnBorrar" class="btn btn-danger">Borrar</button>
                    <button id="btnCancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
