<div class="modal fade text-left" id="tambahCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">Form Tambah Data Siswa
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="simpanCustomer" action="/simpancustomer" method="post" class="form form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Nomor Induk</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nama">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Nama</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="alamat">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Kelas</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="telp">
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