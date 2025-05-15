<form action="{{ url('/transaksi/ajax') }}" method="POST" id="form-penjualan">
    @csrf
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaksi Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="user_id" value="{{ 1 }}">
                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <input type="text" name="penjualan_kode" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Nama Pembeli</label>
                    <input type="text" name="pembeli" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input type="datetime-local" name="penjualan_tanggal" class="form-control"
                        value="{{ now()->format('Y-m-d\TH:i') }}" required>
                </div>

                <hr>
                <h6>Detail Barang</h6>
                <table class="table table-bordered" id="barang-table">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th><button type="button" class="btn btn-sm btn-success" id="addRow">+</button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="barang_id[]" class="form-control" required>
                                    <option value="">- Pilih -</option>
                                    @foreach ($barang as $b)
                                        <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="harga[]" class="form-control" required></td>
                            <td><input type="number" name="jumlah[]" class="form-control" required></td>
                            <td><button type="button" class="btn btn-sm btn-danger removeRow">x</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        // Tambah baris barang
        $('#addRow').click(function() {
            let row = `<tr>
                <td>
                    <select name="barang_id[]" class="form-control" required>
                        <option value="">- Pilih -</option>
                        @foreach ($barang as $b)
                            <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="harga[]" class="form-control" required></td>
                <td><input type="number" name="jumlah[]" class="form-control" required></td>
                <td><button type="button" class="btn btn-sm btn-danger removeRow">x</button></td>
            </tr>`;
            $('#barang-table tbody').append(row);
        });

        // Hapus baris
        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
        });

        // AJAX Submit
        $('#form-penjualan').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function(res) {
                    if (res.status) {
                        $('#form-penjualan')[0].reset();
                        $('#myModal').modal('hide');
                        Swal.fire('Berhasil', res.message, 'success');
                        // reload datatable if needed
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire('Error', 'Terjadi kesalahan server', 'error');
                }
            });
        });
    });
</script>
