<?php $session = \Config\Services::session() ?>
<?php $this->extend('share_pages/layout') ?>
<?php $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header text-end">
            <h4><?= $title ?></h4>
        </div>
        <div class="card-body">
            <!-- Tombol untuk membuat QR Code untuk semua siswa -->
            <button class="btn btn-primary mb-4" onclick="generateAllQrCodes()">Generate QR Code untuk Semua Siswa</button>
            
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
                            <th>QR Code</th>
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
                                    <?php if (!empty($p->qr_code_url)) : ?>
                                        <button class="btn btn-sm btn-info"  onclick="tampilkanQR(<?= $p->id ?>)">Lihat QR</button>
                                    <?php else : ?>
                                        <span class="text-muted">Belum Dibuat</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="fshow-qrsiswa"></div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function generateAllQrCodes() {
        $.ajax({
            url: "/siswa/generate_qr_codes_for_all",
            type: "get",
            dataType: "json",
            beforeSend: function() {
                Swal.fire({
                    title: 'Proses',
                    text: 'Sedang membuat QR Code...',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: response.psn,
                        confirmButtonText: 'OK',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        location.reload(); // Reload halaman untuk memperbarui data
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.psn || 'Terjadi kesalahan saat membuat QR Code untuk semua siswa.',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error Details:', textStatus, errorThrown);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan',
                    text: 'Gagal menghubungi server. Detail kesalahan ada di konsol.',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    function tampilkanQR(id) {
        $.ajax({
            url: "/siswa/uploads",
            data: {
                id: id,
            },
            type: "get",
            dataType: "json",
            success: function(responds) {
                $('.fshow-qrsiswa').html(responds);
                $("#showQrCodeModal").modal("toggle");
            },
            error: function (request, status, error) {
                console.log(request.responseText),
            alert(request.responseText);
            }
        });
    }
</script>

<?php $this->endSection() ?>
