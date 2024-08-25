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
                            <th>Jam</th>
                            <th>Senin</th>
                            <th>Selasa</th>
                            <th>Rabu</th>
                            <th>Kamis</th>
                            <th>Jumat</th>
                            <th>Sabtu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwal as $j) : ?>
                            <tr>
                                <td><?= $j->jam_mulai ?> - <?= $j->jam_selesai ?></td>
                                <td><?= $j->hari == 'Senin' ? $j->mata_pelajaran_name . ' ('. $j->nama_guru .')' : '-' ?></td>
                                <td><?= $j->hari == 'Selasa' ? $j->mata_pelajaran_name . ' ('. $j->nama_guru .')' : '-' ?></td>
                                <td><?= $j->hari == 'Rabu' ? $j->mata_pelajaran_name . ' ('. $j->nama_guru .')' : '-' ?></td>
                                <td><?= $j->hari == 'Kamis' ? $j->mata_pelajaran_name . ' ('. $j->nama_guru .')' : '-' ?></td>
                                <td><?= $j->hari == 'Jumat' ? $j->mata_pelajaran_name . ' ('. $j->nama_guru .')' : '-' ?></td>
                                <td><?= $j->hari == 'Sabtu' ? $j->mata_pelajaran_name . ' ('. $j->nama_guru .')' : '-' ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php $this->endSection() ?>
