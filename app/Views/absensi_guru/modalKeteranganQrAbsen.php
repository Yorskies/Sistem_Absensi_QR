<!-- Modal for showing QR Code -->
<div class="modal fade text-left" id="showQrCodeModal" tabindex="-1" role="dialog" aria-labelledby="showQrCodeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="showQrCodeLabel">QR Code Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if ($siswa->qr_code_url): ?>
                    <div class="text-center">
                        <img src="<?= base_url($siswa->qr_code_url) ?>" alt="QR Code" class="img-fluid">
                    </div>
                <?php else: ?>
                    <p>QR Code belum dibuat.</p>
                <?php endif; ?>

                <div class="mt-3">
                    <p><strong>Nomor Induk Siswa:</strong> <?= htmlspecialchars($siswa->nomor_induk) ?></p>
                    <p><strong>Nama:</strong> <?= htmlspecialchars($siswa->nama) ?></p>
                    <p><strong>Kelas:</strong> <?= htmlspecialchars($siswa->kelas) ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($status) ?></p>
                    <p><strong>Discan Oleh:</strong> <?= htmlspecialchars($guru->nama) ?></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
