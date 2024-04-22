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
                <h4 class="m-0">Detail Barang Keluar</h4>
            </div>
        </div>


        <div class="row mt-2">
            <div class="col-sm-4 col-lg-4">
                <div class="mt-2">
                    <h4 class="mt-2"><?= toko()->name ?></h4>
                    <p><?= toko()->alamat ?></p>
                </div>
            </div>
            <?php
            if ($transaksi->metode_transaksi == 'hutang') {
            ?>
                <div class="col-sm-4 col-lg-4">
                    <div class="mt-4">

                        <p class="font-13 p5"><strong>Jenis: </strong> &nbsp;&nbsp;&nbsp;
                            <span class="badge bg-warning">Hutang</span>
                        </p>
                        <p class="font-13 p5"><strong>Jatuh Tempo: </strong> &nbsp;&nbsp;&nbsp;<span><?= tglIndo($transaksi->tgl_jatuh_tempo) ?></span></p>

                    </div>
                </div>
            <?php } ?>
            <?php
            if ($transaksi->metode_transaksi == 'hutang') {
            ?>
                <div class="col-sm-4 col-lg-4">
                <?php } else { ?>
                    <div class="col-sm-4 offset-sm-4 col-lg-4 offset-lg-4">
                    <?php } ?>
                    <div class="mt-4">
                        <div class="float-sm-end">
                            <p class="font-13 p5"><strong>Tanggal: &nbsp;&nbsp;&nbsp;</strong> <span class="float-end"><?= tglIndo($transaksi->tgl) ?></span></p>
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
                            <span class="font-13"><strong>Sumber: </strong> <?=$transaksi->sumber==1?'Offline':'Online'?></span>
                        </td>
                        <td width="33%" valign="top">
                            <h5>Lokasi Gudang</h5>
                            <span class="font-13"><strong>Nama Gudang: </strong> <?= $transaksi->lokasi_name ?? '' ?></span><br>
                            <span class="font-13"><strong>Alamat: </strong> <?= $transaksi->lokasi_alamat ?? '' ?></span><br>
                            <span class="font-13"><strong>HP: </strong> <?= $transaksi->lokasi_hp ?? '' ?></span>
                        </td>
                        <td valign="top">
                            <h5>Pelanggan</h5>
                            <span class="font-13"><strong>Nama Pelanggan: </strong> <?= $transaksi->pelanggan_name ?? '' ?></span><br>
                            <span class="font-13"><strong>Alamat: </strong> <?= $transaksi->pelanggan_alamat ?? '' ?></span><br>
                            <span class="font-13"><strong>HP: </strong> <?= $transaksi->pelanggan_hp ?? '' ?></span>
                        </td>
                    </tr>
                </table>


                <div class="row">
                    <div class="col-12">
                        <table class="table-bordered table-detail mt-2" style="width: 100%; min-width: 600px;" cellpadding="2px" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th>Stock Awal</th>
                                    <th>Stock Keluar</th>
                                    <th>Stock Akhir</th>
                                    <th>Harga</th>
                                    <th>Diskon</th>
                                    <th>Total</th>
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
                                        <td align="center"><?= $d->stock_awal ?></td>
                                        <td align="center"><?= $d->jumlah ?></td>
                                        <td align="center"><?= $d->stock_akhir ?></td>
                                        <td align="right"><?= format_rupiah($d->harga) ?></td>
                                        <td align="right"><?= format_rupiah($d->diskon) ?></td>
                                        <td align="right"><?= format_rupiah(($d->harga * $d->jumlah) - $d->diskon) ?></td>
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

                    <div class="col-12 col-sm-4 col-lg-4">
                        <div class="float-end pt-1">
                            <p><b>Grand Total:</b> &nbsp;&nbsp;&nbsp;<span class="float-end">
                                    <h3><?= format_rupiah($transaksi->total) ?></h3>
                                </span></p>
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