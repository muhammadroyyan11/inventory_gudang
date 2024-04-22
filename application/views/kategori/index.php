<div class="pagetitle">
    <h1>Data Kategori</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript::void">Master</a></li>
            <li class="breadcrumb-item active">Data Kategori</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Kategori</div>
                </div>
                <div class="card-body">
                    <div class="mt-2 mb-2">
                        <button style="border-radius: 3px;" class="btn btn-primary" id="tambah"><i class="bi bi-plus-square"></i>&nbsp;&nbsp;Tambah Data</button>
                        <button style="border-radius: 3px;" class="btn btn-secondary" id="reload"><i class="bi bi-arrow-repeat"></i> Reload</button>
                    </div>
                    <div class="table-responsive">
                        <table id="datatables" class="table" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th width="10">No</th>
                                    <th width="200">Kode</th>
                                    <th>Nama</th>
                                    <th width="100">Aksi</th>
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

<div class="modal fade" id="modal_kategori" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="background:#fafbfc !important">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-tabler icon-tabler-info-square-rounded-filled text-info" width="40" height="40" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 2l.642 .005l.616 .017l.299 .013l.579 .034l.553 .046c4.687 .455 6.65 2.333 7.166 6.906l.03 .29l.046 .553l.041 .727l.006 .15l.017 .617l.005 .642l-.005 .642l-.017 .616l-.013 .299l-.034 .579l-.046 .553c-.455 4.687 -2.333 6.65 -6.906 7.166l-.29 .03l-.553 .046l-.727 .041l-.15 .006l-.617 .017l-.642 .005l-.642 -.005l-.616 -.017l-.299 -.013l-.579 -.034l-.553 -.046c-4.687 -.455 -6.65 -2.333 -7.166 -6.906l-.03 -.29l-.046 -.553l-.041 -.727l-.006 -.15l-.017 -.617l-.004 -.318v-.648l.004 -.318l.017 -.616l.013 -.299l.034 -.579l.046 -.553c.455 -4.687 2.333 -6.65 6.906 -7.166l.29 -.03l.553 -.046l.727 -.041l.15 -.006l.617 -.017c.21 -.003 .424 -.005 .642 -.005zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" stroke-width="0" fill="currentColor"></path>
                    </svg>
                    <h4 id="modal-title" class="mt-2">Data Kategori</h4>
                </div>

                <form id="form" class="form-horizontal">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">

                        <div class="mb-2">
                            <label for="kode">Kode Kategori <sup>(Optional)</sup></label>
                            <input name="kode" id="kode" class="form-control" type="text">
                        </div>
                        <div class="mb-2">
                            <label for="nama">Nama Kategori :</label>
                            <input name="nama" id="nama" class="form-control" required="" type="text">
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
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
    $(document).ready(function() {
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
                url: "kategori/ajax_table",
                type: "POST",
            },
            columns: [{
                    title: "No",
                    data: 0,
                    className: 'align-middle'
                },
                {
                    title: "Kode",
                    data: 2,
                    className: 'align-middle'
                },
                {
                    title: "Nama",
                    data: 3,
                    className: 'align-middle'
                },
                {
                    title: "Aksi",
                    data: 4,
                    className: 'dt-nowrap',
                    orderable: false
                }
            ],
            dom: '<"top"lBf>rt<"bottom"ip><"clear">',
            buttons: [{
                    extend: 'copy',
                    text: 'Copy',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        columns: [0, 1, 2]
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
            $('.modal-title').text('Tambah Data');
            $("#modal_kategori").modal("show");
        })


        $("body").on('submit', '#form', function(e) {
            e.preventDefault();
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').prop('disabled', true); //set button disable 
            var id = $("#id").val();
            var url = "<?php echo base_url('kategori/store') ?>";
            if (id != '') {
                url = "<?php echo base_url('kategori/update') ?>";
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
                        $('#modal_kategori').modal('hide');
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
            $('#loading').show(); // Tampilkan indikator loading
            $.ajax({
                url: "<?php echo base_url('kategori/get_by_id') ?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id').val(data.id);
                    $('#nama').val(data.name);
                    $('#kode').val(data.kode);
                    $("#btnSave").html('<i class="bi bi-save"></i> Update');
                    $('#modal_kategori').modal('show');
                    $('.modal-title').text('Ubah Data');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi Kesalahan",
                        icon: "error",
                        showConfirmButton: true,
                    });
                },
                complete: function() {
                    $('#loading').hide(); // Sembunyikan indikator loading setelah selesai
                }
            });
        });


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
                        url: "<?php echo base_url('kategori/delete') ?>/" + id,
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
</script>