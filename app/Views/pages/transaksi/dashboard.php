<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="container-full">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xl-12 col-lg-6 col-12">
          <div class="box">
            <div class="box-header with-border d-flex justify-content-between align-items-center">
              <h3 class="box-title">Transaksi</h3>
              <a href="<?= base_url('transaksi/form') ?>" class="btn btn-success btn-sm">Create</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row mb-3">
                <div class="col-md-6">
                  <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nama barang...">
                    <button class="btn btn-primary" id="searchBtn">Cari</button>
                  </div>
                </div>
                <div class="col-md-6">
                  <select id="sortSelect" class="form-select">
                    <option value="">Urutkan...</option>
                    <option value="nama_barang|asc">Nama Barang (A-Z)</option>
                    <option value="nama_barang|desc">Nama Barang (Z-A)</option>
                    <option value="created_at|asc">Tanggal Transaksi (Lama-Baru)</option>
                    <option value="created_at|desc">Tanggal Transaksi (Baru-Lama)</option>
                  </select>
                </div>
              </div>
              <div class="table-responsive">
                <table id="transaksi" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Barang</th>
                      <th>Jenis Barang</th>
                      <th>Jumlah Terjual</th>
                      <th>Tanggal Transaksi</th>
                      <th>Terakhir Diubah</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="transaksi_body">
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</div>
<!-- /.content-wrapper -->
<div class="modal" id="loading-modal" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background-color:rgba(0, 0, 0, 0.01);">
      <div class="modal-body text-center">
        <div class="spinner-border text-light" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <h5 class="mt-2 text-light">Loading...</h5>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function() {
    // Format tanggal
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }

    // Fungsi untuk memuat data
    function loadData() {
        var search = $('#searchInput').val();
        var sort = $('#sortSelect').val();
        var sortBy = sort ? sort.split('|')[0] : '';
        var order = sort ? sort.split('|')[1] : '';

        $('#loading-modal').modal('show');

        $.ajax({
            url: '<?= base_url('/api/transaksi') ?>',
            type: 'GET',
            data: {
                search: search,
                sort: sortBy,
                order: order
            },
            dataType: 'json',
            success: function(response) {
                var tbody = $('#transaksi_body');
                tbody.empty();

                if (response.length > 0) {
                    $.each(response, function(index, item) {
                        var row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.barang.nama_barang}</td>
                                <td>${item.barang.jenis_barang.nama_jenis_barang}</td>
                                <td>${item.jumlah_terjual}</td>
                                <td>${formatDate(item.created_at)}</td>
                                <td>${formatDate(item.updated_at)}</td>
                                <td>
                                    <a href="<?= base_url('transaksi/edit') ?>/${item.id}" class="btn btn-primary btn-sm btn-edit" data-id="${item.id}">Edit</a>
                                    <a class="btn btn-danger btn-sm btn-delete" data-id="${item.id}">Delete</a>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                } else {
                    tbody.append('<tr><td colspan="7" class="text-center">Tidak ada data transaksi</td></tr>');
                }
                $('#loading-modal').modal('hide');
            },
            error: function(xhr, status, error) {
                $('#transaksi_body').html('<tr><td colspan="7" class="text-center">Gagal memuat data</td></tr>');
                $('#loading-modal').modal('hide');
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal memuat data: ' + (xhr.responseJSON?.message || error),
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    // Muat data saat halaman dimuat
    loadData();

    // Handle pencarian
    $('#searchBtn').on('click', function() {
        loadData();
    });

    $('#searchInput').on('keyup', function(e) {
        if (e.key === 'Enter') {
            loadData();
        }
    });

    // Handle sorting
    $('#sortSelect').on('change', function() {
        loadData();
    });

    // Handle delete
    $('#transaksi').on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('/api/transaksi') ?>/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        loadData();
                        Swal.fire(
                            'Terhapus!',
                            'Data berhasil dihapus.',
                            'success'
                        );
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Gagal!',
                            'Gagal menghapus data: ' + (xhr.responseJSON?.message || error),
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>

<?= $this->endSection(); ?>