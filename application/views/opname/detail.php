<style id="printStyle">
    .p5 {
        padding: 2px;
        margin: 2px;
    }

    th {
        text-align: center;
    }

    #printableContent {
        font-size: 14px;
    }

    @media print {

        /* Semua elemen di dalam div dengan id printableContent akan dicetak */
        #printableContent {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        /* Anda dapat menyesuaikan gaya lain sesuai kebutuhan */
        /* Misalnya, menyembunyikan tombol cetak saat mencetak */
        .d-print-none {
            display: none;
        }
    }
</style>

<div id="printableContent" class="card p-2">
    <div class="card-body">
        <!-- Invoice Logo-->
        <div class="clearfix">
            <!-- <div class="float-start">
                        <img src="{{url('image/website/'.website()->icon)?>" alt="" height="30">
                    </div> -->
            <div class="float-middle">
                <h4 class="m-0">Detail Opname Stock</h4>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6 col-lg-6">
                <div class="mt-2">
                    <h4 class="mt-2"><?= toko()->name ?></h4>
                    <p><?= toko()->alamat ?></p>
                </div>
            </div>
            <div class="col-sm-4 offset-sm-2 col-lg-4 offset-lg-2">
                <div class="mt-4">
                    <div class="float-sm-end">
                        <p class="font-13 p5"><strong>Tanggal Pelaksanaan: &nbsp;&nbsp;&nbsp;</strong> <span class="float-end"><?= tglIndo($transaksi->tgl) ?></span></p>
                        <p class="font-13 p5"><strong>No. Nota: </strong> <span class="float-end"><?= $transaksi->nota ?></span></p>
                        <p class="font-13 p5"><strong>Status: &nbsp;&nbsp;&nbsp;</strong>
                            <?php if ($transaksi->status == 1) {
                                echo '<span class="badge bg-success float-end">Selesai</span>';
                            } elseif ($transaksi->status == 2) {
                                echo '<span class="badge bg-primary float-end">Proses</span>';
                            } ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <table width="100%" cellpadding="10px" border="0">
            <tr>
                <td width="33%" valign="top">
                    <h5>Informasi</h5>
                    <span class="font-13"><strong>Tuan Toko: </strong> <?= toko()->pemilik ?? '' ?></span><br>
                    <span class="font-13"><strong>Admin: </strong> <?= $transaksi->user_name ?? '' ?></span><br>
                    <span class="font-13"><strong>Bulan: </strong> <?= blnIndo($transaksi->bulan) ?> <?= $transaksi->tahun ?></span>
                </td>
                <td width="33%" valign="top">
                    <h5>Lokasi Gudang</h5>
                    <span class="font-13"><strong>Nama Gudang: </strong> <?= $transaksi->lokasi_name ?? '' ?></span><br>
                    <span class="font-13"><strong>Alamat: </strong> <?= $transaksi->lokasi_alamat ?? '' ?></span><br>
                    <span class="font-13"><strong>HP: </strong> <?= $transaksi->lokasi_hp ?? '' ?></span>
                </td>

            </tr>
        </table>


        <div class="row">
            <div class="col-12">
                <table class="table-bordered mt-2 table-detail" style="width: 100%; min-width: 600px;" cellpadding="2px" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Stock Sistem</th>
                            <th>Stock Real</th>
                            <th>Selisih</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($detail as $d) {
                        ?>
                            <tr>
                                <td align="center"><?= $no ?></td>
                                <td><?= $d->barang_kode ?></td>
                                <td><?= $d->barang_name ?></td>
                                <td><?= $d->kategori_name ?></td>
                                <td><?= $d->satuan_name ?></td>
                                <td align="right"><?= format_rupiah($d->harga) ?></td>
                                <td align="center"><?= $d->stock_sistem ?></td>
                                <td align="center"><?= $d->stock_real ?></td>
                                <td align="center"><?= $d->selisih ?></td>
                                <td><?= $d->keterangan ?></td>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div> <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row mt-2">
            <div class="col-12 col-sm-8 col-lg-8">
                <div class="clearfix pt-1">
                    <h6 class="text-muted">Keterangan:</h6>
                    <small>
                        <?= htmlspecialchars($d->keterangan) ?>
                    </small>
                </div>
            </div> <!-- end col -->


        </div>
        <!-- end row-->

        <div class="d-print-none mt-4">
            <div class="text-end">
                <button onclick="window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i> Print</button>
            </div>
        </div>
        <!-- end buttons -->

    </div> <!-- end card-body-->
</div> <!-- end card -->

<script>
    
</script>