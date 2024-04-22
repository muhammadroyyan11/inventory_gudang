<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Transfer Barang</div>
                </div>
                <div class="card-body">
                    <div class="mt-2 mb-2">
                        <a href="<?= base_url('stock/transfer') ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-square"></i> Input Transfer Barang</a>
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
                                    <th>Tanggal</th>
                                    <th>No. Nota</th>
                                    <th>Dari Lokasi</th>
                                    <th>Ke Lokasi</th>
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
            var metode_transaksi = $("#metode_transaksi").val();
            var status = $("#status").val();

            $('#datatables').DataTable().destroy();
            table(tanggal, lokasi_id);
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
            $('#datatables').DataTable().destroy();
            table();
        });

        $('#tanggal').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('#tanggal').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });


        $("body").on("click", ".bayar", function() {
            $('#form')[0].reset();
            var id = $(this).data('id');
            var nota = $(this).data('nota');
            var total = $(this).data('total');
            var bayar = $(this).data('bayar');
            $("#id").val(id);
            $("#nota").val(nota);
            $("#jumlah_total").val(addThousandSeparator(total));
            $("#bayar").val(addThousandSeparator(bayar));
            $("#btnSave").html('<i class="bi bi-save"></i> Simpan');
            $("#modal_bayar").modal("show");
            $("#bayar").focus();
        })

        $("body").on('submit', '#form', function(e) {
            e.preventDefault();
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').prop('disabled', true); //set button disable 
            var id = $("#id").val();
            var url = "<?php echo base_url('keluar/bayar') ?>";
            $.ajax({
                url: url,
                secureuri: false,
                cache: false,
                type: "POST",
                data: new FormData(this),
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success == true) {
                        $('#datatables').DataTable().destroy();
                        table();
                        $('#form')[0].reset();
                        $('#modal_bayar').modal('hide');
                        Swal.fire({
                            title: "Berhasil!",
                            text: data.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: data.message,
                            icon: "error",
                            showConfirmButton: true,
                        });
                    }

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').prop('disabled', false); //set button enable 

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi Kesalahan",
                        icon: "error",
                        showConfirmButton: true,
                    });
                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').prop('disabled', false); //set button enable 
                }
            });
        })

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

    

    function table(tanggal, lokasi_id) {
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
            ajax: {
                url: "<?= base_url('transfer/ajax_table') ?>",
                type: "POST",
                data: {
                    tanggal: tanggal,
                    lokasi_id: lokasi_id
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
                    data: 1
                },
                {
                    title: "No. Nota",
                    data: 2
                },
                {
                    title: "Dari Lokasi",
                    data: 3
                },
                {
                    title: "Ke Lokasi",
                    data: 4
                },
                {
                    title: "User Input",
                    data: 5
                },
                {
                    title: "Created At",
                    data:6
                },
                {
                    title: "Aksi",
                    data: 7,
                    orderable: false,
                    searchable: false
                }
            ],
            dom: '<"top"lBf>rt<"bottom"ip><"clear">',
            buttons: [{
                    extend: 'copy',
                    text: 'Copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                }
            ],

        });
        table.draw();
        $('.dataTables_length').css('margin-bottom', '10px');
    }
</script>