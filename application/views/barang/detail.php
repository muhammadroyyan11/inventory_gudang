<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-3 mx-auto text-center">
                <button style="border-radius: 0px;" class="btn btn-danger" onclick="window.location.href='<?= base_url('barang') ?>'"><i class="bi bi-arrow-left"></i> Kembali</button>
                <button style="border-radius: 0px;" class="btn btn-secondary" id="reload"><i class="bi bi-arrow-repeat"></i> Reload</button>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="accordion bg-white mb-3">
                        <div class="accordion-item">
                            <div class="accordion-header">
                                <h2 class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#tab-filter" aria-expanded="false" style="cursor: pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
                                    </svg>
                                    Filter Data
                                </h2>
                            </div>
                            <div id="tab-filter" class="accordion-collapse collapse">
                                <div class="accordion-body pt-0">
                                    <form action="" class="form-inline">
                                        <div class="row align-items-center">
                                            <!-- Pilih Gudang Tujuan -->
                                            <div class="col-md-3">
                                                <div class="form-group mb-2">
                                                    <label for="gudang" class="sr-only">Pilih Gudang Tujuan</label>
                                                    <select style="width:100% !important;border-radius:0px" required="" name="gudang" id="gudang" class="form-control">
                                                        <option value="">--- Pilih Gudang Tujuan ---</option>
                                                        <?php foreach ($gudang as $key => $value) : ?>
                                                            <option value="<?= $value->id ?>"><?= $value->name ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Tipe Manajemen -->
                                            <div class="col-md-3">
                                                <div class="form-group mb-2">
                                                    <label for="tipe" class="sr-only">Tipe Manajemen</label>
                                                    <select style="width:100% !important;border-radius:0px" required="" name="tipe" id="tipe" class="form-control">
                                                        <option value="">--- Pilih Tipe Manajemen ---</option>
                                                        <option value="1">Stock Masuk</option>
                                                        <option value="2">Stock Keluar</option>
                                                        <option value="3">Return</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Bulan -->
                                            <div class="col-md-2">
                                                <div class="form-group mb-2">
                                                    <label for="bulan" class="sr-only">Bulan</label>
                                                    <select style="width:100% !important;border-radius:0px" required="" name="bulan" id="bulan" class="form-control">
                                                        <option value="00">...</option>
                                                        <option value="01">Januari</option>
                                                        <option value="02">Februari</option>
                                                        <option value="03">Maret</option>
                                                        <option value="04" selected="">April</option>
                                                        <option value="05">Mei</option>
                                                        <option value="06">Juni</option>
                                                        <option value="07">Juli</option>
                                                        <option value="08">Agustus</option>
                                                        <option value="09">September</option>
                                                        <option value="10">Oktober</option>
                                                        <option value="11">November</option>
                                                        <option value="12">Desember</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Tahun -->
                                            <div class="col-md-2">
                                                <div class="form-group mb-2">
                                                    <label for="tahun" class="sr-only">Tahun</label>
                                                    <select style="width:100% !important;border-radius:0px" required="" name="tahun" id="tahun" class="form-control">
                                                        <option value="">Pilih Tahun</option>
                                                        <?php
                                                        $tahun_sekarang = date('Y');
                                                        $tahun_awal = $tahun_sekarang - 4;
                                                        for ($tahun = $tahun_sekarang; $tahun >= $tahun_awal; $tahun--) {
                                                            $selected = ($tahun == $tahun_sekarang) ? 'selected' : '';
                                                            echo '<option value="' . $tahun . '" ' . $selected . '>' . $tahun . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Button Filter -->
                                            <div class="col-md-2 mt-4">
                                                <button style="border-radius:0px" id="btn-filter" style="width:100%;" type="button" class="btn btn-secondary mb-2">Filter Data</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Barang Detail</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatables" class="table w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Barang</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Tipe</th>
                                    <th>Stock Sebelum</th>
                                    <th>Stock Sesudah</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $("body").on("click", "#btn-filter", function() {
            $('#datatables').DataTable().ajax.reload();
        })

        var table = $('#datatables').DataTable({
            "language": {
                "search": "",
                "searchPlaceholder": "Search..."
            },
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
                // url: "barang/ajax_detail/<?= $id ?>",
                url: "<?= base_url() ?>barang/ajax_detail/<?= $id ?>",
                type: "POST",
                data: function(d) {
                    d.gudang = $('#gudang').val();
                    d.tipe = $('#tipe').val();
                    d.bulan = $('#bulan').val();
                    d.tahun = $('#tahun').val();
                }
            },
            columns: [{
                    title: "No",
                    data: 0,
                    className: 'align-middle'
                },
                {
                    title: "Barang",
                    data: 1,
                    className: 'align-middle'
                },
                {
                    title: "Keterangan",
                    data: 2,
                    className: 'align-middle'
                },
                {
                    title: "Tanggal",
                    data: 3,
                    className: 'align-middle'
                },
                {
                    title: "Jumlah",
                    data: 4,
                    className: 'align-middle text-center'
                },
                {
                    title: "Tipe",
                    data: 5,
                    className: 'align-middle'
                },
                {
                    title: "Stock Sebelum",
                    data: 6,
                    className: 'align-middle text-center'
                },
                {
                    title: "Stock Sesudah",
                    data: 7,
                    className: 'align-middle text-center'
                },
            ],
            dom: '<"top"lBf>rt<"bottom"ip><"clear">',
            buttons: [{
                    extend: 'copy',
                    text: 'Copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }
            ],
        });

        $('.dataTables_length').css('margin-bottom', '10px');
    })

    $("body").on("click", "#reload", function() {
        table.draw();
    })
</script>