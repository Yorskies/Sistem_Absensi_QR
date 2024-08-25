<?php $session = \Config\Services::session() ?>
<?php $this->extend('share_pages/layout') ?>
<?php $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header text-end">
            <h4><?= $title ?></h4>
        </div>
        <div class="card-body">
            <button class="btn btn-primary mb-4">Tambah Data Guru</button>
            <!-- onclick="tambahInvoice() -->
            <div class="table-responsive">
                <table class="table table-striped mt-3" id="table1">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th>No </th>
                            <th>NIP</th>
                            <th>Nama Guru</th>
                            <th>Mata Pelajaran </th>
                            <th>Keterangan</th>
                            <th>Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($invoice as $p) : ?>
                            <tr>
                                <td><?= $no++ ?> </td>
                                <td><?= $p->no_inv ?> </td>
                                <td><?= date('d-M-Y', strtotime($p->tgl)) ?> </td>
                                <td><?= $p->nama_customer ?> </td>
                                <td>
                                    <?php if ($p->status == 'Lunas') {
                                        $color = 'bg-success';
                                        $status = 'Aktif';
                                    } else {
                                        $color = 'bg-warning';
                                        $status = 'Cuti';
                                    } ?>
                                    <span class="badge <?= $color ?>"><?= $status ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="editInvoice('<?= $p->id ?>')">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteInvoice('<?= $p->id ?>')">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="fadd-invoice"></div>
            <div class="fedit-invoice"></div>
        </div>
    </div>
</section>
<script>
    function tambahInvoice() {
        $.ajax({
            url: "/faddinvoice",
            type: "get",
            dataType: "json",
            success: function(responds) {
                $('.fadd-invoice').html(responds)
                $("#tambahInvoice").modal("toggle")
            }
        });
    }

    function editInvoice(id) {
        $.ajax({
            url: "/feditinvoice",
            data: {
                id: id,
            },
            type: "get",
            dataType: "json",
            success: function(responds) {
                $('.fedit-invoice').html(responds)
                $("#editInvoice").modal("toggle")
            }
        });
    }

    function deleteInvoice(id) {
        Swal.fire({
            icon: "question",
            title: "Benar akan menghapus data ini ?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Ya",
            denyButtonText: `Tidak`
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/delinvoice",
                    data: {
                        id: id,
                    },
                    method: "post",
                    dataType: "json",
                    success: function(responds) {
                        if (responds.status) {
                            Swal.fire({
                                icon: 'success',
                                title: responds.psn,
                                confirmButtonText: "OK",
                            }).then((result) => {
                                window.location.href = "/invoice";
                            });
                        }
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Data batal dihapus", "", "info");
            }
        })
    }

    function bayarInvoice(id) {
        Swal.fire({
            icon: "question",
            title: "Benar akan membayar invoice ini ?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Ya",
            denyButtonText: `Tidak`
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/payinvoice",
                    data: {
                        id: id,
                    },
                    method: "post",
                    dataType: "json",
                    success: function(responds) {
                        if (responds.status) {
                            Swal.fire({
                                icon: 'success',
                                title: responds.psn,
                                confirmButtonText: "OK",
                            }).then((result) => {
                                window.location.href = "/invoice";
                            });
                        }
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Data batal dipay", "", "info");
            }
        })
    }
    // simpan data invoice
    $(document).on("submit", "#simpanInvoice", function(e) {
        e.preventDefault()
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: "post",
            dataType: "json",
            success: function(responds) {
                if (responds.status) {
                    $("#tambahInvoice").modal("toggle")
                    Swal.fire({
                        icon: 'success',
                        title: responds.psn,
                        confirmButtonText: "OK",
                    }).then((result) => {
                        window.location.href = "/invoice";
                    });
                } else {
                    $.each(responds.errors, function(key, value) {
                        $('[name="' + key + '"]').addClass('is-invalid')
                        $('[name="' + key + '"]').next().text(value)
                        if (value == "") {
                            $('[name="' + key + '"]').removeClass('is-invalid')
                            $('[name="' + key + '"]').addClass('is-valid')
                        }
                    })
                }
            }
        });
    })
    // update data invoice
    $(document).on("submit", "#updateInvoice", function(e) {
        e.preventDefault()
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: "post",
            dataType: "json",
            success: function(responds) {
                if (responds.status) {
                    $("#editInvoice").modal("toggle")
                    Swal.fire({
                        icon: 'success',
                        title: responds.psn,
                        confirmButtonText: "OK",
                    }).then((result) => {
                        window.location.href = "/invoice";
                    });
                } else {
                    $.each(responds.errors, function(key, value) {
                        $('[name="' + key + '"]').addClass('is-invalid')
                        $('[name="' + key + '"]').next().text(value)
                        if (value == "") {
                            $('[name="' + key + '"]').removeClass('is-invalid')
                            $('[name="' + key + '"]').addClass('is-valid')
                        }
                    })
                }
            }
        });
    })
</script>
<?php $this->endSection() ?>