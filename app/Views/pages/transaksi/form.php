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
                        <h4 class="box-title" id="form-title">Form Transaksi</h4>
                    </div>
                    <!-- /.box-header -->
                    <form id="form1-content">
                        <input type="hidden" id="id" name="id">
                        <div class="box-body">
                            <div class="row" id="form-row">
                                <div class="col-md-6" id="barang-col">
                                    <div class="form-group">
                                        <label for="barang_id" class="form-label">Barang</label>
                                        <select class="form-select" id="barang_id" name="barang_id" required>
                                            <option value="">Pilih Barang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="jumlah-terjual-col">
                                    <div class="form-group">
                                        <label for="jumlah_terjual" class="form-label">Jumlah Terjual</label>
                                        <input type="number" class="form-control" id="jumlah_terjual" name="jumlah_terjual" min="1" value="1" required>
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

    // Deteksi mode berdasarkan URL
    var currentUrl = window.location.href;
    var isEdit = currentUrl.includes('/edit/');
    var id = isEdit ? currentUrl.split('/edit/')[1] : null;

    // Sesuaikan form berdasarkan mode
    if (isEdit && id) {
        $('#form-title').text('Edit Transaksi');
        $('#id').val(id);

        // Ambil data transaksi
        $.ajax({
            url: '<?= base_url('/api/transaksi') ?>/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#barang_id').val(response.barang_id);
                $('#jumlah_terjual').val(response.jumlah_terjual);
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal memuat data: ' + (xhr.responseJSON?.message || error),
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '<?= base_url('/transaksi') ?>';
                });
            }
        });
    } else {
        $('#form-title').text('Tambah Transaksi');
    }

    // Handle submit
    $('#submitBtn').click(function (event) {
        // Validasi sisi klien
        var barangId = $('#barang_id').val();
        var jumlahTerjual = $('#jumlah_terjual').val();

        if (!barangId || !jumlahTerjual) {
            Swal.fire({
                title: 'Error!',
                text: 'Barang dan Jumlah Terjual wajib diisi.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (jumlahTerjual < 1) {
            Swal.fire({
                title: 'Error!',
                text: 'Jumlah Terjual harus berupa angka positif.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Tentukan mode (create atau edit)
        var url = isEdit ? '<?= base_url('/api/transaksi') ?>/' + id : '<?= base_url('/api/transaksi') ?>';
        var method = 'POST';
        var actionText = isEdit ? 'diperbarui' : 'disimpan';
        var confirmText = isEdit ? 'update' : 'simpan';

        // Siapkan data untuk dikirim
        var data = {
            barang_id: barangId,
            jumlah_terjual: jumlahTerjual
        };
        if (isEdit) {
            data._method = 'PUT';
        }

        // Tampilkan SweetAlert untuk konfirmasi
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Data transaksi akan ${actionText}!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Ya, ${confirmText}!`,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim data melalui AJAX sebagai form data
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: `Data transaksi berhasil ${actionText}.`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#form1-content')[0].reset();
                            window.location.href = '<?= base_url('/transaksi') ?>';
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: `Gagal ${actionText} data: ` + (xhr.responseJSON?.message || error),
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