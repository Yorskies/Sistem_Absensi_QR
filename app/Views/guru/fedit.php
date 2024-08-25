<div class="modal fade text-left" id="editGuru" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">Form Edit Data Guru</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="updateGuru" action="/guru/update" method="post" class="form form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id" value="<?= $guru->id ?>">
                        <div class="col-md-4">
                            <label>Nomor Induk</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nomor_induk" value="<?= $guru->nomor_induk ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Nama</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nama" value="<?= $guru->nama ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Mata Pelajaran</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="mata_pelajaran">
                                <?php foreach ($mataPelajaran as $mp): ?>
                                    <option value="<?= $mp->id ?>" <?= $guru->mata_pelajaran == $mp->id ? 'selected' : '' ?>>
                                        <?= $mp->nama ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Status</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="status">
                                <option value="Aktif" <?= $guru->status == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="Tidak Aktif" <?= $guru->status == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Username</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="username" value="<?= $guru->username ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Password</label>
                        </div>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="password" value="">
                            <div class="invalid-feedback"></div>
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Update</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
