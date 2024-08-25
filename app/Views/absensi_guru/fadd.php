<div class="modal fade text-left" id="tambahAbsensi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">Form Tambah Absensi</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="simpanAbsensi" action="/guru/absensi/tambah" method="post" class="form form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Nama Siswa</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="siswa_nis" required>
                                <option value="" disabled selected>Pilih Siswa</option>
                                <?php foreach ($siswa as $siswaItem): ?>
                                    <option value="<?= $siswaItem->nomor_induk ?>"><?= $siswaItem->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label>Status</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="status" required>
                                <option value="Hadir">Hadir</option>
                                <option value="Absen">Absen</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                            </select>
                            <div class="invalid-feedback"></div>
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
                        <span class="d-none d-sm-block">Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
