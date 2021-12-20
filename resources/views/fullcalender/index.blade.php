<!DOCTYPE html>
<html>
<head>
    <title>Laravel Fullcalender</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <link rel="stylesheet" href="{{asset('public/assets/css/bootstrap.min.css')}}" />
    <script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('public/assets/css/fullcalendar.css')}}"/>
    <script src="{{asset('public/assets/js/moment.min.js')}}"></script>
    <script src="{{asset('public/assets/js/fullcalendar.js')}}"></script>
    <script src="{{asset('public/assets/js/toastr.min.js')}}"></script>
    <script src="{{asset('public/assets/js/bootstrap.min.js')}}" /></script>
    <link rel="stylesheet" href="{{asset('public/assets/css/toastr.min.css')}}" />

    <!-- Bootstrap DatePicker -->
    <link rel="stylesheet" href="{{asset('public/assets/css/bootstrap-datepicker.css')}}" type="text/css" />
    <script src="{{asset('public/assets/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <!-- Bootstrap DatePicker -->
    <style type="text/css">
     body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            height: 100vh;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        .fc-content {
                padding: 5px;
                color: #000;
                font-size: 16px;
                font-weight: bold;
                box-shadow: rgb(0 0 0 / 35%) 0px 5px 15px;
                /* box-shadow: rgb(0 0 0 / 24%) 0px 3px 8px; */
                border: 1px solid #fff;
                text-align: center;
            }
        .fc-day-top.fc-other-month {
            opacity: 0.4;
            font-weight: bold;
        }
        .fc-content-skeleton td, .fc .fc-row .fc-helper-skeleton td {
            font-weight: bold;
            border-color: #02020247;
        }

    </style>
</head>
<body>
  
<div class="container">
    <h1 class="text-center border border-secondary rounded">Laravel FullCalender</h1>
    <hr>
    <div id='calendar'></div>
</div>

<!-- add event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEventModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="addEventForm">
          <div class="modal-body">
                <div class="form-group">
                    <label>Event Title *</label>
                    <input type="text" id="addEvent_title" class="form-control" placeholder="Event Title">
                </div>
                <div class="form-group">
                    <label>Event Background Color *</label>
                    <select id="addEvent_colorCode" class="form-control">
                        <option value="#FBEF03">yellow</option>
                        <option value="#A9FB03">green</option>
                        <option value="#FB7F03">red</option>
                    </select>
                </div>
                <input type="hidden" id="addEvent_start">
                <input type="hidden" id="addEvent_end">
                <input type="hidden" id="addEvent_allDay">
          </div>
          <div class="modal-footer">
            <button type="submit" class="form-control btn btn-success">Add Event</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
    </div>
  </div>
</div>

<!-- end add event Modal -->

<!-- update event Modal -->
<div class="modal fade" id="updateEventModal" tabindex="-1" role="dialog" aria-labelledby="updateEventModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateEventModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form id="updateEventForm">
          <div class="modal-body">
                <div class="form-group">
                    <label>Event Title *</label>
                    <input type="text" id="updateEvent_title" class="form-control" placeholder="Event Title">
                </div>
                <div class="form-group">
                    <label>Event Background Color *</label>
                    <select id="updateEvent_colorCode" class="form-control">
                        <option value="#FBEF03">yellow</option>
                        <option value="#A9FB03">green</option>
                        <option value="#FB7F03">red</option>
                    </select>
                </div>
                <input type="hidden" id="updateEvent_id">
                <input type="hidden" id="updateEvent_start">
                <input type="hidden" id="updateEvent_end">
                <input type="hidden" id="updateEvent_allDay">
          </div>
          <div class="modal-footer">
            <button type="button" onclick="deleteEventForm()" class="form-control btn btn-danger">Delete Event</button>
            <button type="submit"  class="form-control btn btn-success">Update Event</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

          </div>
        </form>
    </div>
  </div>
</div>
<!-- update event modal end -->
   
<script>
    var addEvent_allDay=updateEvent_allDay='';
$(document).ready(function () {
  
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  
    var calendar = $('#calendar').fullCalendar({
                    editable: true,
                    events: "{!! route('fullcalender.index'); !!}",
                    displayEventTime: false,
                    editable: true,
                    header: {
                        left: 'prev,next today datepickerButton',
                        center: 'title, gotoDate',
                        right: 'month,basicWeek,basicDay'
                      },
                        customButtons: {
                            gotoDate: {
                                text: 'Go to date',
                                click: function () {
                                    $(this).datepicker({
                                        autoclose: true,
                                        dateFormat: 'yyyy-mm-dd'
                                    });
                                    $(this).datepicker().on('changeDate', function (e) {
                                        $('#calendar').fullCalendar('gotoDate', e.date);
                                    });
                                    $(this).datepicker('show');
                                }
                            },
                        },
                      navLinks: true,
                      editable: true,
      // eventLimit: true
                    eventRender: function (event, element, view) {
                        if (event.allDay === 'true') {
                                event.allDay = true;
                        } else {
                                event.allDay = false;
                        }
                        // console.log(event);
                        if(event.colorCode){
                            element.css("background-color", event.colorCode);
                        }else{
                            element.css("background-color", "#77DD77");
                        }
                    },
                    selectable: true,
                    selectHelper: true,
                    select: function (start, end, allDay) {
                        var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                        var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                        $("#addEventForm input:hidden").val(null);
                        $('#addEventForm').trigger("reset");
                        $('#addEvent_start').val(start);
                        $('#addEvent_end').val(end);
                        $('#addEvent_allDay').val(allDay);
                        addEvent_allDay = allDay;
                        $('#addEventModal').modal('show');
                    },
                    eventDrop: function (event, delta) {
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
  
                        $.ajax({
                            url: "{!! route('fullcalender.index'); !!}/"+ event.id,
                            data: {
                                title: event.title,
                                start: start,
                                end: end,
                                // _method: 'PUT'
                            },
                            type: "PUT",
                            success: function (response) {
                                // alert(response);
                                toastr.success("Event Updated Successfully", 'Event');
                            }
                        });
                    },
                    eventClick: function (event) {
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                        $("#updateEventForm input:hidden").val(null);
                        $('#updateEventForm').trigger("reset");
                        $('#updateEvent_start').val(start);
                        $('#updateEvent_end').val(end);
                        $('#updateEvent_allDay').val(event.allDay);
                        $('#updateEvent_title').val(event.title);
                        $('#updateEvent_colorCode').val(event.colorCode);
                        $('#updateEvent_id').val(event.id);
                        updateEvent_allDay = event.allDay;
                        $('#updateEventModal').modal('show'); 
                    }
 
                });

    // for add event
    $('#addEventForm').on('submit', function(e){
        e.preventDefault();
        // console.log($('#addEvent_start').val());
        // console.log($('#addEvent_end').val());
        // console.log($('#addEvent_allDay').val());
        // console.log($('#addEvent_title').val());
        // console.log($('#addEvent_colorCode').val());
            var addEvent_start = $('#addEvent_start').val();
            var addEvent_end = $('#addEvent_end').val();
            var addEvent_title = $('#addEvent_title').val();
            var addEvent_colorCode = $('#addEvent_colorCode').val();

        if (addEvent_start && addEvent_end && addEvent_title) {
            $.ajax({
                url: "{!! route('fullcalender.store'); !!}",
                data: {
                    title: addEvent_title,
                    start: addEvent_start,
                    end: addEvent_end,
                    colorCode: addEvent_colorCode
                },
                type: "POST",
                success: function (data) {
                    toastr.success("Event Created Successfully", 'Event');
                    $('#calendar').fullCalendar('renderEvent',
                        {
                            id: data.id,
                            title: addEvent_title,
                            start: addEvent_start,
                            end: addEvent_end,
                            colorCode: addEvent_colorCode,
                            allDay: addEvent_allDay
                        },true);

                    $('#addEventModal').modal('hide');
                    $('#calendar').fullCalendar('unselect');
                }
            });
        }

    });
    // add form end

// for update event
    $('#updateEventForm').on('submit', function(e){
        e.preventDefault();
            var updateEvent_id = $('#updateEvent_id').val();
            var updateEvent_start = $('#updateEvent_start').val();
            var updateEvent_end = $('#updateEvent_end').val();
            var updateEvent_title = $('#updateEvent_title').val();
            var updateEvent_colorCode = $('#updateEvent_colorCode').val();

        if (updateEvent_start && updateEvent_end && updateEvent_title) {
            $.ajax({
                url: "{!! route('fullcalender.index'); !!}/"+ updateEvent_id,
                data: {
                    title: updateEvent_title,
                    colorCode: updateEvent_colorCode
                },
                type: "PUT",
                success: function (data) {
                    toastr.success("Event Created Successfully", 'Event');
                    $('#calendar').fullCalendar('removeEvents', updateEvent_id);
                    $('#calendar').fullCalendar('renderEvent',
                        {
                            id: updateEvent_id,
                            title: updateEvent_title,
                            start: updateEvent_start,
                            end: updateEvent_end,
                            colorCode: updateEvent_colorCode,
                            allDay: updateEvent_allDay
                        },true);

                    $('#updateEventModal').modal('hide');
                    $('#calendar').fullCalendar('unselect');
                }
            });
        }

    });
    // update form end

    });
    // for delete event
    function deleteEventForm(){
        var deleteEvent_id = $('#updateEvent_id').val();
        var deleteMsg = confirm("Do you really want to delete?");
        $('#updateEventModal').modal('hide');
        if (deleteMsg && deleteEvent_id) {
            $.ajax({
                type: "DELETE",
                url: "{!! route('fullcalender.index'); !!}/"+ deleteEvent_id,
                data: {},
                success: function (response) {
                // alert(response);
                    $('#calendar').fullCalendar('removeEvents', deleteEvent_id);
                    toastr.success("Event Deleted Successfully", 'Event');
                }
            });
        }
    }
 
  
</script>
  
</body>
</html>