<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Pengaturan Toko</div>
                </div>
                <div class="card-body">
                    <form action="<?=base_url('pengaturan/update')?>" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="id" value="<?=$setting->id?>">
                        <div class="row mb-3">
                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Icon Toko</label>
                            <div class="col-md-8 col-lg-9">
                                <img style="max-width: 100px;" src="<?=base_url('assets/toko/'.$setting->file)?>" alt="">
                                <div class="pt-2">
                                    <input type="file" name="file" id="file" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-lg-3 col-form-label">Nama Toko</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="name" type="text" class="form-control" id="name" value="<?=$setting->name?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="pemilik" class="col-md-4 col-lg-3 col-form-label">Pemilik Toko</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="pemilik" type="text" class="form-control" id="pemilik" value="<?=$setting->pemilik?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hp" class="col-md-4 col-lg-3 col-form-label">No. HP</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="hp" type="text" class="form-control" id="hp" value="<?=$setting->hp?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                            <div class="col-md-8 col-lg-9">
                                <textarea name="alamat" id="alamat" class="form-control"><?=$setting->alamat?></textarea>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form><!-- End Profile Edit Form -->
                </div>
            </div>
        </div>
    </div>
</section>