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
              <h3 class="box-title">Stock History</h3>
              <a href="<?= base_url('stock-history/form') ?>" class="btn btn-success btn-sm">Create</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="stock_history" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jenis Aksi</th>
                            <th>Stock</th>
                            <th>Dibuat</th>
                        </tr>
                    </thead>
                    <tbody id="stock_history_body">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        return date.toLocaleDateString('id-ID', options);
    }

    function loadData() {
        $.ajax({
            url: '<?= base_url('/api/stock-history') ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var tbody = $('#stock_history_body');
                tbody.empty();

                if (response.length > 0) {
                    $.each(response, function(index, item) {
                        var row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.barang.nama_barang}</td>
                                <td>${item.aksi}</td>
                                <td>${item.stock}</td>
                                <td>${formatDate(item.created_at)}</td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                } else {
                    tbody.append('<tr><td colspan="5" class="text-center">Tidak ada data stock history</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
                $('#stock_history_body').html('<tr><td colspan="5" class="text-center">Gagal memuat data</td></tr>');
            }
        });
    }
    loadData();
});
</script>

<?= $this->endSection(); ?>