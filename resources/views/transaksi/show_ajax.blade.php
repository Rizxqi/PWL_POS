@empty($transaksi)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data transaksi tidak ditemukan.
                </div>
                <a href="{{ url('/transaksi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detail Transaksi Penjualan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info-circle"></i> Informasi Transaksi</h5>
                    Berikut adalah detail transaksi dan barang yang dibeli.
                </div>

                <table class="table table-sm table-bordered">
                    <tr>
                        <th class="text-right col-md-4">Kode Transaksi:</th>
                        <td>{{ $transaksi->penjualan_kode }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Tanggal Transaksi:</th>
                        <td>{{ \Carbon\Carbon::parse($transaksi->penjualan_tanggal)->format('d-m-Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Nama Pembeli:</th>
                        <td>{{ $transaksi->pembeli }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Nama Petugas:</th>
                        <td>{{ $transaksi->user->name ?? '-' }}</td>
                    </tr>
                </table>

                <h5 class="mt-4">Detail Barang</h5>
                <table class="table table-bordered table-sm table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($transaksi->detail as $index => $d)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $d->barang->barang_nama ?? '-' }}</td>
                                <td>Rp{{ number_format($d->harga, 0, ',', '.') }}</td>
                                <td>{{ $d->jumlah }}</td>
                                <td>Rp{{ number_format($d->harga * $d->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            @php $total += $d->harga * $d->jumlah; @endphp
                        @endforeach
                        <tr class="font-weight-bold bg-light">
                            <td colspan="4" class="text-right">Total</td>
                            <td>Rp{{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
@endempty
