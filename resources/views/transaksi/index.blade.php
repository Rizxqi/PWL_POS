@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('transaksi/create') }}">Tambah</a>
                <button onclick="modalAction('{{ url('transaksi/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah
                    Ajax</button>
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
                <br>
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Total Transaksi</h3>
                            <p>New Orders</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter: </label>
                        <div class="col-3">
                            <select class="form-control" id="penjualan" name="penjualan" required>
                                <option value="">- Semua -</option>
                                @foreach ($penjualan as $item)
                                    <option value="{{ $item->penjualan_id }}">{{ $item->penjualan_tanggal }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Tanggal transaksi</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_transaksi">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal Transaksi</th>
                        <th>Kode Transaksi</th>
                        <th>Pembeli</th>
                        <th>Barang</th>
                        <th>QTY</th>
                        <th>Harga</th>
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
                $('#myModal').load(url, function() {
                    $('#myModal').modal('show');
                });
            }
            // var dataPenjualan;
            $(document).ready(function() {
                var dataPenjualan = $('#table_transaksi').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('transaksi/list') }}",
                        type: "POST",
                        data: function(d) {
                            d.penjualan = $('#penjualan').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            className: "text-center",
                            orderable: false,
                            searchable: false
                        }, // No
                        {
                            data: 'penjualan.penjualan_tanggal',
                            name: 'penjualan.penjualan_tanggal'
                        }, // Tanggal Transaksi
                        {
                            data: 'penjualan.penjualan_kode',
                            name: 'penjualan.penjualan_kode'
                        }, // Kode Transaksi
                        {
                            data: 'penjualan.pembeli',
                            name: 'penjualan.pembeli'
                        }, // Pembeli
                        {
                            data: 'barang.barang_nama',
                            name: 'barang.barang_nama'
                        }, // Nama Barang
                        {
                            data: 'jumlah',
                            name: 'jumlah'
                        }, // QTY
                        {
                            data: 'harga',
                            name: 'harga'
                        }, // Harga
                        {
                            data: 'aksi',
                            name: 'aksi',
                            orderable: false,
                            searchable: false
                        } // Action
                    ]
                });

                $('#penjualan').change(function() {
                    dataPenjualan.ajax.reload(); // Reload table kalau filter berubah
                });
            });
        </script>
    @endpush
