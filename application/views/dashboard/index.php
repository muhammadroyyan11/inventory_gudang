<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
  /* Lebar untuk tampilan mobile */
  @media (max-width: 767px) {

    #myChart,
    #myChartDonut {
      width: 100%;
      height: 400px;
    }
  }

  /* Lebar untuk tampilan desktop */
  @media (min-width: 768px) {

    #myChart,
    #myChartDonut {
      width: 100%;
      /* Sesuaikan dengan lebar desktop */
    }
  }
</style>
<section class="section dashboard">

  <div class="card">
    <div class="card-header bg-white">
      <h5>Filter</h5>
      <div class="row">
        <div class="col-lg-4">
          <div class="mb-2">
            <label for="minggu" class="form-label">Minggu</label>
            <input class="form-control form-control-sm" id="minggu" type="week" name="minggu">
          </div>
        </div>
        <div class="col-lg-4">
          <div class="mb-2">
            <label for="bulan" class="form-label">Bulan</label>
            <input class="form-control form-control-sm" id="bulan" type="month" name="bulan">
          </div>
        </div>
        <div class="col-lg-4">
          <div class="mb-2">
            <label for="tahun" class="form-label">Tahun</label>
            <select name="tahun" id="tahun" class="form-control form-control-sm">
              <option value="">Pilih Tahun</option>
              <?php
              for ($t = 2024; $t <= date('Y'); $t++) {
                echo '<option value="' . $t . '">' . $t . '</option>';
              }
              ?>
            </select>
          </div>
        </div>

      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-xxl-4 col-md-4">


          <div class="card info-card sales-card">


            <div class="card-body">
              <h5 class="card-title">Omset <span>| By Filter</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cash"></i>
                </div>
                <div class="ps-3">
                  <h6 id="total_penjualan"></h6>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">


            <div class="card-body">
              <h5 class="card-title">User <span>| Total</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6><?= $total_user ?></h6>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">


            <div class="card-body">
              <h5 class="card-title">Barang <span>| Total</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-table"></i>
                </div>
                <div class="ps-3">
                  <h6><?= $total_barang ?></h6>
                </div>
              </div>
            </div>

          </div>
        </div>


        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">


            <div class="card-body">
              <h5 class="card-title">Transaksi Masuk <span>| By Filter</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cart-plus"></i>
                </div>
                <div class="ps-3">
                  <h6 id="total_trx_masuk"></h6>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">


            <div class="card-body">
              <h5 class="card-title">Transaksi Keluar <span>| By Filter</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cart-dash"></i>
                </div>
                <div class="ps-3">
                  <h6 id="total_trx_keluar"></h6>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">


            <div class="card-body">
              <h5 class="card-title">Transaksi Return <span>| By Filter</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-reply"></i>
                </div>
                <div class="ps-3">
                  <h6 id="total_trx_return"></h6>
                </div>
              </div>
            </div>

          </div>
        </div>


        <div class="col-xxl-12 col-md-12 bg-white">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body" style="overflow-y: auto;">
                  <canvas id="myChart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="card">
                <div class="card-header">
                  <div class="card-title">Barang Terlaris <small>(By Filter)</small></div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="datatables" class="table w-100">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Barang</th>
                          <th>Harga</th>
                          <th>Qty</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>

                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card">
                <div class="card-header">
                  <div class="card-title">Sumber Transaksi <small>(By Filter)</small></div>
                </div>
                <div class="card-body" style="overflow-y: auto;">
                  <canvas id="myChartDonut"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>

  </div>

  </div><!-- End Right side columns -->

  </div>
</section>

<script>
  $(document).ready(function() {
    table();
    get('', '');
    chart_donut('', '');
    get_trx('', '');

    $("body").on("click", "#reload", function() {
      table();
    })

    function get_trx(jenis, param) {
      $.ajax({
        url: "<?= base_url('dashboard/card_total') ?>",
        method: 'GET',
        dataType: 'json',
        data: {
          jenis: jenis,
          param: param
        },
        success: function(response) {
          // console.log(response)
          $("#total_penjualan").html(response.total_penjualan);
          $("#total_trx_masuk").html(response.total_trx_masuk);
          $("#total_trx_keluar").html(response.total_trx_keluar);
          $("#total_trx_return").html(response.total_trx_return);
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }

    // Function to fetch data and update chart for week
    function get(jenis, param) {
      $.ajax({
        url: "<?= base_url('dashboard/data_chart') ?>",
        method: 'GET',
        dataType: 'json',
        data: {
          jenis: jenis,
          param: param
        },
        success: function(response) {
          updateChart(jenis, response);
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }


    // Event handler for week input
    $('#minggu').on('change', function() {
      var data = $(this).val();
      if (data == '') {
        get('', '');
        chart_donut('', '');
        get_trx('', '');
        return;
      }
      get(1, data);
      chart_donut(1, data);
      get_trx(1, data);
      $('#datatables').DataTable().destroy();
      table(1, data);
    });

    // Event handler for month input
    $('#bulan').on('change', function() {
      var data = $(this).val();
      if (data == '') {
        get('', '');
        chart_donut('', '');
        get_trx('', '');
        return;
      }
      get(2, data);
      chart_donut(2, data);
      get_trx(2, data);
      $('#datatables').DataTable().destroy();
      table(2, data);
    });

    // Event handler for year input
    $('#tahun').on('change', function() {
      var data = $(this).val();
      if (data == '') {
        get('', '');
        chart_donut('', '');
        get_trx('', '');
        return;
      }
      get(3, data);
      chart_donut(3, data);
      get_trx(3, data);
      $('#datatables').DataTable().destroy();
      table(3, data);
    });

    // Data
    var data = {
      labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
      datasets: [{
          label: "Barang Masuk",
          data: [100, 120, 130, 110, 150, 140, 160, 170, 180, 190, 200, 210],
          borderColor: "blue",
          fill: false
        },
        {
          label: "Barang Keluar",
          data: [80, 90, 100, 110, 120, 130, 140, 150, 160, 170, 180, 190],
          borderColor: "green",
          fill: false
        },
        {
          label: "Barang Return",
          data: [10, 15, 20, 15, 25, 20, 30, 35, 40, 45, 50, 55],
          borderColor: "red",
          fill: false
        }
      ]
    };

    // Options
    var options = {
      responsive: false,
      plugins: {
        title: {
          display: true,
          text: 'Grafik Barang Masuk, Keluar, dan Return (By Filter)'
        },
        legend: {
          position: 'top',
        },
      },
      scales: {
        y: {
          title: {
            display: true,
            text: 'Jumlah Barang'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Grafik Barang Masuk, Keluar, dan Return (By Filter)'
          }
        }
      }
    };

    // Create chart
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
      data: data,
      options: options
    });

    function updateChart(jenis, response) {
      var labels = Object.keys(response);
      var dataBarangMasuk = [];
      var dataBarangKeluar = [];
      var dataBarangReturn = [];
      labels.forEach(function(date) {
        dataBarangMasuk.push(response[date]['barang_masuk']);
        dataBarangKeluar.push(response[date]['barang_keluar']);
        dataBarangReturn.push(response[date]['barang_return']);
      });

      // Memperbarui data chart
      myChart.data.labels = labels;
      myChart.data.datasets[0].data = dataBarangMasuk;
      myChart.data.datasets[1].data = dataBarangKeluar;
      myChart.data.datasets[2].data = dataBarangReturn;
      myChart.update();
    }
  });

  function table(jenis, param) {
    var table = $('#datatables').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      retrieve: true,
      paging: true,
      destroy: true,
      deferRender: true,
      searching: true,
      scrollX: true,
      order: false,
      ajax: {
        url: "dashboard/top_selling",
        type: "POST",
        data: {
          jenis: jenis,
          param: param
        }
      },
      columns: [{
          title: "No",
          data: 0
        },
        {
          title: "Barang",
          data: 1
        },
        {
          title: "Harga",
          data: 2
        },
        {
          title: "Qty",
          data: 3
        },
        {
          title: "Total",
          data: 4
        }
      ],
      dom: '<"top"lBf>rt<"bottom"ip><"clear">',
      buttons: [{
          extend: 'copy',
          text: 'Copy',
          exportOptions: {
            columns: [0, 1, 2, 3, 4]
          }
        },
        {
          extend: 'excel',
          text: 'Excel',
          exportOptions: {
            columns: [0, 1, 2, 3, 4]
          }
        },
        {
          extend: 'pdf',
          text: 'PDF',
          exportOptions: {
            columns: [0, 1, 2, 3, 4]
          }
        },
        {
          extend: 'csv',
          text: 'CSV',
          exportOptions: {
            columns: [0, 1, 2, 3, 4]
          }
        },
        {
          extend: 'print',
          text: 'Print',
          exportOptions: {
            columns: [0, 1, 2, 3, 4]
          }
        }
      ],

    });
    table.draw();
    $('.dataTables_length').css('margin-bottom', '10px');

  }

  let donutChart; // Variabel untuk menyimpan instance Chart

  function chart_donut(jenis, param) {
    $.ajax({
      url: "<?= base_url('dashboard/data_chart_donut') ?>",
      method: 'GET',
      dataType: 'json',
      data: {
        jenis: jenis,
        param: param
      },
      success: function(data) {
        const labels = Object.keys(data);
        const values = Object.values(data);

        // Jika donutChart sudah ada, update data-nya
        if (donutChart) {
          donutChart.data.labels = labels;
          donutChart.data.datasets[0].data = values;
          donutChart.update();
        } else { // Jika belum, buat grafik baru
          const ctx = document.getElementById('myChartDonut').getContext('2d');
          donutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
              labels: labels,
              datasets: [{
                data: values,
                backgroundColor: [
                  'rgba(255, 99, 132, 0.7)',
                  'rgba(54, 162, 235, 0.7)'
                ],
                borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              legend: {
                position: 'right',
              },
              title: {
                display: true,
                text: 'Donut Chart'
              },
            }
          });
        }
      },
      error: function(err) {
        console.error('Error:', err);
      }
    });
  }
</script>