@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('stok/create') }}">Tambah</a>
                <button onclick="modalAction('{{ url('stok/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter: </label>
                        <div class="col-3">
                            <select class="form-control" id="barang_id" name="barang_id" required>
                                <option value="">- Semua -</option>
                                @foreach($barang as $item)
                                    <option value="{{ $item->barang_id }}">{{ $item->barang_kode }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Barang</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>nama barang</th>
                        <th>stok tanggal</th>
                        <th>stok jumlah</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

    @push('css')
    @endpush

    @push('js')
        <script>
            function modalAction(url = '') {
                $('#myModal').load(url, function () {
                    $('#myModal').modal('show');
                });
            }
            var dataStok;
            $(document).ready(function () {
                dataStok = $('#table_stok').DataTable({
                    // serverSide: true, jika ingin menggunakan server side processing 
                    serverSide: true,
                    ajax: {
                        "url": "{{ url('stok/list') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function (d) {
                            d.barang_id = $('#barang_id').val();
                        }
                    },
                    columns: [
                        {  // nomor urut dari laravel datatable addIndexColumn() 
                            data: "DT_RowIndex",
                            className: "text-center",
                            orderable: false,
                            searchable: false
                        }, {
                            data: "barang.barang_nama",
                            className: "",
                            // orderable: true, jika ingin kolom ini bisa diurutkan  
                            orderable: true,
                            // searchable: true, jika ingin kolom ini bisa dicari 
                            searchable: true
                        }, {
                            data: "stok_tanggal",
                            className: "",
                            // orderable: true, jika ingin kolom ini bisa diurutkan  
                            orderable: true,
                            // searchable: true, jika ingin kolom ini bisa dicari 
                            searchable: true
                        }, {
                            data: "stok_jumlah",
                            className: "",
                            orderable: true,
                            searchable: true
                        }, {
                            data: "action",
                            className: "",
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
                $('#barang_id').on('change', function () {
                    dataStok.ajax.reload();
                });
            }); 
        </script>
    @endpush