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
                        <h4 class="box-title" id="form-title">Form Jenis Barang</h4>
                    </div>
                    <!-- /.box-header -->
                    <form id="form1-content">
                        <input type="hidden" id="id" name="id">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_jenis_barang" class="form-label">Nama Jenis Barang</label>
                                        <input type="text" class="form-control" id="nama_jenis_barang" name="nama_jenis_barang" required>
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
    var currentUrl = window.location.href;
    var isEdit = currentUrl.includes('/edit/');
    var id = isEdit ? currentUrl.split('/edit/')[1] : null;

    if (isEdit && id) {
        $('#form-title').text('Edit Jenis Barang');
        $('#id').val(id);

        $.ajax({
            url: '<?= base_url('/api/jenis-barang') ?>/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#nama_jenis_barang').val(response.nama_jenis_barang);
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal memuat data: ' + (xhr.responseJSON?.message || error),
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '<?= base_url('/jenis-barang') ?>';
                });
            }
        });
    } else {
        $('#form-title').text('Tambah Jenis Barang');
    }

    // Handle submit
    $('#submitBtn').click(function (event) {
        var namaJenisBarang = $('#nama_jenis_barang').val().trim();
        if (!namaJenisBarang) {
            Swal.fire({
                title: 'Error!',
                text: 'Nama Jenis Barang wajib diisi.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        var url = isEdit ? '<?= base_url('/api/jenis-barang') ?>/' + id : '<?= base_url('/api/jenis-barang') ?>';
        var method = 'POST'; // Gunakan POST untuk keduanya
        var actionText = isEdit ? 'diperbarui' : 'disimpan';
        var confirmText = isEdit ? 'update' : 'simpan';

        var data = {
            nama_jenis_barang: namaJenisBarang
        };
        if (isEdit) {
            data._method = 'PUT';
        }

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
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: `Data jenis barang berhasil ${actionText}.`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#form1-content')[0].reset();
                            window.location.href = '<?= base_url('/jenis-barang') ?>';
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