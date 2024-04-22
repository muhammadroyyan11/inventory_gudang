<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">History Barang Masuk & Keluar</div>
                </div>
                <div class="card-body">
                    <div class="mt-2 mb-2">
                        <!-- <button class="btn btn-primary btn-sm" id="tambah"><i class="bi bi-plus-square"></i> Tambah Data</button> -->
                        <button class="btn btn-secondary btn-sm" id="reload"><i class="bi bi-arrow-repeat"></i> Reload</button>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row mt-2">
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Range Tanggal</label>
                                        <input type="text" class="form-control form-control-sm date" name="tanggal" id="tanggal" data-toggle="date-picker" data-cancel-class="btn-warning" placeholder="mm/dd/YYYY - mm/dd/YYYY" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Lokasi Gudang</label>
                                        <select name="lokasi_id" id="lokasi_id" class="form-control form-control-sm form-select">
                                            <option value="">Pilih Lokasi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis</label>
                                        <select name="jenis" id="jenis" class="form-control form-control-sm">
                                            <option value="">Pilih Jenis</option>
                                            <option value="1">Masuk</option>
                                            <option value="2">Keluar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 mt-4">
                                        <button class="btn btn-primary" id="filter">Filter</button>
                                        <button class="btn btn-danger" id="reset">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="datatables" class="table w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Lokasi</th>
                                    <th>Jenis</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Satuan</th>
                                    <th>Kategori</th>
                                    <th>Brand</th>
                                    <th>Stock Awal</th>
                                    <th>Jumlah</th>
                                    <th>Stock Akhir</th>
                                    <!-- <th>Aksi</th> -->
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
        lokasi();
        table();


        $("body").on("click", "#reload", function() {
            $('#datatables').DataTable().destroy();
            table();
        })

        $("body").on("click", "#filter", function() {
            var tanggal = $("#tanggal").val();
            var lokasi_id = $("#lokasi_id").val();
            var jenis = $("#jenis").val();

            console.log(tanggal + '/' + lokasi_id + '/' + jenis)
            $('#datatables').DataTable().destroy();
            table(tanggal, lokasi_id, jenis);
        })


        $('#tanggal').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('#reset').click(function() {
            $('#tanggal').val('');
            $('#lokasi_id').val('').trigger('change');
            $('#jenis').val('');
            $('#datatables').DataTable().destroy();
            table();
        });

        $('#tanggal').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('#tanggal').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        

    })

    function lokasi() {
        $.ajax({
            url: "<?php echo base_url('lokasi/get_all') ?>",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data.data);
                var list = '<option value="">Pilih Lokasi</option>';
                $.each(data.data, function(key, value) {
                    list += `
                        <option value="${value.id}">${value.name}</option>
                    `;
                });
                $("#lokasi_id").html(list);
                $("#lokasi_id").select2({
                    // dropdownParent: $('#modal_akses .modal-body'),
                    width: '100%',
                })
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Ambil data gudang gagal!",
                    icon: "error",
                    showConfirmButton: true,
                });
            }
        });
    }

    function table(tanggal = null, lokasi_id = null, jenis = null) {

        console.log(tanggal + '/' + lokasi_id + '/' + jenis)
        $('#datatables').DataTable({
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
                url: "<?= base_url('stock/histori_table') ?>",
                type: "POST",
                data: {
                    tanggal: tanggal,
                    lokasi_id: lokasi_id,
                    jenis: jenis
                }
            },
            columns: [{
                    title: "No",
                    data: 0
                },
                {
                    title: "Tanggal",
                    data: 11
                },
                {
                    title: "Lokasi",
                    data: 1
                },

                {
                    title: "Jenis",
                    data: 2
                },
                {
                    title: "Kode",
                    data: 3
                },
                {
                    title: "Nama",
                    data: 4
                },
                {
                    title: "Satuan",
                    data: 5
                },
                {
                    title: "Kategori",
                    data: 6
                },
                {
                    title: "Brand",
                    data: 7
                },
                {
                    title: "Stock Awal",
                    data: 8
                },
                {
                    title: "Jumlah",
                    data: 9
                },
                {
                    title: "Stock Akhir",
                    data: 10
                },
            ],
            dom: '<"top"lBf>rt<"bottom"ip><"clear">',
            buttons: [{
                    extend: 'copy',
                    text: 'Copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                    }
                }
            ],

        });
        // table.draw();
        $('.dataTables_length').css('margin-bottom', '10px');
    }
</script>