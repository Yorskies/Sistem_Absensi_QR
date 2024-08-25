<?php $session = \Config\Services::session() ?>
<?php $this->extend('share_pages/layout') ?>
<?php $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header text-end">
            <h4><?= $title ?></h4>
        </div>
        <div class="card-body">
            <button class="btn btn-primary mb-4" onclick="tambahMapel()">Tambah Mata Pelajaran</button>
            <div class="table-responsive">
                <table class="table table-striped mt-3" id="table1">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th>No.Urut </th>
                            <th>Nama Mata Pelajaran</th>
                            <th>Status</th>
                            <th>Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($mataPelajaran as $m) : ?>
                            <tr>
                                <td><?= $no++ ?> </td>
                                <td><?= $m->nama ?> </td>
                                <td>
                                    <?php if ($m->status == 1) {
                                        $color = 'bg-success';
                                        $status = 'Aktif';
                                    } else {
                                        $color = 'bg-danger';
                                        $status = 'Tidak Aktif';
                                    } ?>
                                    <span class="badge <?= $color ?>"><?= $status ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="editMapel('<?= $m->id ?>')">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteMapel('<?= $m->id ?>')">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="fadd-mapel"></div>
            <div class="fedit-mapel"></div>
        </div>
    </div>
</section>
<script>
    function tambahMapel() {
        $.ajax({
            url: "/mata-pelajaran/fadd",
            type: "get",
            dataType: "json",
            success: function(responds) {
                $('.fadd-mapel').html(responds)
                $("#tambahMapel").modal("toggle")
            }
        });
    }

    function editMapel(id) {
        $.ajax({
            url: "/mata-pelajaran/fedit",
            data: {
                id: id,
            },
            type: "get",
            dataType: "json",
            success: function(responds) {
                $('.fedit-mapel').html(responds)
                $("#editMapel").modal("toggle")
            }
        });
    }

    function deleteMapel(id) {
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
                    url: "/mata-pelajaran/delete",
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
                                window.location.href = "/mata-pelajaran";
                            });
                        }
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Data batal dihapus", "", "info");
            }
        })
    }

    // simpan data mapel
    $(document).on("submit", "#simpanMapel", function(e) {
        e.preventDefault()
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: "post",
            dataType: "json",
            success: function(responds) {
                if (responds.status) {
                    $("#tambahMapel").modal("toggle")
                    Swal.fire({
                        icon: 'success',
                        title: responds.psn,
                        confirmButtonText: "OK",
                    }).then((result) => {
                        window.location.href = "/mata-pelajaran";
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

    // update data mapel
    $(document).on("submit", "#updateMapel", function(e) {
        e.preventDefault()
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: "post",
            dataType: "json",
            success: function(responds) {
                if (responds.status) {
                    $("#editMapel").modal("toggle")
                    Swal.fire({
                        icon: 'success',
                        title: responds.psn,
                        confirmButtonText: "OK",
                    }).then((result) => {
                        window.location.href = "/mata-pelajaran";
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
