<div class="pagetitle">
    <h1>Input Barang Masuk</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript::void">Barang Masuk</a></li>
            <li class="breadcrumb-item active">Input</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Input Barang Masuk</div>
                </div>
                <div class="card-body mt-4">
                    <form id="form-cart">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-lg-12">
                                <div class="row">

                                    <div class="col-6 col-sm-6 col-lg-6">
                                        <div class="mb-2">
                                            <label for="tgl">Tanggal <span style="color: red;">*</span></label>
                                            <input name="tgl" class="form-control" required id="tgl" type="datetime-local" value="<?= date('Y-m-d\TH:i') ?>" name="tgl">
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-6 col-lg-6">
                                        <div class="mb-2">
                                            <label for="nota">No. Nota</label>
                                            <input class="form-control" id="nota" type="text" name="nota" placeholder="Auto">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-lg-6">
                                        <div class="mb-2">
                                            <label for="gudang" class="control-label">Lokasi Gudang <span style="color: red;">*</span></label>
                                            <select id="gudang" name="gudang" required class="form-control select2">
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
                                            <label for="supplier" class="control-label">Supplier</label>
                                            <select id="supplier" name="supplier" required class="form-control">
                                                <option value="0">Umum</option>
                                                <?php
                                                foreach ($supplier as $spl) {
                                                    echo '<option value="' . $spl->id . '">' . $spl->name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="col-12 col-sm-12 col-lg-12">
                                <label for="produk">Cari Produk</label>
                                <select name="produk" id="produk" class="form-control">
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
                                                <td align="center">Harga</td>
                                                <td align="center">Stock</td>
                                                <td align="center">Jumlah Masuk</td>
                                                <td align="center">Total Stock</td>
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
                                    <textarea rows="5" name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukan Keterangan Disini..."></textarea>
                                </div>


                            </div>
                            <div class="col-12 col-sm-12 col-lg-6">

                                <div class="row mb-2">
                                    <div class="col-12">
                                        <div class="float-end mt-2">
                                            <button style="border-radius: 0px;" type="button" class="btn btn-primary mb-2 me-2" data-cetak="false" id="saveBtn"><i class="bi bi-save-fill"></i> Simpan Data</button>
                                            <button style="border-radius: 0px;" type="button" id="batal" class="btn btn-danger mb-2 me-2">Reset</button>
                                        </div>
                                    </div>
                                </div>


                            </div>


                        </div>
                </div>
                <input type="hidden" name="id" id="id">
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

    $("#gudang").on("change", function() {
        var id = $(this).val();
        var gudang = $(this).find("option:selected").text();
        if (gudang) {
            Swal.fire({
                title: "Konfirmasi",
                text: "Apakah Anda yakin ingin menginputkan ke " + gudang + "?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya",
                cancelButtonText: "Batalkan",
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#gudang").prop("disabled", true);
                } else {
                    $(this).val('').trigger('change.select2');
                }
            });
        }
    });

    $(document).ready(function() {
        clear();
        hitung();

        $(document).on('click', '#saveBtn', function(e) {

            $("#gudang").prop("disabled", false);
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
            var myurl = "<?= base_url('masuk/store') ?>";
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
                        $("#gudang").prop("disabled", true);
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





        $("#produk").select2({
            theme: 'bootstrap-5'
        });
        $("#gudang").select2({
            theme: 'bootstrap-5'
        });
        $("#supplier").select2({
            theme: 'bootstrap-5'
        });




        $("body").on("change", "#jumlah", function() {
            var jml = $(this).val()
            var id = $(this).data('id');
            console.log(id);
            updateQuantity(id, jml);
            allData();
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
        var url = "<?= base_url('masuk/getProdukLokasi') ?>?lokasi=" + lokasi + "&barang=" + id;
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

                    addItemToCart(data.barang_id, lokasi, data.barang_kode, data.barang_name, data.satuan_name, data.harga, data.stock, 1);
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
    }

    function allData() {
        $("#carttable").html('');
        cartList = JSON.parse(localStorage.getItem('cart')) ?? [];
        if (cartList.length === 0) {
            $("#carttable").html('<tr><td colspan="8" align="center">Data tidak tersedia</td></tr>');
        } else {
            cartList.forEach(function(value, i) {
                html = document.getElementById('carttable');
                html.innerHTML += `
                    <tr>
                        <td align="center">${i+1}
                            <input type="hidden" name="barang_id[]" id="cart-input-barang_id" value="${value.id}" readonly>
                            <input type="hidden" name="lokasi_id[]" id="cart-input-lokasi_id" value="${value.lokasi_id}" readonly>
                            <input type="hidden" name="harga[]" id="cart-input-harga" value="${value.harga}" readonly>
                        </td>
                        <td>${value.kode} - ${value.nama}</td>
                        <td align="left">${value.satuan}</td>
                        <td align="right">${formatRupiah(value.harga)}</td>
                        <td align="center">${value.stock}</td>
                        <td align="center"><input class='form-control' type="number" name="jumlah[]" id="jumlah" min="1" data-id="${value.id}" value="${value.jumlah}" style="width:60px"></td>
                        <td align="center">${value.total}</td>
                        <td>
                            <div class="text-center"><a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="removeItemFromCart(${value.id})">
                                <i class="bi bi-trash"></i>
                            </a></div>
                        </td>
                    </tr>`;
            });
        }
    }

    // ADDING A PRODUCT IN THE CART
    function addItemToCart(barang_id, lokasi_id, kode, barang, satuan = '', harga = 0, stock = 0, jumlah = 0) {
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
            total: parseInt(stock) + parseInt(jumlah)
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
                product.total = parseInt(product.stock) + parseInt(jumlah);
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
                product.total = parseInt(product.stock) + parseInt(jumlah);
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