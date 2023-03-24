
/**
* Theme: Xadmino
* Full calendar page
*/

!function($) {
    "use strict";

    var CalendarPage = function() {};

    CalendarPage.prototype.init = function() {

        //checking if plugin is available
        if ($.isFunction($.fn.fullCalendar)) {
            /* initialize the external events */
            $('#external-events .fc-event').each(function() {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                };

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject);

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });

            });
            
            /* initialize the calendar */

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                droppable: true, // this allows things to be dropped onto the calendar !!!
                navLinks: true,
                drop: function(date, allDay) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');

                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }

                },
                events: { //menampilkan data harilibur ke dalam fullcalendar
                    url: '/get-harilibur-data',
                    type: 'GET',
                    success: function(data) {
                        // console.log(data);
                        var events = [];
                    
                        for (var i = 0; i < data.events.length; i++) {

                            var backgroundColor = '';

                            if (data.events[i].type === 'Hari Libur Nasional') {
                                backgroundColor = 'red';
                            } else if (data.events[i].type === 'Cuti Bersama') {
                                backgroundColor = 'orange';
                            }

                            var event = {
                                id : data.events[1].id,
                                title: data.events[i].title,
                                start: new Date(data.events[i].start),
                                end: new Date(data.events[i].end),
                                type: data.events[i].type,
                                user: data.events[i].user,
                                backgroundColor: backgroundColor
                            };
                    
                            events.push(event);
                        }
                        // hapus sumber event sebelumnya
                        $('#calendar').fullCalendar('removeEventSources');

                        // tambahkan event baru
                        $('#calendar').fullCalendar('addEventSource', events);
                    }
                },
                // eventClick: function(calEvent, jsEvent, view) {
                //     if (calEvent.user == id_pegawai) {
                //         $('#edit-modal').modal();
                //         $('#edit-modal #id').val(calEvent.id);
                //         $('#edit-modal #judul').val(calEvent.title);
                //         $('#edit-modal #deskripsi').val(calEvent.description);
                //         $('#edit-modal #start').val(moment(calEvent.start).format('YYYY-MM-DD HH:mm:ss'));
                //         if (calEvent.end != null) {
                //             $('#edit-modal #end').val(moment(calEvent.end).format('YYYY-MM-DD HH:mm:ss'));
                //         }
                //     }
                // }
                
                // eventClick: function(calEvent, jsEvent, view) {
                //     if (calEvent.editable) { // cek apakah event dapat dihapus
                //         console.log(calEvent.editable);
                //         if (calEvent.user == id_pegawai) { // tambahkan kondisi untuk membandingkan id_pegawai
                //             if (confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')) {
                //                 $.ajax({
                //                     url: '/delete-kegiatan/' + calEvent.id,
                //                     type: 'DELETE',
                //                     success: function() {
                //                         $('#calendar').fullCalendar('removeEvents', calEvent.id);
                //                     },
                //                     error: function() {
                //                         alert('Gagal menghapus kegiatan.');
                //                     }
                //                 });
                //             }
                //         } else {
                //             alert('Anda tidak diizinkan menghapus kegiatan ini.');
                //         }
                //     }
                // }

            });
            
            /*Add new event*/
            // Form to add new event
            // $(document).on('submit', '#add_event_form', function(event){
            //     event.preventDefault();
            
            //     // mengambil data dari form
            //     var formData = {
            //         'judul' : $('input[name=judul]').val(),
            //         'tglmulai' : $('input[name=tglmulai]').val(),
            //         'tglselesai' : $('input[name=tglselesai]').val(),
            //         'id_pegawai' : $('input[name=id_pegawai]').val()
            //     };
            
            //     // mengirim data ke server
            //     $.ajax({
            //         type : 'POST',
            //         url : '/store-kegiatan',
            //         data : formData,
            //         dataType : 'json',
            //         encode : true
            //     })
            //     .done(function(data) {
            //         console.log(data);
            //     });
            // });
            

        }
        else {
            alert("Calendar plugin is not installed");
        }
    },
    //init
    $.CalendarPage = new CalendarPage, $.CalendarPage.Constructor = CalendarPage
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.CalendarPage.init()
}(window.jQuery);


