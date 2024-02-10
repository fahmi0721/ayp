<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title') ANDI YULIANI PARIS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/main.css') }}">
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script type="text/javascript">
		    var tokenCSRF   = jQuery('meta[name="csrf-token"]').attr('content');
            var url_link    = "{{ asset('/') }}";
    </script>
  <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TVC2PGKJ');</script>
    <!-- End Google Tag Manager -->
</head>
<body class="hold-transition sidebar-mini text-sm">
  <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TVC2PGKJ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      @if(auth()->user()->level == "kabupaten")
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown" id='box-notif'>
        <a class="nav-link"  href="{{ url('kabupaten/suara/approve') }}">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"><span class='tot_notif'></span></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><span class='tot_notif'></span> Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="{{ url('kabupaten/suara/approve') }}" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> <span class='tot_notif'></span> new approval
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ url('kabupaten/suara/approve') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      @elseif(auth()->user()->level == "admin")
        <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown" id='box-notif'>
        <a class="nav-link"  href="{{ url('admin/suara/approve') }}">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"><span class='tot_notif'></span></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><span class='tot_notif'></span> Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="{{ url('admin/suara/approve') }}" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> <span class='tot_notif'></span> new approval
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ url('admin/suara/approve') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      @endif
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li> -->
      <li class="nav-item">
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
          <a class="nav-link" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" role="button" title='Keluar' data-toggle='tooltip' data-placement="top">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link bg-primary">
      <img src="{{ asset('dist/img/ayp.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3 " style="opacity: .8">
      <span class="brand-text font-weight-light">AYP-CENTER </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if(file_exists(auth()->user()->foto) && !empty(auth()->user()->foto))
          @php $fl = auth()->user()->foto; @endphp
          @else
          @php $fl = 'dist/img/user2-160x160.jpg' @endphp
          @endif
          <img src="{{ asset($fl) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->nama }} <br> <small>User {{ ucwords(auth()->user()->level) }}</small></a>
        </div>
      </div>
      @include("menu")
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @yield("bardcumb")
    @yield("konten")
    
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->

<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
 <!-- Histats.com  START  (aync)-->
  <!-- <script type="text/javascript">var _Hasync= _Hasync|| [];
  _Hasync.push(['Histats.start', '1,4832439,4,0,0,0,00010000']);
  _Hasync.push(['Histats.fasi', '1']);
  _Hasync.push(['Histats.track_hits', '']);
  (function() {
  var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
  hs.src = ('//s10.histats.com/js15_as.js');
  (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
  })();</script>
  <noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?4832439&101" alt="" border="0"></a></noscript> -->
  <!-- Histats.com  END  -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{ asset('dist/js/demo.js') }}"></script> -->
@yield("script")
<script>
  $("[data-toggle='tooltip']").tooltip({position:top});
  @if(auth()->user()->level == "kabupaten")
    load_notif();
  @elseif(auth()->user()->level == "admin")
    load_notif_admin();
  @endif

  function load_notif(){
    $.ajax({
      url : "{{ url('api/suara/get_notif') }}/{{ base64_encode(auth()->user()->id_kabupaten) }}",
      type : "GET",
      dataType: "json",
      data : "input=[]",
      success: function(res){
        $(".tot_notif").html(res.data.tot);
        if(parseInt(res.data.tot) > 0){
          $("#box-notif").show();
        }else{
          $("#box-notif").hide();

        }
      },
      error: function(er){
        console.log(res);
      }
    })
  }

  function load_notif_admin(){
    $.ajax({
      url : "{{ url('api/suara/get_notif_admin') }}",
      type : "GET",
      dataType: "json",
      data : "input=[]",
      success: function(res){
        $(".tot_notif").html(res.data.tot);
        if(parseInt(res.data.tot) > 0){
          $("#box-notif").show();
        }else{
          $("#box-notif").hide();

        }
      },
      error: function(er){
        console.log(res);
      }
    })
  }
</script>
</body>
</html>
