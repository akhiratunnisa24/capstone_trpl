@extends('layouts.default')
@section('content')
<!-- Header -->
<link href="assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet" />
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="assets/plugins/moment/moment.js"></script>
<script src='assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header-title">
            <h4 class="pull-left page-title">Kalender Kerja</h4>
            <ol class="breadcrumb pull-right">
                <li>Human Resources Management System</li>
                <li class="active">Kalender Kerja</li>
            </ol>
            <div class="clearfix">
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">

        <div class="row">
            <div class="col-sm-3">
                <div class="panel panel-secondary">
                    <div class="panel panel-heading">
                        <h4  style="margin-left:35px">Form Kegiatan</h4>
                    </div>
                    <div class="panel-body">
                        <form method="POST" id="add_event_form" action="/store-kegiatan">
                            @csrf
                            @method('post')
                            <div class="form-group">
                                <div class="form-label">Judul Kegiatan</div>
                                <input type="text" class="form-control" name="judul" id="tglmulai" autocomplete="off" placeholder="Masukkan Judul.." required>
                                <input type="hidden" class="form-control" name="id_pegawai" id="id_pegawai" value="{{Auth::user()->id_pegawai}}">
                            </div>
                            <div class="form-group mt-4">
                                <div class="form-label">Tgl Mulai</div>
                                <input type="datetime-local" class="form-control" name="tglmulai" id="mulai">
                            </div>
                            <div class="form-group mt-4">
                                <div class="form-label">Tgl Selesai</div>
                                <input type="datetime-local" class="form-control" name="tglselesai" id="selesai">
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success" style="margin-left:65px">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-3 col-md-3">
                <h4>Form Kegiatan</h4>
                <form method="post" id="add_event_form">
                    <div class="page">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-label">Judul Kegiatan</div>
                                <input type="text" class="form-control" name="judul" id="tglmulai">
                                <input type="hidden" class="form-control" name="id_pegawai" id="id_pegawai" value="{{Auth::user()->id_pegawai}}">
                            </div>
                            <div class="form-group mt-4">
                                <div class="form-label">Tgl Mulai</div>
                                <input type="datetime-local" class="form-control" name="tglmulai" id="mulai">
                            </div>
                            <div class="form-group mt-4">
                                <div class="form-label">Tgl Selesai</div>
                                <input type="datetime-local" class="form-control" name="tglselesai" id="selesai">
                            </div>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div> --}}
            <div id='calendar' class="col-md- col-lg-9"></div>
        </div>
    </div> <!-- container -->
</div> 
 {{-- <script>
                $(document).ready(function() {
                    $('#calendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        }, 
                        // events: [ 
                        //     @foreach($getHarilibur as $harilibur) 
                        //         { 
                        //             title: "{{$harilibur->keterangan}}", 
                        //             start:  "{{$harilibur->tanggal}}", 
                        //             type : "{{ $harilibur->tipe}}" 
                        //         }, 
                        //     @endforeach 
                        // ], 
                        editable: false,
                        events: {
                            url: '/get-harilibur-data',
                            type: 'GET',
                            error: function() {
                                alert('Error fetching events');
                            },
                            success: function(data) {
                            var events = [];
                            $(data.events).each(function() {
                                events.push({
                                    title: this.title,
                                    start: this.date,
                                    color: this.tipe == 'Hari Libur Nasional' ? 'red' : 'blue'
                                });
                            });
                            $('#calendar').fullCalendar('renderEvents', events, true);
                        }
                        },
                        eventRender: function(event, element) {
                            element.attr('title', event.type);
                        }
                    });
                });
            </script> --}}
<!-- content -->
  {{-- <h4>Created Events</h4>
                <form method="post" id="add_event_form">
                    <input type="text" class="form-control new-event-form" placeholder="Add new event..." />
                </form>

                <div id='external-events'>
                    <h4 class="m-b-15">Draggable Events</h4>
                </div>
                <!-- checkbox -->
                <div class="checkbox checkbox-custom">
                    <input id="drop-remove" type="checkbox">
                    <label for="drop-remove">
                        Remove after drop
                    </label>
                </div> --}}

<!-- jQuery  -->
   
   {{-- <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>  --}}

    <!-- BEGIN PAGE SCRIPTS -->
    <!-- Jquery-Ui -->
  
    <script src="assets/pages/calendar-init.js"></script>
    {{-- <script src="assets/js/app.js"></script>
    <script>
        $(document).ready(function(){
            var harilibur = json_encode($events);
            console.log(harilibur);
            $('#calendar').fullCalendar({
                header:{
                    left: 'prev,next today',
                    center:'title',
                    right: 'month,basicWeek,basicDay'
                },
                events : {harilibur}
            })
        });
    </script> --}}
    {{-- <script>
        $(document).ready(function () {
           
        var SITEURL = "{{ url('/') }}";
          
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          
        var calendar = $('#calendar').fullCalendar({
                            editable: true,
                            events: SITEURL + "/get-harilibur-data",
                            displayEventTime: false,
                            editable: true,
                            eventRender: function (event, element, view) {
                                if (event.allDay === 'true') {
                                        event.allDay = true;
                                } else {
                                        event.allDay = false;
                                }
                            },
                            selectable: true,
                            selectHelper: true,
                            select: function (start, end, allDay) {
                                var title = prompt('Event Title:');
                                if (title) {
                                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                                    $.ajax({
                                        url: SITEURL + "/get-harilibur-data",
                                        data: {
                                            title: ,
                                            start: start,
                                            end: end,
                                            type: 'add'
                                        },
                                        type: "POST",
                                        success: function (data) {
                                            displayMessage("Event Created Successfully");
          
                                            calendar.fullCalendar('renderEvent',
                                                {
                                                    id: data.id,
                                                    title: title,
                                                    start: start,
                                                    end: end,
                                                    allDay: allDay
                                                },true);
          
                                            calendar.fullCalendar('unselect');
                                        }
                                    });
                                }
                            },
         
                        });
         
        });
         
        function displayMessage(message) {
            toastr.success(message, 'Event');
        } 
          
    </script> --}}
    {{-- <script>
        $(document).ready(function() {
            // ajax request to get data from server
            $.ajax({
                url: '/get-harilibur-data', // change this url to your endpoint to retrieve data
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // initialize calendar
                    var calendar = $('#calendar').fullCalendar({
                        // options for fullcalendar plugin
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                        defaultView: 'month',
                        selectable: true,
                        selectHelper: true,
                        editable: true,
                        droppable: true,
                        dragRevertDuration: 0,
                        eventLimit: true, // allow "more" link when too many events
                        events: data, // set the events to the retrieved data
        
                        // other fullcalendar callbacks here
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // handle error here
                    console.log('Error:', errorThrown);
                }
            });
        });
    </script> --}}
        


@endsection