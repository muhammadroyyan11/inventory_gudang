<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Input Barang Return</div>
                </div>
                <div class="card-body mt-4">
                    <form id="form-cart">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-lg-12">
                                <div class="row">

                                    <div class="col-6 col-sm-6 col-lg-6">
                                        <div class="mb-2">
                                            <label for="tgl">Tanggal <span style="color: red;">*</span></label>
                                            <input name="tgl" class="form-control form-control-sm" required id="tgl" type="date" value="<?= date('Y-m-d') ?>" name="tgl">
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-6 col-lg-6">
                                        <div class="mb-2">
                                            <label for="nota">No. Nota</label>
                                            <input class="form-control form-control-sm" id="nota" type="text" name="nota" placeholder="Auto">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-6">
                                        <div class="mb-2">
                                            <label for="ref_id" class="control-label">Nota Referensi<span style="color: red;">*</span></label>
                                            <select id="ref_id" name="ref_id" required class="form-control form-control-sm form-control form-control-sm-sm select2">
                                                <option value="">Pilih Nota</option>
                                                <?php
                                                foreach ($referensi as $ref) {
                                                    echo '<option value="' . $ref->id . '">' . $ref->nota . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-6">
                                        <div class="mb-2">
                                            <label for="gudang" class="control-label">Lokasi Gudang <span style="color: red;">*</span></label>
                                            <select id="gudang" name="gudang" required class="form-control form-control-sm form-control form-control-sm-sm select2">
                                                <option value="">Pilih Lokasi Gudang</option>
                                                <?php
                                                foreach ($lokasi as $gudang) {
                                                    echo '<option value="' . $gudang->id . '">' . $gudang->name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-lg-6">
                                        <div class="mb-2">
                                            <label for="pelanggan" class="control-label">Pelanggan</label>
                                            <select id="pelanggan" name="pelanggan" required class="form-control form-control-sm">
                                                <option value="0">Umum</option>
                                                <?php
                                                foreach ($pelanggan as $spl) {
                                                    echo '<option value="' . $spl->id . '">' . $spl->name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-4 d-none">
                                        <div class="mb-2">
                                            <label for="">Jenis Pembelian <span style="color: red;">*</span></label>
                                            <select name="metode_transaksi" id="metode_transaksi" required class="form-control form-control-sm">
                                                <option value="tunai">Tunai</option>
                                                <option value="hutang">Hutang</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-4 tgl_jatuh_tempo" style="display:none">
                                        <div class="mb-2">
                                            <label for="tgl_jatuh_tempo">Tanggal Jatuh Tempo <span style="color: red;">*</span></label>
                                            <input class="form-control form-control-sm" id="tgl_jatuh_tempo" type="date" name="tgl_jatuh_tempo">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-4 d-none">
                                        <div class="mb-2">
                                            <label for="">Sumber <span style="color: red;">*</span></label>
                                            <select name="sumber" id="sumber" required class="form-control form-control-sm">
                                                <option value="1">Offline</option>
                                                <option value="2">Online</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-sm-12 col-lg-12">
                                <label for="produk">Cari Produk</label>
                                <select name="produk" id="produk" class="form-control form-control-sm">
                                    <option value="">Cari Produk</option>
                                    <?php
                                    foreach ($barang as $brg) {
                                        echo '<option value="' . $brg->id . '">' . $brg->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-12">
                                <div class="table-responsive mt-2">
                                    <table class="table table-centered table-sm table-bordered" style="min-width: 600px;">
                                        <thead>
                                            <tr>
                                                <td align="center">No</td>
                                                <td align="center">Barang</td>
                                                <td align="center">Satuan</td>
                                                <td align="center">Stock</td>
                                                <td align="center">Harga</td>
                                                <td align="center">Jumlah</td>
                                                <td align="center">Diskon</td>
                                                <td align="center">Total</td>
                                                <td align="center">Kondisi</td>
                                                <td align="center">Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody id="carttable">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-lg-6">
                                <div class="mb-2">
                                    <label for="deskripsi">Keterangan</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control form-control-sm"></textarea>
                                </div>


                            </div>
                            <div class="col-12 col-sm-12 col-lg-6">
                                <div class="mt-2 mb-2">
                                    <h3 style="margin-bottom: 10px;">Grand Total : &nbsp;&nbsp;<span class="float-end" id="cart-total">Rp 0</span></h3>
                                    <i><span class="terbilang-total float-end"></span></i><br>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <label for="bayar">Jumlah Bayar</label>
                                        <input type="text" name="bayar" id="bayar" value="0" class="form-control rupiah font-24 fw-bold alert alert-primary bg-white text-primary" autocomplete="off">
                                        <span class="status-bayar"></span>
                                        <i><span class="terbilang-bayar float-end"></span></i><br>
                                        <label for="kembalian">Kembalian</label>
                                        <input type="text" name="kembalian" id="kembalian" readonly value="0" min="0" class="form-control rupiah font-18 alert alert-success bg-white text-success">
                                        <i><span class="terbilang-kembalian float-end"></span></i>
                                    </div>
                                    <div class="col-12">
                                        <div class="float-end mt-2">
                                            <button type="button" class="btn btn-primary mb-2 me-2" data-cetak="false" id="saveBtn">Simpan</button>
                                            <button type="button" id="batal" class="btn btn-danger mb-2 me-2">Reset</button>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                </div>
                <input type="hidden" name="id" id="id">
                <input type="hidden" readonly name="total" id="input-total" value="0">
                <input type="hidden" readonly name="sub_total" id="input-sub-total" value="0">
                </form>
            </div>
        </div>
    </div>
    </div>
</section>


<script>
    const formatRupiah = (money) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(money).replace('Rp', 'Rp.');
    }

    $(document).ready(function() {
        clear();
        hitung();

        $(document).on('click', '#saveBtn', function(e) {
            e.preventDefault();
            var lokasi = $("#gudang").val();
            if (validasiLokasi(lokasi)) {
                Swal.fire({
                    title: "Peringatan!",
                    text: 'Lokasi gudang harus sama',
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1000
                });
                return;
            }
            var myurl = "<?= base_url('BarangReturn/store') ?>";
            var form = $('#form-cart')[0];
            var formData = new FormData(form);
            $.ajax({
                data: formData,
                url: myurl,
                type: "POST",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.success == true) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: data.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        clear();
                        allData();

                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: data.message,
                            icon: "error",
                            showConfirmButton: true,
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Gagal!",
                        text: 'Terjadi kesalah, Simpan gagal!',
                        icon: "error",
                        showConfirmButton: true,
                    });
                }
            });

        });

        $("body").on("click", "#batal", function() {
            clear();
        })


        $("body").on("change", "#ref_id", function() {
            var id = $(this).val();
            if(id==''){
                $('#gudang').val('').trigger('change');
                    $('#pelanggan').val('').trigger('change');
                    $("#sumber").val('');
                    $("#metode_transaksi").val('tunai');
                    $("#tgl_jatuh_tempo").val('');
                    return;
            }
            $.ajax({
                url: "<?php echo base_url('keluar/get_by_id') ?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#gudang').val(data.lokasi_id).trigger('change');
                    $('#pelanggan').val(data.pelanggan_id).trigger('change');
                    $("#sumber").val(data.sumber);
                    $("#metode_transaksi").val(data.metode_transaksi);
                    $("#tgl_jatuh_tempo").val(data.tgl_jatuh_tempo);
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

        $("body").on('change', '#metode_transaksi', function() {
            var metode = $(this).val();
            if (metode === 'hutang') {
                $(".tgl_jatuh_tempo").css('display', 'block');
                $("#bayar").val(0);
                $("#kembalian").val(0);
                $("#bayar").attr('readonly', 'readonly');
            } else {
                $(".tgl_jatuh_tempo").css('display', 'none');
                $("#bayar").removeAttr('readonly');
            }
        })

        $("body").on("keyup change focusout", "#input-total,#bayar", function() {
            var bayar = $("#bayar").val();
            var total = $("#input-total").val();
            var kembalian = 0;
            bayar = bayar.replace(/\./g, '');
            total = total.replace(/\./g, '');
            kembalian = Number(bayar - total);
            if (kembalian < 0) {
                kembalian = 0;
            }
            $("#kembalian").val(formatRupiah(kembalian));

        })

        $("body").on("change", "#produk", function() {
            var lokasi_id = $("#gudang").val();
            var produk_id = $("#produk").val();
            if (produk_id == '') {
                return;
            }
            if (lokasi_id == '') {
                Swal.fire({
                    title: "Gagal!",
                    text: 'Silahkan pilih Lokasi Gudang',
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1000
                });
                document.getElementById("produk").selectedIndex = -1;
                return;
            }

            getProdukLokasi(lokasi_id, produk_id);
        })

        $("#produk").select2({});
        $("#gudang").select2({});
        $("#pelanggan").select2({});
        $("#ref_id").select2({});

        $("body").on("change", "#jumlah", function() {
            var jml = $(this).val()
            var id = $(this).data('id');
            console.log(id);
            updateQuantity(id, jml);
            hitung();
        })

        $("body").on("change", "#diskon", function() {
            var diskon = $(this).val()
            var id = $(this).data('id');
            updateDiskon(id, diskon);
            hitung();
        })

        $("body").on("change", ".kondisi", function() {
            var kondisi = $(this).val()
            var id = $(this).data('id');
            updateKondisi(id, kondisi);
            hitung();
        })

        $("body").on("change", "#cart-input-harga", function() {
            var id = $(this).data('id');
            var harga = $(this).val();
            harga = harga.replace(/\./g, '');
            let product = JSON.parse(localStorage.getItem("products")) ?? [];
            let cart = JSON.parse(localStorage.getItem("cart")) ?? [];
            for (let product of cart) {
                if (product.id == id) {
                    product.harga = harga;
                }
            }
            localStorage.setItem("cart", JSON.stringify(cart));
            $.NotificationApp.send("Berhasil", 'Harga Diperbarui', "top-right", "",
                "success")
            hitung();
        })





    })
    //end document ready function

    function getProdukLokasi(lokasi, id) {
        var url = "<?= base_url('BarangReturn/getProdukLokasi') ?>?lokasi=" + lokasi + "&barang=" + id;
        $.ajax({
            type: "get",
            url: url,
            dataType: 'json',
            success: function(data) {
                if (data.success === true) {
                    data = data.data;
                    if (validasiLokasi(lokasi)) {
                        Swal.fire({
                            title: "Peringatan!",
                            text: 'Lokasi gudang harus sama',
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        return;
                    }

                    addItemToCart(data.barang_id, lokasi, data.barang_kode, data.barang_name, data.satuan_name, data.harga, data.stock, 1, 0, data.min_stock, '');
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: data.message,
                        icon: "error",
                        showConfirmButton: true,
                    });
                }
            },
            error: function(data) {
                Swal.fire({
                    title: "Gagal!",
                    text: 'Gagal ambil data',
                    icon: "error",
                    showConfirmButton: true,
                });
            }
        });
    }


    function hitung() {

        allData();
        var subtotal = $("#input-sub-total").val();
        var total = subtotal;
        $("#cart-total").html(formatRupiah(total));
        var metode_transaksi = $("#metode_transaksi").val();
        if (metode_transaksi == 'tunai') {
            $("#bayar").val(formatRupiah(total));
        } else {
            $("#bayar").val(0);
        }
        $("#input-total").val(total)
    }

    function allData() {
        $("#carttable").html('');
        cartList = JSON.parse(localStorage.getItem('cart')) ?? []
        cartList.forEach(function(value, i) {
            html = document.getElementById('carttable')


            html.innerHTML += `
                    <tr>
                        <td align="center">${i+1}
                        <input type="hidden" name="barang_id[]" id="cart-input-barang_id" value="${value.id}" readonly>
                        <input type="hidden" name="lokasi_id[]" id="cart-input-lokasi_id" value="${value.lokasi_id}" readonly>
                        <input type="hidden" name="harga[]" id="cart-input-harga" value="${value.harga}" readonly>
                        </td>
                        <td>${value.kode} - ${value.nama}</td>
                        <td align="left">${value.satuan}</td>
                        <td align="center">${value.stock}</td>
                        <td align="right">${formatRupiah(value.harga)}</td>
                        <td align="center"><input type="number" name="jumlah[]" id="jumlah" min="1" data-id="${value.id}" value="${value.jumlah}" style="width:60px"></td>
                        <td align="center"><input type="number" name="diskon[]" id="diskon" min="0" data-id="${value.id}" value="${value.diskon}" style="width:100px"></td>
                        <td align="center">${formatRupiah(value.total)}</td>
                        <td align="center">
                        <select name="kondisi[]" class="kondisi" data-id="${value.id}">
                            <option ${value.kondisi == 2 ? 'selected' : ''} value="2">Rusak</option>
                            <option ${value.kondisi == 1 ? 'selected' : ''} value="1">Baik</option>
                        </select></td>
                        <td><div class="text-center"><a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="removeItemFromCart(${value.id})">
                            <i class="bi bi-trash"></i>
                            </a></div>
                        </td>
                    </tr>`;
        })
        getTotal();
    }

    function getTotal() {
        let cart = JSON.parse(localStorage.getItem("cart")) ?? [];
        let temp = cart.map(function(item) {
            return parseInt(item.total);
        })

        let sum = temp.reduce(function(prev, next) {
            return prev + next;
        }, 0);
        $("#info-sub-total").html(formatRupiah(sum))
        $("#input-sub-total").val(sum)
    }

    // ADDING A PRODUCT IN THE CART
    function addItemToCart(barang_id, lokasi_id, kode, barang, satuan = '', harga = 0, stock = 0, jumlah = 0, diskon = 0, min_stock = 0, kondisi) {
        var id = barang_id;
        var item = {
            id: barang_id,
            lokasi_id: lokasi_id,
            kode: kode,
            nama: barang,
            satuan: satuan,
            harga: harga,
            jumlah: jumlah,
            stock: stock,
            diskon: diskon,
            min_stock: min_stock,
            kondisi: kondisi,
            total: (parseFloat(harga) * parseInt(jumlah)) - parseFloat(diskon)
        }
        let products = JSON.parse(localStorage.getItem("products")) ?? [];
        let cart = JSON.parse(localStorage.getItem("cart")) ?? [];
        let product = products.find(function(product) {
            return product.id == id;
        });

        if (cart.length == 0) {
            cart.push(item);

        } else {
            let res = cart.find(element => element.id == id);
            if (res === undefined) {
                cart.push(item);
                // Swal.fire({
                //     title: "Berhasil!",
                //     text: 'Barang ditambahkan ke keranjang',
                //     icon: "success",
                //     showConfirmButton: false,
                //     timer: 1000
                // });
            } else {
                updateQuantityPlus(id, 1);
                Swal.fire({
                    title: "Berhasil!",
                    text: 'Jumlah ditambahkan',
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1000
                });
                hitung();
                return true;

            }
        }

        localStorage.setItem("cart", JSON.stringify(cart));
        hitung();
    }


    function validasiLokasi(inputLokasi) {
        let product = JSON.parse(localStorage.getItem("products")) ?? [];
        let cart = JSON.parse(localStorage.getItem("cart")) ?? [];
        for (let product of cart) {
            if (product.lokasi_id != inputLokasi) {
                return 1;
            }
        }
    }


    // REMOVING A PRODUCT FROM THE CART
    function removeItemFromCart(id) {
        let cart = JSON.parse(localStorage.getItem("cart")) ?? [];
        let temp = cart.filter(item => item.id != id);
        localStorage.setItem("cart", JSON.stringify(temp));
        hitung();
    }



    function updateQuantity(id, jumlah) {
        let product = JSON.parse(localStorage.getItem("products")) ?? [];
        let cart = JSON.parse(localStorage.getItem("cart")) ?? [];
        for (let product of cart) {
            if (product.id == id) {
                product.jumlah = jumlah;
                product.total = (parseFloat(clearRupiah(product.harga)) * parseInt(jumlah)) - parseFloat(product.diskon);
            }
        }
        localStorage.setItem("cart", JSON.stringify(cart));

    }
    // updateQuantity(1, 8);

    function updateQuantityPlus(id, jumlah) {
        let product = JSON.parse(localStorage.getItem("products")) ?? [];
        let cart = JSON.parse(localStorage.getItem("cart")) ?? [];
        for (let product of cart) {
            if (product.id == id) {
                var jumlah = Number(product.jumlah) + 1;
                product.jumlah = jumlah;
                product.total = (parseFloat(clearRupiah(product.harga)) * parseInt(jumlah)) - parseFloat(product.diskon);
            }
        }
        localStorage.setItem("cart", JSON.stringify(cart));

    }

    function updateDiskon(id, diskon) {
        let product = JSON.parse(localStorage.getItem("products")) ?? [];
        let cart = JSON.parse(localStorage.getItem("cart")) ?? [];
        for (let product of cart) {
            if (product.id == id) {
                if (parseFloat(diskon) > product.total) {
                    Swal.fire({
                        title: "Gagal!",
                        text: 'Diskon tidak boleh lebih besar dari Total',
                        icon: "error",
                        showConfirmButton: true
                    });
                    return;
                }
                product.diskon = diskon;
                product.total = (parseFloat(clearRupiah(product.harga)) * parseInt(product.jumlah)) - parseFloat(diskon);
            }
        }
        localStorage.setItem("cart", JSON.stringify(cart));

    }

    function updateKondisi(id, kondisi) {
        let product = JSON.parse(localStorage.getItem("products")) ?? [];
        let cart = JSON.parse(localStorage.getItem("cart")) ?? [];
        for (let product of cart) {
            if (product.id == id) {
                product.kondisi = kondisi;
                console.log(kondisi)
            }
        }
        localStorage.setItem("cart", JSON.stringify(cart));

    }



    function clear() {
        localStorage.removeItem('products')
        localStorage.removeItem('cart')
        $("#form-cart").trigger('reset');
        $("#id").val('');
        $("#deskripsi").val('');
        var today = new Date().toISOString().slice(0, 10);
        $("#tgl").val(today);
        hitung();
    }
</script>