<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Laman Utama</title>

    <!-- Bootstrap -->

    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet"> {{--Mengelakkan masalah semasa penukaran sistem ke server berlainan --}}
    <link href="{{URL::asset('css/style.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('css/chosen.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/pace-theme-center-circle.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/jqClock.css') }}" rel="stylesheet">

    <script>
        var base_url = '{{ url('/') }}';
    </script>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-inverse  navbar-fixed-top" >
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <span class="glyphicon glyphicon glyphicon-home" aria-hidden="true"></span>
                Aduan ICT
            </a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">

                    @role('admin')
                        <li>
                            <a href="{{ route('admin.users.index') }}">Panel Admin</a>
                        </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Laporan<span class="caret"></span>
                        </a>

                    </li>
                    @endrole
                    @role('unit_manager')
                    <li>
                        <a href="{{ route('complain.assign') }}">Senarai Agihan</a>
                    </li>
                    @endrole
                    @permission('report_menu')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                           Laporan<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @permission('statistic_chart')
                            <li><a href="{{ route('reports.monthly_statistic_aduan') }}"><i class="fa fa-btn fa-sign-out"></i>Graf bulanan</a></li>
                            @endpermission
                            @permission('statistic_table')
                            <li><a href="{{ route('reports.monthly_statistic_table_aduan') }}"><i class="fa fa-btn fa-sign-out"></i>Bulanan</a></li>
                            @endpermission
                        </ul>
                    </li>
                    @endpermission
                    <li>
                        <a href="{{ route('complain.create') }}">Tambah Aduan</a>
                    </li>
                    <li>
                        <a href="{{ route('complain.index') }}">
                            Senarai Aduan
                        </a>
                    </li>
                    <li class="dropdown">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>

                    @endif
                            <span class="caret">
                            </span>
                        <ul class="dropdown-menu">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="profile.html">Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{url('/logout')}}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
        </div>

    </div><!-- /.container-fluid -->
</nav>
<div class="container">
    @include('flash::message')
    @yield('filter')
   @yield('content')
</div>
    @yield('modal')


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
<script src="{{URL::asset('js/chosen.jquery.min.js')}}"></script>
<script src="{{URL::asset('js/sweetalert.min.js')}}"></script>
<script src="{{URL::asset('js/Chart.min.js')}}"></script>
<script src="{{URL::asset('js/datepicker.min.js')}}"></script>
<script src="{{URL::asset('js/ajax_helpers.js')}}"></script>
<script src="{{URL::asset('js/pace.min.js')}}"></script>
<script src="{{URL::asset('js/jqClock.min.js')}}"></script>

</body>
</html>
<script type="text/javascript">
    $( document ).ready(function() {
        $(".chosen").chosen();

    $('.datepicker').datepicker(
        {
            format: 'dd-mm-yyyy',
        }
    );
        setInterval(function() {
            check_session();
        }, 5000);

        function check_session()
        {
            $.ajax({
                type: "GET",
                url: base_url + '/check_session',
                dataType: "json",

                beforeSend: function () {

                },
                success: function (check_data) {
                    if(!check_data.logged_in)
                    {
                        swal({
                                    title: "Sesi Anda telah tamat",
                                    text: "Sila klik Login",
                                    type: "error",
                                    showCancelButton: false,
                                    confirmButtonClass: "btn-danger",
                                    confirmButtonText: "Login",
                                    closeOnConfirm: false
                                },
                                function(isConfirm) {
                                    
                                        location.reload();
                                });

                    }
                }
            });
        }

    });

</script>
@yield('script')