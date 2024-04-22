<div class="pagetitle">
    <h1>Data Barang Masuk</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript::void">Barang Masuk</a></li>
            <li class="breadcrumb-item active">Data</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Barang Masuk</div>
                </div>
                <div class="card-body">
                    <div class="mt-2 mb-2">
                        <a style="border-radius: 0px;" href="<?= base_url('stock/masuk') ?>" class="btn btn-primary"><i class="bi bi-plus-square"></i>&nbsp;&nbsp;Input Barang Masuk</a>
                        <button style="border-radius: 0px;" class="btn btn-secondary" id="reload"><i class="bi bi-arrow-repeat"></i> Reload</button>
                    </div>
                    <div class="card-body mt-3 px-0">
                        <div class="row mt-2">
                            <div class="col-lg-3">
                                <div class="mb-2">
                                    <label class="form-label">Range Tanggal</label>
                                    <input type="text" class="form-control date" name="tanggal" id="tanggal" data-toggle="date-picker" data-cancel-class="btn-warning" placeholder="mm/dd/YYYY - mm/dd/YYYY" autocomplete="off">
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
                                    <label class="form-label">Supplier</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control form-control-sm form-select">
                                        <option value="">Pilih Supplier</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mt-4">
                                    <button style="border-radius: 0px;" class="btn btn-primary" id="filter"><i class="bi bi-forward-fill"></i>&nbsp;&nbsp;Filter Data</button>
                                    <button style="border-radius: 0px;" class="btn btn-danger" id="reset">Reset</button>
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
                                    <th>No. Nota</th>
                                    <th>Lokasi</th>
                                    <th>Supplier</th>
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
        supplier();
        table();

        $("body").on("click", "#reload", function() {
            // $('#datatables').DataTable().destroy();
            table();
        })

        $("body").on("click", "#filter", function() {
            var tanggal = $("#tanggal").val();
            var lokasi_id = $("#lokasi_id").val();
            var supplier_id = $("#supplier_id").val();

            $('#datatables').DataTable().destroy();
            table(tanggal, lokasi_id, supplier_id);
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
            $('#supplier_id').val('').trigger('change');
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


    function table(tanggal, lokasi_id, supplier_id) {
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
            order: true,
            ajax: {
                url: "<?= base_url('masuk/ajax_table') ?>",
                type: "POST",
                data: {
                    tanggal: tanggal,
                    lokasi_id: lokasi_id,
                    supplier_id: supplier_id
                }
            },
            columns: [{
                    title: "No",
                    data: 0,
                    orderable: false,
                    searchable: false
                },
                {
                    title: "Tanggal",
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
                    title: "Supplier",
                    data: 5
                },
                {
                    title: "Keterangan",
                    data: 6,
                    orderable: false,
                    searchable: false
                },
                {
                    title: "User Input",
                    data: 7
                },
                {
                    title: "Created At",
                    data: 8
                },
                {
                    title: "Aksi",
                    data: 9,
                    orderable: false,
                    searchable: false
                }
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
                    theme: 'bootstrap-5',
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

    function supplier() {
        $.ajax({
            url: "<?php echo base_url('supplier/get_all') ?>",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data.data);
                var list = '<option value="">Pilih Supplier</option><option value="0">Umum</option>';
                $.each(data.data, function(key, value) {
                    list += `
                        <option value="${value.id}">${value.name}</option>
                    `;
                });
                $("#supplier_id").html(list);
                $("#supplier_id").select2({
                    theme: 'bootstrap-5',
                    // dropdownParent: $('#modal_akses .modal-body'),
                    width: '100%',
                })
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Ambil data supplier gagal!",
                    icon: "error",
                    showConfirmButton: true,
                });
            }
        });
    }
</script>