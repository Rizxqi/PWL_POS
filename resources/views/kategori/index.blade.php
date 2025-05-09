@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
                    data-keyboard="false" data-width="75%" aria-hidden="true"></div>
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('kategori/create') }}">Tambah</a>
                <button onclick="modalAction('{{ url('kategori/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah
                    Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <h5><i class="icon fas fa-check"></i> Berhasil</h5>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan</h5>
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">kategori</label>
                        <div class="col-3">
                            <select class="form-control" id="kategori_id" name="kategori_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Filter berdasarkan kategori</small>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-hover table-sm" id="table_kategori">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Kategori</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataKategori;
        $(document).ready(function() {
            dataKategori = $('#table_kategori').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('kategori/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.kategori_id = $('#kategori_id').val();
                        d._token = "{{ csrf_token() }}"; // kirim token CSRF untuk keamanan
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "kategori_kode",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "kategori_nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "action",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#kategori_id').change(function() {
                dataKategori.ajax.reload();
            });
        });
    </script>
@endpush
