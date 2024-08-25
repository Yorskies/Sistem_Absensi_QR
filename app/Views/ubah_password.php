<?php $session = \Config\Services::session(); ?>
<?php $this->extend('share_pages/layout'); ?>
<?php $this->section('content'); ?>

<section class="section">
    <div class="card">
        <div class="card-header text-end">
            <h4><?= $title ?></h4>
        </div>
        <div class="card-body">
            <?php if ($session->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= $session->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($session->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $session->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form class="form form-horizontal" action="/profile/submit_pssbaru" method="POST">
                <?= csrf_field(); ?>
                <input type="hidden" name="nip" value="<?= $session->get('nip'); ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label>Password Baru</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="password" class="form-control" name="pss1" required>
                    </div>
                    <div class="col-md-3">
                        <label>Konfirmasi Password</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="password" class="form-control" name="pss2" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ms-3 mt-2">Update</button>
            </form>
        </div>
    </div>
</section>

<?php $this->endSection(); ?>
