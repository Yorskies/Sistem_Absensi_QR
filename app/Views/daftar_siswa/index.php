<?php $session = \Config\Services::session() ?>
<?php $this->extend('share_pages/layout') ?>
<?php $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header text-end">
            <h4><?= $title ?></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mt-3" id="table1">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th>No.</th>
                            <th>Nomor Induk</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($siswa as $s) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $s->nomor_induk ?></td>
                                <td><?= $s->nama ?></td>
                                <td><?= $s->kelas ?></td>
                                <td>
                                    <?php
                                    $statusColor = ($s->status == 'Aktif') ? 'bg-success' : 'bg-danger';
                                    ?>
                                    <span class="badge <?= $statusColor ?>"><?= $s->status ?></span>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php $this->endSection() ?>
