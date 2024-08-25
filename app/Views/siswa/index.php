<?php $session = \Config\Services::session() ?>
<?php $this->extend('share_pages/layout') ?>
<?php $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header text-end">
            <h4><?= $title ?></h4>
        </div>
        <div class="card-body">
            <button class="btn btn-primary mb-4" onclick="tambahSiswa()">Tambah Data Siswa</button>
            <div class="table-responsive">
                <table class="table table-striped mt-3" id="table1">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th>No.Urut</th>
                            <th>Nomor Induk</th>
                            <th>Nama</th>
                            <th>Nama Pengguna</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($siswa as $p) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $p->nomor_induk ?></td>
                                <td><?= $p->nama ?></td>
                                <td><?= $p->username ?></td>
                                <td><?= $p->kelas ?></td>
                                <td>
                                    <?php if ($p->status == 'Aktif') {
                                        $color = 'bg-success';
                                        $status = 'Aktif';
                                    } else {
                                        $color = 'bg-danger';
                                        $status = 'Tidak Aktif';
                                    } ?>
                                    <span class="badge <?= $color ?>"><?= $status ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="editSiswa('<?= $p->id ?>')">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteSiswa('<?= $p->id ?>')">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="fadd-siswa"></div>
            <div class="fedit-siswa"></div>
        </div>
    </div>
</section>
<script>
    function tambahSiswa() {
        $.ajax({
            url: "/siswa/fadd",
            type: "get",
            dataType: "json",
            success: function(responds) {
                $('.fadd-siswa').html(responds);
                $("#tambahSiswa").modal("toggle");
            }
        });
    }

    function editSiswa(id) {
        $.ajax({
            url: "/siswa/fedit",
            data: {
                id: id,
            },
            type: "get",
            dataType: "json",
            success: function(responds) {
                $('.fedit-siswa').html(responds);
                $("#editSiswa").modal("toggle");
            }
        });
    }

    function deleteSiswa(id) {
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
                    url: "/siswa/delete",
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
                                window.location.href = "/siswa";
                            });
                        }
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Data tidak jadi dihapus', '', 'info');
            }
        });
    }

    // simpan data siswa
    $(document).on("submit", "#simpanSiswa", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: "post",
            dataType: "json",
            success: function(responds) {
                if (responds.status) {
                    $("#tambahSiswa").modal("toggle");
                    Swal.fire({
                        icon: 'success',
                        title: responds.psn,
                        confirmButtonText: "OK",
                    }).then(() => {
                        window.location.href = "/siswa";
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

    // update data siswa
    $(document).on("submit", "#updateSiswa", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: "post",
            dataType: "json",
            success: function(responds) {
                if (responds.status) {
                    $("#editSiswa").modal("toggle");
                    Swal.fire({
                        icon: 'success',
                        title: responds.psn,
                        confirmButtonText: "OK",
                    }).then(() => {
                        window.location.href = "/siswa";
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
