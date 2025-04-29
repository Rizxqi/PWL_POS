<form action="{{ url('/transaksi/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Stok Tanggal</label>
                    <input type="datetime-local" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control"
                        value="{{ now()->format('Y-m-d\TH:i') }}" required>
                    <small id="error-penjualan_tangal" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <select name="barang_id" id="barang_id" class="form-control" required>
                        <option value="">- Pilih Barang -</option>
                        @foreach ($barang as $b)
                            <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-barang_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Stok Jumlah</label>
                    <input type="number" name="stok_jumlah" id="stok_jumlah" class="form-control" required>
                    <small id="error-stok_jumlah" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Auto fill stok_jumlah when barang is selected
        $('#barang_id').change(function() {
            var barangId = $(this).val();
            if (barangId) {
                $.ajax({
                    url: '{{ url('stok/get_current_stock') }}',
                    type: 'GET',
                    data: {
                        barang_id: barangId
                    },
                    success: function(response) {
                        if (response.status) {
                            $('#stok_jumlah').val(response.current_stock);
                        } else {
                            $('#stok_jumlah').val('');
                        }
                    },
                    error: function() {
                        $('#stok_jumlah').val('');
                    }
                });
            } else {
                $('#stok_jumlah').val('');
            }
        });

        $("#form-tambah").validate({
            rules: {
                barang_id: {
                    required: true,
                    number: true
                },
                stok_tanggal: {
                    required: true
                },
                stok_jumlah: {
                    required: true,
                    number: true,
                    min: 0
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataStok.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menyimpan data. Silakan coba lagi.'
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
