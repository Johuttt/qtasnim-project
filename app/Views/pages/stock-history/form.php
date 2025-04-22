<?= $this->extend('template/layout'); ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="col-lg-12 col-12" id="form6" style="width: 90%; padding-left: 7%;">
                <!-- Basic Forms -->
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Form Stock History</h4>
                    </div>
                    <!-- /.box-header -->
                    <form id="form1-content">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="barang_id" class="form-label">Barang</label>
                                        <select class="form-select" id="barang_id" name="barang_id" required>
                                            <option value="">Pilih Barang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="stock" class="form-label">Stock</label>
                                        <input type="number" class="form-control" id="stock" name="stock" min="0" value="0" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="aksi" class="form-label">Aksi</label>
                                        <select class="form-select" id="aksi" name="aksi" required>
                                            <option value="">Pilih Aksi</option>
                                            <option value="ditambah">Ditambah</option>
                                            <option value="dikurangi">Dikurangi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" id="submitBtn">Submit</button>
                        </div>
                        <!-- /.box-body -->
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </section>
    </div>
</div>

<!-- JavaScript Dependencies -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    // Isi dropdown barang
    $.ajax({
        url: '<?= base_url('/api/barang') ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var select = $('#barang_id');
            $.each(response, function(index, item) {
                select.append(`<option value="${item.id}">${item.nama_barang}</option>`);
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                title: 'Gagal!',
                text: 'Gagal memuat barang: ' + (xhr.responseJSON?.message || error),
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });

    // Handle submit
    $('#submitBtn').click(function (event) {
        // Validasi sisi klien
        var barangId = $('#barang_id').val();
        var stock = $('#stock').val();
        var aksi = $('#aksi').val();

        if (!barangId || !stock || !aksi) {
            Swal.fire({
                title: 'Error!',
                text: 'Barang, Stock, dan Aksi wajib diisi.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (stock < 0) {
            Swal.fire({
                title: 'Error!',
                text: 'Stock tidak boleh negatif.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Siapkan data untuk dikirim
        var data = {
            barang_id: barangId,
            stock: stock,
            aksi: aksi
        };

        // Tampilkan SweetAlert untuk konfirmasi
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data ini akan disimpan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim data melalui AJAX sebagai form data
                $.ajax({
                    url: '<?= base_url('/api/stock-history') ?>',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data riwayat stok berhasil disimpan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#form1-content')[0].reset();
                            window.location.href = '<?= base_url('/stock-history') ?>';
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal menyimpan data: ' + (xhr.responseJSON?.message || error),
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
});
</script>

<?= $this->endSection() ?>