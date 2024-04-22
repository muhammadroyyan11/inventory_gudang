</main>

<footer id="footer" class="footer d-print-none">
  <div class="copyright">
    &copy; Copyright <strong><span><?= toko()->name ?></span></strong>. All Rights Reserved
  </div>
  <div class="credits">
    Designed by Rahmad</a>
  </div>
</footer>



<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>




<script src="<?= base_url() ?>assets/vendor/apexcharts/apexcharts.min.js"></script>
<!-- <script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script src="<?= base_url() ?>assets/vendor/chart.js/chart.umd.js"></script>
<script src="<?= base_url() ?>assets/vendor/echarts/echarts.min.js"></script>
<script src="<?= base_url() ?>assets/vendor/quill/quill.min.js"></script>
<script src="<?= base_url() ?>assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="<?= base_url() ?>assets/vendor/tinymce/tinymce.min.js"></script>
<script src="<?= base_url() ?>assets/vendor/php-email-form/validate.js"></script>
<!-- <script src="<?= base_url() ?>assets/dataTables.js"></script> -->
<script src="<?= base_url() ?>assets/js/main.js"></script>
<!-- DataTables JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<?php if ($this->session->flashdata('success')) : ?>
  <script>
    Swal.fire({
      title: "Berhasil!",
      text: "<?php echo $this->session->flashdata('success'); ?>",
      icon: "success",
      showConfirmButton: false,
      timer: 1000
    });
  </script>
<?php endif; ?>

<?php if ($this->session->flashdata('error')) : ?>
  <script>
    Swal.fire({
      title: "Gagal!",
      text: "<?php echo $this->session->flashdata('error'); ?>",
      icon: "error",
      showConfirmButton: true
    });
  </script>
<?php endif; ?>

<script>
  $(document).ready(function() {
    $('.rupiah').on('input', function() {
      let amount = $(this).val();
      amount = amount.replace(/[^\d]/g, '');
      amount = addThousandSeparator(amount);
      $(this).val(amount);
    });
  });

  function addThousandSeparator(amount) {
    let parts = amount.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return parts.join(".");
  }

  function clearRupiah(rupiah) {
    return rupiah.replace(/[^\d]/g, '');
  }
</script>
</body>

</html>