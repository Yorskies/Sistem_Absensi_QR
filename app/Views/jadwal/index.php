<?php $session = \Config\Services::session() ?>
<?php $this->extend('share_pages/layout') ?>
<?php $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header text-end">
            <h4><?= $title ?></h4>
        </div>
        <div class="card-body">
            <button class="btn btn-primary mb-4" onclick="tambahJadwal()">Tambah Jadwal Pelajaran</button>
            <div class="table-responsive">
                <table class="table table-striped mt-3" id="table1">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th>No.Urut</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                            <th>Hari</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($jadwal as $j) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $j->mata_pelajaran_name ?></td>
                                <td><?= $j->nama_guru ?></td>
                                <td><?= $j->hari ?></td>
                                <td><?= $j->jam_mulai ?></td>
                                <td><?= $j->jam_selesai ?></td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="editJadwal('<?= $j->id ?>')">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteJadwal('<?= $j->id ?>')">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="fadd-jadwal"></div>
            <div class="fedit-jadwal"></div>
        </div>
    </div>
</section>
<script>
    function tambahJadwal() {
        $.ajax({
            url: "/jadwal/fadd", // Menyesuaikan dengan endpoint fadd
            type: "get",
            dataType: "json",
            success: function(response) {
                $('.fadd-jadwal').html(response);
                $("#tambahJadwal").modal("toggle");
            }
        });
    }

    function editJadwal(id) {
        $.ajax({
            url: "/jadwal/fedit", // Menyesuaikan dengan endpoint fedit
            data: { id: id },
            type: "get",
            dataType: "json",
            success: function(response) {
                $('.fedit-jadwal').html(response);
                $("#editJadwal").modal("toggle");
            }
        });
    }

    function deleteJadwal(id) {
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
                    url: "/jadwal/delete",
                    data: { id: id },
                    method: "post",
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: response.psn,
                                confirmButtonText: "OK",
                            }).then(() => {
                                window.location.href = "/jadwal";
                            });
                        }
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Data tidak jadi dihapus', '', 'info');
            }
        });
    }

    // simpan data jadwal
    $(document).on("submit", "#simpanJadwal", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: "post",
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    $("#tambahJadwal").modal("toggle");
                    Swal.fire({
                        icon: 'success',
                        title: response.psn,
                        confirmButtonText: "OK",
                    }).then(() => {
                        window.location.href = "/jadwal";
                    });
                } else {
                    $.each(response.errors, function(key, value) {
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

    // update data jadwal
    $(document).on("submit", "#updateJadwal", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: "post",
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    $("#editJadwal").modal("toggle");
                    Swal.fire({
                        icon: 'success',
                        title: response.psn,
                        confirmButtonText: "OK",
                    }).then(() => {
                        window.location.href = "/jadwal";
                    });
                } else {
                    $.each(response.errors, function(key, value) {
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
