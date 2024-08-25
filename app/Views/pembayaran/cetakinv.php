<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Gaji Karyawan</title>

    <link rel="stylesheet" href="/assets/css/main/app.css">
    <link rel="stylesheet" href="/assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="/assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/images/logo/favicon.png" type="image/png">

    <link rel="stylesheet" href="/assets/css/pages/fontawesome.css">
    <style>
        @media print {

            button.btn.btn-sm.btn-danger,
            .card-footer,
            footer.main-footer,
            .card-header,
            button.btn.btn-secondary.shadow.mb-3,
            input.form-control.form-control-sm,
            #example1_info.dataTables_info,
            ul.pagination {
                display: none;
            }
        }
    </style>

</head>

<body class="fw-bold">
    <div class="container-fluid mt-2">
        <div class="card">
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-3">
                        <img src="/assets/images/logo/logo19.png" alt="" width="125px">
                    </div>
                    <div class="col-9 text-end">
                        <h4>INVOICE / TAGIHAN</h4>
                        <small>
                            PT Fisio Terapi Indonesia <br />
                        </small>
                        <small>
                            Jl. Hasanudin No 105 Bandung, Jawa Barat 80116 <br />
                            Indonesia <br />
                        </small>
                        <small>
                            Telp/WA : 0812345678 <br />
                            Email : sales@mail.com <br />
                        </small>
                    </div>
                </div>
                <hr class="text-success">
                <div class="row">
                    <div class="col-7">
                        <h6>BILL TO</h6>
                        <small><?= $datainv->nama_customer ?></small><br />
                        <small><?= $datainv->alamat_customer ?></small><br />
                        <small><?= $datainv->telp_customer ?> </small><br />
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col-5 text-end">
                                <small>Number</small>
                            </div>
                            <div class="col-7">
                                <small>: <?= $datainv->no_inv ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 text-end">
                                <small>Invoice Date</small>
                            </div>
                            <div class="col-7">
                                <small>: <?= date('d-M-Y', strtotime($datainv->tgl)) ?></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 text-end">
                                <small>Payment Due</small>
                            </div>
                            <div class="col-7">
                                <small>: </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 text-end">
                                <small>Amount Due</small>
                            </div>
                            <div class="col-7">
                                <small>: </small>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="mt-4" width="100%">
                    <thead>
                        <tr>
                            <th class="ps-2">No </th>
                            <th>Keterangan </th>
                            <th>Diskon</th>
                            <th class="text-end pe-2">Harga</th>
                            <th class="text-end pe-2">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-2">1. </td>
                            <td><?= $datainv->keterangan ?> </td>
                            <td> 0,00 </td>
                            <td class="text-end pe-2"><?= number_format($datainv->nominal, 0, ',', '.') ?> </td>
                            <td class="text-end pe-2"><?= number_format($datainv->nominal, 0, ',', '.') ?> </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">SUBTOTAL </td>
                            <td class="text-end pe-2"><?= number_format($datainv->nominal, 0, ',', '.') ?> </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">TOTAL </td>
                            <td class="text-end pe-2"><?= number_format($datainv->nominal, 0, ',', '.') ?> </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row ps-2 mt-4">
                    <div class="col">
                        DETIL PEMBAYARAN
                    </div>
                </div>
                <div class="row ps-2 mt-4">
                    <div class="col-3">
                        NAMA BANK
                    </div>
                    <div class="col-9">
                        : BCA
                    </div>
                    <div class="col-3">
                        NO REKENING
                    </div>
                    <div class="col-9">
                        : 1234678
                    </div>
                    <div class="col-3">
                        NAMA
                    </div>
                    <div class="col-9">
                        : NAMA AKUN REKENING
                    </div>
                </div>
                <div class="row mt-3 ps-2">
                    <div class="col">
                        <button class="btn btn-sm btn-danger justify-content-end" onclick="window.print()">
                            <i class=" bi bi-printer me-2"></i>Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>