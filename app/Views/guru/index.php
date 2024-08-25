<?php $session = \Config\Services::session() ?>
<?php $this->extend('share_pages/layout') ?>
<?php $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header text-end">
            <h4><?= $title ?></h4>
        </div>
        <div class="card-body">
            <button class="btn btn-primary mb-4" onclick="tambahGuru()">Tambah Data Guru</button>
            <div class="table-responsive">
                <table class="table table-striped mt-3" id="table1">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th>No.Urut</th>
                            <th>Nomor Induk</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Mata Pelajaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($guru as $g) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $g->nomor_induk ?></td>
                                <td><?= $g->nama ?></td>
                                <td><?= $g->username ?></td>
                                <td><?= $g->mata_pelajaran_name ?></td>
                                <td>
                                    <?php if ($g->status == 'Aktif') {
                                        $color = 'bg-success';
                                        $status = 'Aktif';
                                    } else {
                                        $color = 'bg-danger';
                                        $status = 'Tidak Aktif';
                                    } ?>
                                    <span class="badge <?= $color ?>"><?= $status ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="editGuru('<?= $g->id ?>')">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteGuru('<?= $g->id ?>')">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="fadd-guru"></div>
            <div class="fedit-guru"></div>
        </div>
    </div>
</section>
<script>
    function tambahGuru() {
        $.ajax({
            url: "/guru/fadd",
            type: "get",
            dataType: "json",
            success: function(responds) {
                $('.fadd-guru').html(responds);
                $("#tambahGuru").modal("toggle");
            }
        });
    }

    function editGuru(id) {
        $.ajax({
            url: "/guru/fedit",
            data: {
                id: id,
            },
            type: "get",
            dataType: "json",
            success: function(responds) {
                $('.fedit-guru').html(responds);
                $("#editGuru").modal("toggle");
            }
        });
    }

    function deleteGuru(id) {
        Swal.fire({
            icon: "question",
            title: "Benar akan menghapus data ini?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Ya",
            denyButtonText: `Tidak`
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/guru/delete",
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
                            }).then(() => {
                                window.location.href = "/guru";
                            });
                        }
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Data tidak jadi dihapus', '', 'info');
            }
        });
    }

    // simpan data guru
    $(document).on("submit", "#simpanGuru", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: "post",
            dataType: "json",
            success: function(responds) {
                if (responds.status) {
                    $("#tambahGuru").modal("toggle");
                    Swal.fire({
                        icon: 'success',
                        title: responds.psn,
                        confirmButtonText: "OK",
                    }).then(() => {
                        window.location.href = "/guru";
                    });
                } else {
                    $.each(responds.errors, function(key, value) {
                        $('[name="' + key + '"]').addClass('is-invalid');
                        $('[name="' + key + '"]').next().text(value);
                        if (value == "") {
                            $('[name="' + key + '"]').removeClass('is-invalid');
                            $('[name="' + key + '"]').addClass('is-valid');
                        }
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal menyimpan data',
                        text: 'Periksa kembali form Anda dan coba lagi.',
                    });
                }
            }
        });
    });

    // update data guru
    $(document).on("submit", "#updateGuru", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: "post",
            dataType: "json",
            success: function(responds) {
                if (responds.status) {
                    $("#editGuru").modal("toggle");
                    Swal.fire({
                        icon: 'success',
                        title: responds.psn,
                        confirmButtonText: "OK",
                    }).then(() => {
                        window.location.href = "/guru";
                    });
                } else {
                    $.each(responds.errors, function(key, value) {
                        $('[name="' + key + '"]').addClass('is-invalid');
                        $('[name="' + key + '"]').next().text(value);
                        if (value == "") {
                            $('[name="' + key + '"]').removeClass('is-invalid');
                            $('[name="' + key + '"]').addClass('is-valid');
                        }
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal memperbarui data',
                        text: 'Periksa kembali form Anda dan coba lagi.',
                    });
                }
            }
        });
    });
</script>
<?php $this->endSection() ?>
