@extends('layouts.default')
@section('content')
<!-- Header -->
<link href="assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet" />

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
            <div class="col-lg-2 col-md-2">

                <h4>Created Events</h4>
                <form method="post" id="add_event_form">
                    <input type="text" class="form-control new-event-form" placeholder="Add new event..." />
                </form>

                <div id='external-events'>
                    <h4 class="m-b-15">Draggable Events</h4>
                    {{-- <div class='fc-event'>My Event 1</div>
                    <div class='fc-event'>My Event 2</div>
                    <div class='fc-event'>My Event 3</div>
                    <div class='fc-event'>My Event 4</div>
                    <div class='fc-event'>My Event 5</div> --}}
                </div>
                <!-- checkbox -->
                <div class="checkbox checkbox-custom">
                    <input id="drop-remove" type="checkbox">
                    <label for="drop-remove">
                        Remove after drop
                    </label>
                </div>

            </div>

            <div id='calendar' class="col-md- col-lg-10"></div>

        </div>
    </div> <!-- container -->
</div> <!-- content -->


<!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>

    <!-- BEGIN PAGE SCRIPTS -->
    <!-- Jquery-Ui -->
    <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/plugins/moment/moment.js"></script>
    <script src='assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>
    <script src="assets/pages/calendar-init.js"></script>

    <script src="assets/js/app.js"></script>
@endsection