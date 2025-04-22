<?= $this->extend('template/layout'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="container-full">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box bg-gradient-primary overflow-hidden pull-up">
            <div class="box-body pe-0 ps-lg-50 ps-15 py-0">
              <div class="row align-items-center">
                <div class="col-12 col-lg-8">
                  <h1 class="fs-40 text-white" id="nama"></h1>
                  <p class="text-white mb-0 fs-20">
                    Hallo, <?= session()->get('nama'); ?>!
                  </p>
                </div>
                <div class="col-12 col-lg-4"><img src="<?= base_url('assets/images/custom-15.svg') ?>" alt=""></div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-12 col-lg-6 col-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Perbandingan Jenis Barang Berdasarkan Total Terjual</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row mb-3">
                <div class="col-md-5">
                  <label for="startDate">Tanggal Mulai:</label>
                  <input type="date" id="startDate" class="form-control">
                </div>
                <div class="col-md-5">
                  <label for="endDate">Tanggal Selesai:</label>
                  <input type="date" id="endDate" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                  <button class="btn btn-primary w-100" id="filterBtn">Filter</button>
                </div>
              </div>
              <div class="table-responsive">
                <table id="compareJenisBarang" class="table table-bordered table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Jenis Barang</th>
                      <th>Total Terjual</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="compareJenisBarang_body">
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
<script src="assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
    // Fungsi untuk memuat data
    function loadData() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();

        // Validasi tanggal
        if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
            Swal.fire({
                title: 'Error!',
                text: 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        $('#loading-modal').modal('show');

        $.ajax({
            url: '<?= base_url('/api/transaksi-jenis/compare-jenis-barang') ?>',
            type: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            dataType: 'json',
            success: function(response) {
                var tbody = $('#compareJenisBarang_body');
                tbody.empty();

                if (response.data && response.data.length > 0) {
                    $.each(response.data, function(index, item) {
                        var rowClass = '';
                        if (item.status === 'Terbanyak') {
                            rowClass = 'table-success';
                        } else if (item.status === 'Terendah') {
                            rowClass = 'table-danger';
                        }
                        var row = `
                            <tr class="${rowClass}">
                                <td>${index + 1}</td>
                                <td>${item.nama_jenis_barang}</td>
                                <td>${item.total_terjual}</td>
                                <td>${item.status || '-'}</td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                } else {
                    tbody.append('<tr><td colspan="4" class="text-center">Tidak ada data untuk rentang waktu ini</td></tr>');
                }
                $('#loading-modal').modal('hide');
            },
            error: function(xhr, status, error) {
                $('#compareJenisBarang_body').html('<tr><td colspan="4" class="text-center">Gagal memuat data</td></tr>');
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

    // Handle filter
    $('#filterBtn').on('click', function() {
        loadData();
    });

    // Handle enter key pada input tanggal
    $('#startDate, #endDate').on('keyup', function(e) {
        if (e.key === 'Enter') {
            loadData();
        }
    });
});
</script>

<?= $this->endSection(); ?>