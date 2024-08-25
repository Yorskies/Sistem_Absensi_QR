<?php $session = \Config\Services::session() ?>
<?php $this->extend('share_pages/layout') ?>
<?php $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header text-end">
            <h4><?= $title ?></h4>
        </div>
        <div class="card-body">
            <button class="btn btn-primary mb-4" onclick="tambahCustomer()">Tambah Data Siswa</button>
            <div class="table-responsive">
                <table class="table table-striped mt-3" id="table1">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th>No.Urut </th>
                            <th>No.Induk </th>
                            <th>Nama </th>
                            <th>Kelas </th>
                            <th>Status</th>
                            <th>Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($customer as $p) : ?>
                            <tr>
                                <td><?= $no++ ?> </td>
                                <td><?= $p->nama ?> </td>
                                <td><?= $p->alamat ?> </td>
                                <td><?= $p->telp ?> </td>
                                <td>
                                    <?php if ($p->status == 1) {
                                        $color = 'bg-success';
                                        $status = 'Aktif';
                                    } else {
                                        $color = 'bg-danger';
                                        $status = 'Tidak Aktif';
                                    } ?>
                                    <span class="badge <?= $color ?>"><?= $status ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="editCustomer('<?= $p->id ?>')">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteCustomer('<?= $p->id ?>')">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="fadd-customer"></div>
            <div class="fedit-customer"></div>
        </div>
    </div>
</section>
<script>
    function tambahCustomer() {
        $.ajax({
            url: "/faddcustomer",
            type: "get",
            dataType: "json",
            success: function(responds) {
                $('.fadd-customer').html(responds)
                $("#tambahCustomer").modal("toggle")
            }
        });
    }

    function editCustomer(id) {
        $.ajax({
            url: "/feditcustomer",
            data: {
                id: id,
            },
            type: "get",
            dataType: "json",
            success: function(responds) {
                $('.fedit-customer').html(responds)
                $("#editCustomer").modal("toggle")
            }
        });
    }

    function deleteCustomer(id) {
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
                    url: "/delcustomer",
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
                                window.location.href = "/customer";
                            });
                        }
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Data batal dihapus", "", "info");
            }
        })
    }
    // simpan data customer
    $(document).on("submit", "#simpanCustomer", function(e) {
        e.preventDefault()
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: "post",
            dataType: "json",
            success: function(responds) {
                if (responds.status) {
                    $("#tambahCustomer").modal("toggle")
                    Swal.fire({
                        icon: 'success',
                        title: responds.psn,
                        confirmButtonText: "OK",
                    }).then((result) => {
                        window.location.href = "/customer";
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
    // update data customer
    $(document).on("submit", "#updateCustomer", function(e) {
        e.preventDefault()
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: "post",
            dataType: "json",
            success: function(responds) {
                if (responds.status) {
                    $("#editCustomer").modal("toggle")
                    Swal.fire({
                        icon: 'success',
                        title: responds.psn,
                        confirmButtonText: "OK",
                    }).then((result) => {
                        window.location.href = "/customer";
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