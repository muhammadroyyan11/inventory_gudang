<div class="pagetitle">
    <h1>Data Barang</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript::void">Master</a></li>
            <li class="breadcrumb-item active">Data Barang</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Barang</div>
                </div>
                <div class="card-body">
                    <div class="mt-2 mb-2">
                        <button style="border-radius: 2px;" class="btn btn-primary" id="tambah"><i class="bi bi-plus-square"></i>&nbsp;&nbsp;Tambah Data</button>
                        <button style="border-radius: 2px;" class="btn btn-secondary" id="reload"><i class="bi bi-arrow-repeat"></i> Reload</button>
                    </div>
                    <div class="table-responsive">
                        <table id="datatables" class="table w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Satuan</th>
                                    <th>Kategori</th>
                                    <th>Brand</th>
                                    <th>Harga</th>
                                    <th>Min Stock</th>
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

<div class="modal fade" id="modal_barang" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form" class="form-horizontal">
                <div class="modal-body" style="max-height: calc(100vh - 200px);overflow-y: auto;">
                    <div class="text-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-tabler icon-tabler-info-square-rounded-filled text-info" width="40" height="40" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 2l.642 .005l.616 .017l.299 .013l.579 .034l.553 .046c4.687 .455 6.65 2.333 7.166 6.906l.03 .29l.046 .553l.041 .727l.006 .15l.017 .617l.005 .642l-.005 .642l-.017 .616l-.013 .299l-.034 .579l-.046 .553c-.455 4.687 -2.333 6.65 -6.906 7.166l-.29 .03l-.553 .046l-.727 .041l-.15 .006l-.617 .017l-.642 .005l-.642 -.005l-.616 -.017l-.299 -.013l-.579 -.034l-.553 -.046c-4.687 -.455 -6.65 -2.333 -7.166 -6.906l-.03 -.29l-.046 -.553l-.041 -.727l-.006 -.15l-.017 -.617l-.004 -.318v-.648l.004 -.318l.017 -.616l.013 -.299l.034 -.579l.046 -.553c.455 -4.687 2.333 -6.65 6.906 -7.166l.29 -.03l.553 -.046l.727 -.041l.15 -.006l.617 -.017c.21 -.003 .424 -.005 .642 -.005zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" stroke-width="0" fill="currentColor"></path>
                        </svg>
                        <h4 id="modal-title" class="mt-2">Data Barang</h4>
                    </div>
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body modal_id">
                        <div class="mb-2">
                            <label for="kode">Kode Barang <sup>(Optional)</sup></label>
                            <input name="kode" id="kode" class="form-control" type="text">
                        </div>
                        <div class="mb-2">
                            <label for="nama">Nama</label>
                            <input name="nama" id="nama" class="form-control" required="" type="text">
                        </div>
                        <div class="mb-2">
                            <label for="satuan_id">Satuan</label>
                            <select name="satuan_id" id="satuan_id" class="form-control select2">

                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="kategori_id">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-control">

                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="brand_id">Brand</label>
                            <select name="brand_id" id="brand_id" class="form-control">

                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="harga">Harga</label>
                            <input name="harga" id="harga" class="form-control rupiah" required="" type="text">
                        </div>
                        <div class="mb-2">
                            <label for="min_stock">Minimal Stock</label>
                            <input name="min_stock" id="min_stock" class="form-control" required="" type="text">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 0 solid #e6e7e9 !important">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                    Batalkan
                                </button>
                            </div>
                            <div class="col">
                                <button type="submit" id="btnSave" class="btn btn-success w-100">
                                    <i class="bi bi-save"></i>Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
    $(document).ready(function() {
        brand();
        satuan();
        kategori();

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
                url: "barang/ajax_table",
                type: "POST",
            },
            columns: [{
                    title: "No",
                    data: 0
                },
                {
                    title: "Kode",
                    data: 2
                },
                {
                    title: "Nama",
                    data: 3
                },
                {
                    title: "Satuan",
                    data: 4
                },
                {
                    title: "Kategori",
                    data: 5
                },
                {
                    title: "Brand",
                    data: 6
                },
                {
                    title: "Harga",
                    data: 7
                },
                {
                    title: "Min Stock",
                    data: 8
                },
                {
                    title: "Aksi",
                    data: 9
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
        $('.dataTables_length').css('margin-bottom', '10px');

        $("body").on("click", "#reload", function() {
            table.draw();
        })

        $("body").on("click", "#tambah", function() {
            $('#form')[0].reset();
            $("#id").val('');
            $("#btnSave").html('<i class="bi bi-save"></i> Simpan');
            $('.modal-title').html('<h5>Tambah Data</h5>');
            $("#modal_barang").modal("show");
        })


        $("body").on('submit', '#form', function(e) {
            e.preventDefault();
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').prop('disabled', true); //set button disable 
            var id = $("#id").val();
            var url = "<?php echo base_url('barang/store') ?>";
            if (id != '') {
                url = "<?php echo base_url('barang/update') ?>";
            }
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
                        table.draw();
                        $('#form')[0].reset();
                        $('#modal_barang').modal('hide');
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




        $("body").on("click", ".edit", function() {
            var id = $(this).data("id");
            $('#form')[0].reset();
            $.ajax({
                url: "<?php echo base_url('barang/get_by_id') ?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id').val(data.id);
                    $('#nama').val(data.name);
                    $('#kode').val(data.kode);
                    // $('#brand_id').val(data.brand_id);
                    // $('#satuan_id').val(data.satuan_id);
                    // $('#kategori_id').val(data.kategori_id);
                    $('#brand_id').val(data.brand_id).trigger('change');
                    $('#satuan_id').val(data.satuan_id).trigger('change');
                    $('#kategori_id').val(data.kategori_id).trigger('change');
                    $('#harga').val(data.harga);
                    $('#min_stock').val(data.min_stock);
                    $("#btnSave").html('<i class="bi bi-save"></i> Update');
                    $('#modal_barang').modal('show');
                    $('.modal-title').text('Ubah Data');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi Kesalahan",
                        icon: "error",
                        showConfirmButton: true,
                    });
                }
            });
        })

        $("body").on("click", ".delete", function() {
            var id = $(this).data("id");
            Swal.fire({
                title: "Yakin hapus data ini?",
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo base_url('barang/delete') ?>/" + id,
                        type: "get",
                        dataType: "JSON",
                        success: function(data) {
                            if (data.success == true) {
                                table.draw();
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
                                    icon: "success",
                                    showConfirmButton: true,
                                });
                            }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                title: "Gagal!",
                                text: "Terjadi Kesalahan",
                                icon: "error",
                                showConfirmButton: true,
                            });
                        }
                    });
                }
            });
        })



    })

    function brand() {
        $.ajax({
            url: "<?php echo base_url('brand/get_all') ?>",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data.data);
                var list = '<option value="">Pilih Brand</option>';
                $.each(data.data, function(key, value) {
                    list += `<option value="${value.id}">${value.name}</option>`;
                });
                $("#brand_id").html(list);
                $("#brand_id").select2({
                    theme: 'bootstrap-5',
                    width: "100%",
                    dropdownParent: $('#modal_barang .modal_id'),
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Ambil data brand gagal!",
                    icon: "error",
                    showConfirmButton: true,
                });
            }
        });
    }

    function satuan() {
        $.ajax({
            url: "<?php echo base_url('satuan/get_all') ?>",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data.data);
                var list = '<option value="">Pilih Satuan</option>';
                $.each(data.data, function(key, value) {
                    list += `<option value="${value.id}">${value.name}</option>`;
                });
                $("#satuan_id").html(list);
                $("#satuan_id").select2({
                    theme: 'bootstrap-5',
                    width: "100%",
                    dropdownParent: $('#modal_barang .modal_id'),
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Ambil data satuan gagal!",
                    icon: "error",
                    showConfirmButton: true,
                });
            }
        });
    }

    function kategori() {
        $.ajax({
            url: "<?php echo base_url('kategori/get_all') ?>",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(data.data);
                var list = '<option value="">Pilih Kategori</option>';
                $.each(data.data, function(key, value) {
                    list += `<option value="${value.id}">${value.name}</option>`;
                });
                $("#kategori_id").html(list);
                $("#kategori_id").select2({
                    theme: 'bootstrap-5',
                    width: "100%",
                    dropdownParent: $('#modal_barang .modal_id'),
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Ambil data kategori gagal!",
                    icon: "error",
                    showConfirmButton: true,
                });
            }
        });
    }
</script>