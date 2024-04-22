<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Profil</div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('user/update_profil') ?>" method="post">
                        <input type="hidden" name="id" value="<?= $user->id ?>">
                        <!-- <div class="row mb-3">
                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Icon Toko</label>
                            <div class="col-md-8 col-lg-9">
                                <img style="max-width: 100px;" src="<?= base_url('assets/toko/') ?>" alt="">
                                <div class="pt-2">
                                    <input type="file" name="file" id="file" class="form-control">
                                </div>
                            </div>
                        </div> -->

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="name" type="text" class="form-control" id="name" value="<?= $user->name ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="email" type="text" class="form-control" id="email" value="<?= $user->email ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hp" class="col-md-4 col-lg-3 col-form-label">No. HP</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="hp" type="text" class="form-control" id="hp" value="<?= $user->hp ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="username" type="text" class="form-control" id="username" value="<?= $user->username ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                        <span class="text-info"><small>Abaikan jika tidak ingin merubah password</small></span>
                        </div>
                       
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-lg-3 col-form-label">Password</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="password" type="password" class="form-control" id="password" value="">
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