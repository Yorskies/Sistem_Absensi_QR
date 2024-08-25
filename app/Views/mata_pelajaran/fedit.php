<div class="modal fade text-left" id="editMapel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">Form Edit Mata Pelajaran</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="updateMapel" action="<?= site_url('mata-pelajaran/update') ?>" method="post" class="form form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id" value="<?= $mataPelajaran->id ?>">
                        <div class="col-md-4">
                            <label>Nama Mata Pelajaran</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nama" value="<?= $mataPelajaran->nama ?>">
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
                        <span class="d-none d-sm-block">Update</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
