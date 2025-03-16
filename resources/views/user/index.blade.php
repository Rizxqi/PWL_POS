@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('user/create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>User Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            var dataUser = $('#table_user').DataTable({
                processing: true, // Menampilkan indikator loading saat data diambil
                serverSide: true, // Menggunakan server-side processing
                ajax: {
                    url: "{{ url('user/list') }}", // URL untuk mengambil data
                    type: "POST",
                    dataType: "json"
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "username",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "level.level_nama", // Mengambil data level dari relasi ORM
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "action",
                        orderable: false,
                        searchable: false
                    }
                ],
                columnDefs: [{
                        targets: [0, 4],
                        className: "text-center"
                    } // Memusatkan teks pada kolom No & Aksi
                ]
            });
        });
    </script>
@endpush
