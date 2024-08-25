<?php $session = \Config\Services::session() ?>
<?php $this->extend('share_pages/layout') ?>
<?php $this->section('content') ?>

<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="mr-3"><?= $title ?></h4>
            </div>
            <div class="text-muted">
                <span id="currentDate">
                    <?php
                    setlocale(LC_TIME, 'id_ID.UTF-8');
                    echo strftime('%A, %d %B %Y'); // Format tanggal dalam bahasa Indonesia
                    ?>
                </span> - 
                <span id="currentTime"><?= date('H:i:s') ?></span>
            </div>
        </div>
        <div class="card-body">
            <div class="button-group">
                <button class="btn btn-primary mb-4" onclick="tambahManual()">Tambah Manual</button>
                <button class="btn btn-secondary mb-4" onclick="buatLaporan()">Buat Laporan</button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped mt-3" id="table1">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th>No.</th>
                            <th>Nomor Induk</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Discan Pada</th>
                            <th>Discan Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($absensi as $g) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $g->siswa_nis ?></td>
                                <td><?= $g->nama_siswa['nama'] ?></td>
                                <td><?= $g->nama_siswa['kelas'] ?></td>
                                <td>
                                    <?php
                                    // Tentukan warna berdasarkan status
                                    switch ($g->status) {
                                        case 'Hadir':
                                            $statusColor = 'bg-success';
                                            break;
                                        case 'Absen':
                                            $statusColor = 'bg-danger';
                                            break;
                                        default:
                                            $statusColor = 'bg-warning';
                                            break;
                                    }
                                    ?>
                                    <span class="badge <?= $statusColor ?>"><?= $g->status ?></span>
                                </td>
                                <td><?= $g->keterangan_waktu?></td>
                                <td><?= $g->nama_guru ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="fadd-absensi"></div>
            <div class="fedit-absensi"></div>
        </div>
    </div>
</section>

<script>
    // Function to update the time every second
    function updateTime() {
        var now = new Date();
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var seconds = String(now.getSeconds()).padStart(2, '0');

        document.getElementById('currentTime').textContent = hours + ':' + minutes + ':' + seconds;
    }

    // Update time every second
    setInterval(updateTime, 1000);

    function tambahManual() {
        $.ajax({
            url: "/guru/absensi/fadd",  // URL untuk menampilkan form tambah absensi
            type: "get",
            dataType: "json",
            success: function(response) {
                $('.fadd-absensi').html(response);
                $("#tambahAbsensi").modal("toggle");  // Pastikan ID modal ini ada di HTML
            }
        });
    }

    function buatLaporan() {
        window.location.href = "/absensi/create-report";  // URL untuk membuat laporan
    }

    // Fungsi untuk menyimpan data absensi manual melalui AJAX
    $(document).on("submit", "#simpanAbsensi", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            data: $(this).serialize(),
            method: "post",
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    $("#tambahAbsensi").modal("toggle");  // Pastikan ID modal ini ada di HTML
                    Swal.fire({
                        icon: 'success',
                        title: response.psn,
                        confirmButtonText: "OK",
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    $.each(response.errors, function(key, value) {
                        var input = $('[name="' + key + '"]');
                        input.addClass('is-invalid');
                        input.next().text(value);
                        if (value == "") {
                            input.removeClass('is-invalid').addClass('is-valid');
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
</script>

<?php $this->endSection() ?>
