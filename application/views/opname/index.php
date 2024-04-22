<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Opname</div>
                </div>
                <div class="card-body">
                    <div class="mt-2 mb-2">
                        <a href="<?= base_url('opname/input_opname') ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-square"></i> Input Opname</a>
                        <button class="btn btn-secondary btn-sm" id="reload"><i class="bi bi-arrow-repeat"></i> Reload</button>
                    </div>
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row mt-2">
                                <div class="col-lg-3">
                                    <div class="mb-2">
                                        <label class="form-label">Range Tanggal</label>
                                        <input type="text" class="form-control form-control-sm date" name="tanggal" id="tanggal" data-toggle="date-picker" data-cancel-class="btn-warning" placeholder="mm/dd/YYYY - mm/dd/YYYY" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-2">
                                        <label class="form-label">Lokasi Gudang</label>
                                        <select name="lokasi_id" id="lokasi_id" class="form-control form-control-sm form-select">
                                            <option value="">Pilih Lokasi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-2">
                                        <label class="form-label">Bulan Opname</label>
                                        <select name="bulan" id="bulan" class="form-control form-control-sm">
                                            <option value="">Pilih Bulan</option>
                                            <option value="01">Januari</option>
                                            <option value="02">Februari</option>
                                            <option value="03">Maret</option>
                                            <option value="04">April</option>
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
                                <div class="col-lg-3">
                                    <div class="mb-2">
                                        <label class="form-label">Tahun Opname</label>
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
                                <div class="col-lg-3">
                                    <div class="mb-2 mt-4">
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
                                    <th>Tanggal Pelaksanaan</th>
                                    <th>No. Nota</th>
                                    <th>Lokasi</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Keterangan</th>
                                    <th>User Input</th>
                                    <th>Created At</th>
                                    <th>Aksi</th>
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
            // $('#datatables').DataTable().destroy();
            table();
        })

        $("body").on("click", "#filter", function() {
            var tanggal = $("#tanggal").val();
            var lokasi_id = $("#lokasi_id").val();
            var bulan = $("#bulan").val();
            var tahun = $("#tahun").val();

            $('#datatables').DataTable().destroy();
            table(tanggal, lokasi_id, bulan,tahun);
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
            $('#bulan').val('');
            $('#tahun').val('');
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

    function table(tanggal,lokasi_id,bulan,tahun){
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
            order: true,
            ajax: {
                url: "<?= base_url('opname/ajax_table') ?>",
                type: "POST",
                data: {
                    tanggal: tanggal,
                    lokasi_id: lokasi_id,
                    bulan: bulan,
                    tahun:tahun
                }
            },
            columns: [{
                    title: "No",
                    data: 0,
                    orderable: false,
                    searchable: false
                },
                {
                    title: "Tanggal Pelaksanaan",
                    data: 2
                },
                {
                    title: "No. Nota",
                    data: 3
                },
                {
                    title: "Lokasi",
                    data: 4
                },
                {
                    title: "Bulan",
                    data: 9
                },
                {
                    title: "Tahun",
                    data: 10
                },
                {
                    title: "Keterangan",
                    data: 5,
                    orderable: false,
                    searchable: false
                },
                {
                    title: "User Input",
                    data: 6
                },
                {
                    title: "Created At",
                    data: 7
                },
                {
                    title: "Aksi",
                    data: 8,
                    orderable: false,
                    searchable: false
                }
            ],
            dom: '<"top"lBf>rt<"bottom"ip><"clear">',
            buttons: [{
                    extend: 'copy',
                    text: 'Copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                }
            ],

        });
        table.draw();
        $('.dataTables_length').css('margin-bottom', '10px');
    }

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
</script>