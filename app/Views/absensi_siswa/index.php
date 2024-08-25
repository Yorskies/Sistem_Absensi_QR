<?php $session = \Config\Services::session() ?>
<?php $this->extend('share_pages/layout') ?>
<?php $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header text-center">
            <h4><?= $title ?></h4>
        </div>
        <div class="card-body text-center">
            <?php if(isset($qr_code_url)): ?>
                <img src="<?= base_url($qr_code_url) ?>" alt="QR Code Absensi Siswa" />
            <?php else: ?>
                <p>QR Code tidak tersedia.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<script>
    function refreshQRCode() {
        // Fungsi untuk me-refresh QR code, bisa ditambahkan jika diperlukan
        location.reload();
    }
</script>
<?php $this->endSection() ?>
