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
                            <th>No </th>
                            <th>Tanggal </th>
                            <th>Hari </th>
                            <th>Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($pembayaran as $p) : ?>
                            <tr>
                                <td><?= $no++ ?> </td>
                                <td><?= date('d-M-Y', strtotime($p->tgl)) ?> </td>
                                <td><?= number_format($p->nominal, 0, ',', '.') ?> </td>
                                <td>
                                    <a href="/cetakinv/<?= $p->no_inv ?>" target="_blank" class="btn btn-sm btn-danger">Cetak Laporan</a>
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