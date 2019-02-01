<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
    <title>{{ config('app.name') }}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    {{-- Bootstrap Material DateTime Picker --}}
    <link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
    <!-- Page plugins css -->
    <link href="{{asset('assets/plugins/clockpicker/dist/jquery-clockpicker.min.css')}}" rel="stylesheet">
    <!-- Color picker plugins css -->
    <link href="{{asset('assets/plugins/jquery-asColorPicker-master/dist/css/asColorPicker.css')}}" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="{{asset('assets/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    {{-- DataTables --}}
    <link href="{{asset('assets/plugins/datatables/media/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('material/css/style.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('material/css/colors/blue.css')}}" id="theme" rel="stylesheet">
    <!-- toast CSS -->
    <link href="{{asset('assets/plugins/toast-master/css/jquery.toast.css')}}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="../assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="../assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span>
                            <!-- dark Logo text -->
                            <img src="../assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo text -->
                            <img src="../assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
                        </span>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item">
                            <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)">
                                <i class="mdi mdi-menu"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)">
                                <i class="ti-menu"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        {{-- Top bar starts here --}}
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="ti-settings"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-text">
                                                <h4>Steave Jobs</h4>
                                                <p class="text-muted">varun@gmail.com</p>
                                                <a href="profile.html" class="btn btn-rounded btn-danger btn-sm">View Profile</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#">
                                            <i class="ti-user"></i> My Profile</a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="ti-wallet"></i> My Balance</a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="ti-email"></i> Inbox</a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#">
                                            <i class="ti-settings"></i> Account Setting</a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-power-off"></i> {{ __(' Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        {{-- top bar ends here --}}
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">

                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">Navigation</li>
                        <li><a href="{{route('admin.home')}}"><i class="mdi mdi-gauge"></i>Dashboard</a></li>

                        <li><a href="{{route('admin.sale.index')}}"><i class="mdi mdi-gauge"></i>Sales</a></li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-gauge"></i><span
                                    class="hide-menu">Employees </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('admin.employee.index')}}">Manage Employees</a></li>
                                <li><a href="{{route('admin.employee.trash')}}">Trashed Employees</a></li>
                            </ul>
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-gauge"></i><span
                                    class="hide-menu">Sale Types </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('admin.saletype.index')}}">Manage Sale Types</a></li>
                                <li><a href="{{route('admin.saletype.trash')}}">Trashed Sale Types</a></li>
                            </ul>
                        </li>

                    </ul>


                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
            <div class="sidebar-footer">
                <!-- item-->
                <a href="" class="link" data-toggle="tooltip" title="Settings">
                    <i class="ti-settings"></i>
                </a>
                <!-- item-->
                <a href="" class="link" data-toggle="tooltip" title="Email">
                    <i class="mdi mdi-gmail"></i>
                </a>
                <!-- item-->
                <a class="link" data-toggle="tooltip" title="Logout" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="mdi mdi-power"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            <!-- End Bottom points-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                    <h3 class="text-themecolor m-b-0 m-t-0">{{ $pageTitle }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.home')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0">
                                        <small>THIS MONTH</small>
                                    </h6>
                                    <h4 class="m-t-0 text-info">$58,356</h4>
                                </div>
                                <div class="spark-chart">
                                    <div id="monthchart"></div>
                                </div>
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0">
                                        <small>LAST MONTH</small>
                                    </h6>
                                    <h4 class="m-t-0 text-primary">$48,356</h4>
                                </div>
                                <div class="spark-chart">
                                    <div id="lastmonthchart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
<div class="row">
    <div class="col-sm-12">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <div class="col-sm-12">
        @if (session()->has('message'))
        <div class="alert alert-success">
            {{session('message')}}
        </div>
        @endif
    </div>
</div>

@yield('content')


            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                © 2019 {{ config('app.name')}} Developed By <a href="https://www.devpremier.com/">DevPremier</a>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('assets/plugins/popper/popper.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('material/js/jquery.slimscroll.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('material/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('material/js/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('material/js/custom.min.js')}}"></script>
    <script src="{{asset('assets/plugins/toast-master/js/jquery.toast.js')}}"></script>
    <script src="{{asset('material/js/toastr.js')}}"></script>

    <!-- This is data table -->
    <script src="{{asset('assets/plugins/datatables/datatables.min.js')}}"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->

    <!-- ============================================================== -->
    <!-- Plugins for this page -->
    <!-- ============================================================== -->
    <!-- Plugin JavaScript -->
    <script src="{{asset('assets/plugins/moment/moment.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
    <!-- Clock Plugin JavaScript -->
    <script src="{{asset('assets/plugins/clockpicker/dist/jquery-clockpicker.min.js')}}"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="{{asset('assets/plugins/jquery-asColor/dist/jquery-asColor.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-asGradient/dist/jquery-asGradient.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js')}}"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="{{asset('assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('assets/plugins/moment/moment.js')}}"></script>

    @yield('scripts')

    <script>
        // $('#myTable').DataTable({
        //     dom: 'Bfrtip',
        //     buttons: [
        //         'copy', 'csv', 'excel', 'pdf', 'print'
        //     ]
        // });
        $('#myTable').DataTable({
            "order": [[ 1, "desc" ]],
                    dom: '<"top"Bf>rt<"bottom"lip><"clear">',
        // dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50,100, -1 ],
            [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        ],

        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print','pageLength',
        ]

        });

    </script>

            <script>
                /*******************************************/
                // Basic Date Range Picker
                /*******************************************/
                $('.daterange').daterangepicker();

                /*******************************************/
                // Date & Time
                /*******************************************/
                $('.datetime').daterangepicker({
                    timePicker: true,
                    timePickerIncrement: 30,
                    locale: {
                        format: 'MM/DD/YYYY h:mm A'
                    }
                });

                /*******************************************/
                //Calendars are not linked
                /*******************************************/
                $('.timeseconds').daterangepicker({
                    timePicker: true,
                    timePickerIncrement: 30,
                    timePicker24Hour: true,
                    timePickerSeconds: true,
                    locale: {
                        format: 'MM-DD-YYYY h:mm:ss'
                    }
                });

                /*******************************************/
                // Single Date Range Picker
                /*******************************************/
                $('.singledate').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true
                });

                /*******************************************/
                // Auto Apply Date Range
                /*******************************************/
                $('.autoapply').daterangepicker({
                    autoApply: true,
                });

                /*******************************************/
                // Calendars are not linked
                /*******************************************/
                $('.linkedCalendars').daterangepicker({
                    linkedCalendars: false,
                });

                /*******************************************/
                // Date Limit
                /*******************************************/
                $('.dateLimit').daterangepicker({
                    dateLimit: {
                        days: 7
                    },
                });

                /*******************************************/
                // Show Dropdowns
                /*******************************************/
                $('.showdropdowns').daterangepicker({
                    showDropdowns: true,
                });

                /*******************************************/
                // Show Week Numbers
                /*******************************************/
                $('.showweeknumbers').daterangepicker({
                    showWeekNumbers: true,
                });

                /*******************************************/
                // Date Ranges
                /*******************************************/
                $('.dateranges').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                });

                /*******************************************/
                // Always Show Calendar on Ranges
                /*******************************************/
                $('.shawCalRanges').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    alwaysShowCalendars: true,
                });

                /*******************************************/
                // Top of the form-control open alignment
                /*******************************************/
                $('.drops').daterangepicker({
                    drops: "up" // up/down
                });

                /*******************************************/
                // Custom button options
                /*******************************************/
                $('.buttonClass').daterangepicker({
                    drops: "up",
                    buttonClasses: "btn",
                    applyClass: "btn-info",
                    cancelClass: "btn-danger"
                });

                /*******************************************/
                // Language
                /*******************************************/
                $('.localeRange').daterangepicker({
                    ranges: {
                        "Aujourd'hui": [moment(), moment()],
                        'Hier': [moment().subtract('days', 1), moment().subtract('days', 1)],
                        'Les 7 derniers jours': [moment().subtract('days', 6), moment()],
                        'Les 30 derniers jours': [moment().subtract('days', 29), moment()],
                        'Ce mois-ci': [moment().startOf('month'), moment().endOf('month')],
                        'le mois dernier': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                    },
                    locale: {
                        applyLabel: "Vers l'avant",
                        cancelLabel: 'Annulation',
                        startLabel: 'Date initiale',
                        endLabel: 'Date limite',
                        customRangeLabel: 'SÃ©lectionner une date',
                        // daysOfWeek: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi','Samedi'],
                        daysOfWeek: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
                        monthNames: ['Janvier', 'fÃ©vrier', 'Mars', 'Avril', 'ÐœÐ°i', 'Juin', 'Juillet', 'AoÃ»t', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
                        firstDay: 1
                    }
                });
            </script>
            <script>
                // MAterial Date picker
                $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
                $('#timepicker').bootstrapMaterialDatePicker({ format: 'HH:mm', time: true, date: false });
                $('#date-format').bootstrapMaterialDatePicker({ format: 'dddd DD MMMM YYYY - HH:mm' });

                $('#min-date').bootstrapMaterialDatePicker({ format: 'DD/MM/YYYY HH:mm', minDate: new Date() });
                // Clock pickers
                $('#single-input').clockpicker({
                    placement: 'bottom',
                    align: 'left',
                    autoclose: true,
                    'default': 'now'
                });
                $('.clockpicker').clockpicker({
                    donetext: 'Done',
                }).find('input').change(function () {
                    console.log(this.value);
                });
                $('#check-minutes').click(function (e) {
                    // Have to stop propagation here
                    e.stopPropagation();
                    input.clockpicker('show').clockpicker('toggleView', 'minutes');
                });
                if (/mobile/i.test(navigator.userAgent)) {
                    $('input').prop('readOnly', true);
                }
                // Colorpicker
                $(".colorpicker").asColorPicker();
                $(".complex-colorpicker").asColorPicker({
                    mode: 'complex'
                });
                $(".gradient-colorpicker").asColorPicker({
                    mode: 'gradient'
                });
                // Date Picker
                jQuery('.mydatepicker, #datepicker').datepicker();
                jQuery('#datepicker-autoclose').datepicker({
                    autoclose: true,
                    todayHighlight: true
                });
                jQuery('#date-range').datepicker({
                    toggleActive: true
                });
                jQuery('#datepicker-inline').datepicker({
                    todayHighlight: true
                });
                // Daterange picker
                $('.input-daterange-datepicker').daterangepicker({
                    buttonClasses: ['btn', 'btn-sm'],
                    applyClass: 'btn-danger',
                    cancelClass: 'btn-inverse'
                });
                $('.input-daterange-timepicker').daterangepicker({
                    timePicker: true,
                    format: 'MM/DD/YYYY h:mm A',
                    timePickerIncrement: 30,
                    timePicker12Hour: true,
                    timePickerSeconds: false,
                    buttonClasses: ['btn', 'btn-sm'],
                    applyClass: 'btn-danger',
                    cancelClass: 'btn-inverse'
                });
                $('.input-limit-datepicker').daterangepicker({
                    format: 'MM/DD/YYYY',
                    minDate: '06/01/2015',
                    maxDate: '06/30/2015',
                    buttonClasses: ['btn', 'btn-sm'],
                    applyClass: 'btn-danger',
                    cancelClass: 'btn-inverse',
                    dateLimit: {
                        days: 6
                    }
                });
            </script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="{{asset('assets/plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
</body>

</html>
