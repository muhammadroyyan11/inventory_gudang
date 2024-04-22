<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Stock</div>
                </div>
                <div class="card-body">
                    <div class="mt-2 mb-2">
                        <!-- <button class="btn btn-primary btn-sm" id="tambah"><i class="bi bi-plus-square"></i> Tambah Data</button> -->
                        <button class="btn btn-secondary btn-sm" id="reload"><i class="bi bi-arrow-repeat"></i> Reload</button>
                    </div>
                    <div class="table-responsive">
                        <table id="datatables" class="table w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lokasi</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Satuan</th>
                                    <th>Kategori</th>
                                    <th>Brand</th>
                                    <th>Harga</th>
                                    <th>Stock</th>
                                    <th>Min Stock</th>
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
                url: "stock/ajax_table",
                type: "POST",
            },
            columns: [{
                    title: "No",
                    data: 0
                },
                {
                    title: "Lokasi",
                    data: 1
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
                    title: "Stock",
                    data: 8
                },
                {
                    title: "Min Stock",
                    data: 9
                },
                // {
                //     title: "Aksi",
                //     data: 9
                // }
            ],
            dom: '<"top"lBf>rt<"bottom"ip><"clear">',
            buttons: [{
                    extend: 'copy',
                    text: 'Copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                }
            ],

        });
        $('.dataTables_length').css('margin-bottom', '10px');

        $("body").on("click", "#reload", function() {
            table.draw();
        })

    })
</script>