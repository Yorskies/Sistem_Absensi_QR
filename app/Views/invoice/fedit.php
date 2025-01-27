<div class="modal fade text-left" id="editInvoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">Form Edit Invoice
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="updateInvoice" action="/updateinvoice" class="form form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $invoice->id ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <label>No Invoice</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="no_inv" value="<?= $invoice->no_inv ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Tanggal</label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="tgl" value="<?= $invoice->tgl ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Nama Customer</label>
                        </div>
                        <div class="col-md-8">
                            <select type="text" class="form-control" name="customer_id">
                                <?php foreach ($customer as $p) : ?>
                                    <option value="<?= $p->id ?>" <?= ($invoice->customer_id == $p->id) ? 'selected' : '' ?>><?= $p->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Keterangan</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="keterangan" value="<?= $invoice->keterangan ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Nominal</label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" class="form-control" name="nominal" value="<?= $invoice->nominal ?>">
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