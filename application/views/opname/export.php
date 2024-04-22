<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= toko()->name ?></title>
    <style>
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
</head>

<body>

    <div id="printableContent" class="card p-2">

        <h3>Detail Opname Stock <?= blnIndo($transaksi->bulan) ?> <?= $transaksi->tahun ?></h3>
       
        <hr>

        <table style="width: 100%;">
            <tr>
                <td width="50%" valign="top">
                    <h4 class="mt-2"><?= toko()->name ?></h4>
                    <p><?= toko()->alamat ?></p>
                </td>
                <td align="right" valign="top">
                    <br>
                    <br>
                    <p class="font-13 p5"><strong>Tanggal Pelaksanaan: &nbsp;&nbsp;&nbsp;</strong> <span class="float-end"><?= tglIndo($transaksi->tgl) ?></span></p>
                    <p class="font-13 p5"><strong>No. Nota: </strong> <span class="float-end"><?= $transaksi->nota ?></span></p>
                    <p class="font-13 p5"><strong>Status: &nbsp;&nbsp;&nbsp;</strong>
                        <?php if ($transaksi->status == 1) {
                            echo '<span class="badge bg-success float-end">Selesai</span>';
                        } elseif ($transaksi->status == 2) {
                            echo '<span class="badge bg-primary float-end">Proses</span>';
                        } ?>
                    </p>
                </td>
            </tr>
        </table>
        <br>
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

        <br>
        <table class="table-detail" style="width: 100%; min-width: 600px;" cellpadding="4px" cellspacing="0" border="1">
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


        <h6 class="text-muted">Keterangan:</h6>
        <small>
            <?= htmlspecialchars($d->keterangan) ?>
        </small>


</body>

</html>