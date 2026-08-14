<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('appp.name', 'PWL Laravel Strater Code') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Untuk mengirimkan token Laravel CSRF pada setiap request ajax -->
    <!-- Google Fonts: Nunito Sans & Rubik -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    {{-- DataTables --}}
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Sweet Alert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    @stack('css')<!-- Digunakan memanggil css dari perintah push('css') pada masing-masing view-->
    <style>
        :root {
            --primary: #0891B2;
            --secondary: #22D3EE;
            --cta: #22C55E;
            --bg-color: #ECFEFF;
            --text-color: #164E63;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        body {
            font-family: 'Nunito Sans', sans-serif;
            color: var(--text-color);
            background-color: var(--bg-color);
        }
        
        h1, h2, h3, h4, h5, h6, .brand-text {
            font-family: 'Rubik', sans-serif;
            font-weight: 600;
        }

        /* Override AdminLTE styles */
        .content-wrapper {
            background-color: var(--bg-color);
        }
        
        .main-header {
            background-color: #ffffff;
            border-bottom: 1px solid rgba(8, 145, 178, 0.1);
        }

        .main-sidebar {
            background-color: var(--text-color) !important;
        }
        
        .brand-link {
            border-bottom: 1px solid rgba(255,255,255,0.1) !important;
        }

        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: var(--primary);
            color: #ffffff;
            border-radius: 8px;
        }
        
        .nav-sidebar .nav-link {
            border-radius: 8px;
            margin-bottom: 4px;
            transition: all 0.3s ease;
        }

        .nav-sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: #ffffff;
        }

        /* Custom Cards */
        .card {
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(8, 145, 178, 0.1);
            padding: 1.25rem 1.5rem;
        }

        .small-box {
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease;
            color: #ffffff !important;
        }
        
        .small-box:hover {
            transform: translateY(-5px);
        }

        .small-box .icon {
            color: rgba(255,255,255,0.3);
            font-size: 80px;
            top: -15px;
            right: 15px;
        }

        .bg-primary-custom { background-color: var(--primary) !important; }
        .bg-secondary-custom { background-color: var(--secondary) !important; color: var(--text-color) !important; }
        .bg-cta-custom { background-color: var(--cta) !important; }
        .bg-warning-custom { background-color: #F59E0B !important; }

        .small-box-footer {
            background-color: rgba(0,0,0,0.15) !important;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 6px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #06b6d4;
            border-color: #06b6d4;
        }
        
        .btn-success {
            background-color: var(--cta);
            border-color: var(--cta);
            border-radius: 6px;
            font-weight: 600;
        }

        /* DataTables Customization */
        .table {
            color: var(--text-color);
        }
        .table thead th {
            border-bottom: 2px solid rgba(8, 145, 178, 0.2);
            color: var(--primary);
            font-family: 'Rubik', sans-serif;
            font-weight: 500;
        }
        table.dataTable tbody tr {
            background-color: transparent;
        }
        table.dataTable.stripe tbody tr.odd, table.dataTable.display tbody tr.odd {
            background-color: rgba(236, 254, 255, 0.5);
        }
        table.dataTable.hover tbody tr:hover, table.dataTable.display tbody tr:hover {
            background-color: rgba(34, 211, 238, 0.1);
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

        <!-- Navbar -->
        @include('layouts.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">PWL - Strater Code</span>
            </a>

            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @include('layouts.breadcrumb')

            <!-- Main content -->
            @yield('content')
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        @include('layouts.footer')
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables & Plugin -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{asset ('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('js')<!-- Digunakan umtuk memanggil custom js dari perintah push('js') pada masing-masing view -->
</body>

</html>
