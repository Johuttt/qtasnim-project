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
                        <h4 class="box-title" id="form-title">Form Barang</h4>
                    </div>
                    <!-- /.box-header -->
                    <form id="form1-content">
                        <input type="hidden" id="id" name="id">
                        <div class="box-body">
                            <div class="row" id="form-row">
                                <div class="col-md-6" id="nama-barang-col">
                                    <div class="form-group">
                                        <label for="nama_barang" class="form-label">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                                    </div>
                                </div>
                                <div class="col-md-6" id="jenis-barang-col">
                                    <div class="form-group">
                                        <label for="jenis_barang_id" class="form-label">Jenis Barang</label>
                                        <select class="form-select" id="jenis_barang_id" name="jenis_barang_id" required>
                                            <option value="">Pilih Jenis Barang</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Input stock akan ditambahkan secara dinamis untuk mode create -->
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
    // Isi dropdown jenis barang
    $.ajax({
        url: '<?= base_url('/api/jenis-barang') ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var select = $('#jenis_barang_id');
            $.each(response, function(index, item) {
                select.append(`<option value="${item.id}">${item.nama_jenis_barang}</option>`);
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                title: 'Gagal!',
                text: 'Gagal memuat jenis barang: ' + (xhr.responseJSON?.message || error),
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
        $('#form-title').text('Edit Barang');
        $('#id').val(id);
        // Gunakan col-md-6 untuk dua input
        $('#nama-barang-col').removeClass('col-md-4').addClass('col-md-6');
        $('#jenis-barang-col').removeClass('col-md-4').addClass('col-md-6');

        // Ambil data barang
        $.ajax({
            url: '<?= base_url('/api/barang') ?>/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#nama_barang').val(response.nama_barang);
                $('#jenis_barang_id').val(response.jenis_barang_id);
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal memuat data: ' + (xhr.responseJSON?.message || error),
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '<?= base_url('/barang') ?>';
                });
            }
        });
    } else {
        $('#form-title').text('Tambah Barang');
        // Tambahkan input stock untuk mode create
        $('#form-row').append(`
            <div class="col-md-4" id="stock-col">
                <div class="form-group">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" min="0" value="0" required>
                </div>
            </div>
        `);
        // Gunakan col-md-4 untuk tiga input
        $('#nama-barang-col').removeClass('col-md-6').addClass('col-md-4');
        $('#jenis-barang-col').removeClass('col-md-6').addClass('col-md-4');
    }

    // Handle submit
    $('#submitBtn').click(function (event) {
        // Validasi sisi klien
        var namaBarang = $('#nama_barang').val().trim();
        var jenisBarangId = $('#jenis_barang_id').val();
        var stock = isEdit ? null : $('#stock').val();
        var errorMessage = '';

        if (!namaBarang || !jenisBarangId) {
            errorMessage = 'Nama Barang dan Jenis Barang wajib diisi.';
        } else if (!isEdit && stock < 0) {
            errorMessage = 'Stock tidak boleh negatif.';
        }

        if (errorMessage) {
            Swal.fire({
                title: 'Error!',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Tentukan mode (create atau edit)
        var url = isEdit ? '<?= base_url('/api/barang') ?>/' + id : '<?= base_url('/api/barang') ?>';
        var method = 'POST';
        var actionText = isEdit ? 'diperbarui' : 'disimpan';
        var confirmText = isEdit ? 'update' : 'simpan';

        // Siapkan data untuk dikirim
        var data = {
            nama_barang: namaBarang,
            jenis_barang_id: jenisBarangId
        };
        if (!isEdit) {
            data.stock = stock;
        }
        if (isEdit) {
            data._method = 'PUT';
        }

        // Tampilkan SweetAlert untuk konfirmasi
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Data ini akan ${actionText}!`,
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
                            text: `Data barang berhasil ${actionText}.`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#form1-content')[0].reset();
                            window.location.href = '<?= base_url('/barang') ?>';
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