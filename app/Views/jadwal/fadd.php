<?php

// Pastikan data sudah ada
$mataPelajaran = $mataPelajaran ?? [];
?>

<div class="modal fade text-left" id="tambahJadwal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">Form Tambah Data Jadwal</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="simpanJadwal" action="/jadwal/simpan" method="post" class="form form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Guru</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" id="guru" name="guru_id" required>
                                <option value="">Pilih Guru</option>
                                <!-- Opsi guru akan diisi oleh JavaScript -->
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Mata Pelajaran</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" id="mataPelajaran" name="mata_pelajaran_id" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                <?php foreach ($mataPelajaran as $mp): ?>
                                    <option value="<?= $mp->id ?>"><?= $mp->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Hari</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="hari" required>
                                <option value="">Pilih Hari</option>
                                <?php foreach ($hariOptions as $key => $value): ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Jam Mulai</label>
                        </div>
                        <div class="col-md-8">
                            <input type="time" class="form-control" name="jam_mulai" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label>Jam Selesai</label>
                        </div>
                        <div class="col-md-8">
                            <input type="time" class="form-control" name="jam_selesai" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Ketika pilihan mata pelajaran berubah
    $('#mataPelajaran').change(function() {
        var mataPelajaranId = $(this).val();

        // Kosongkan dropdown guru
        $('#guru').html('<option value="">Pilih Guru</option>');

        if (mataPelajaranId) {
            $.ajax({
                url: '/jadwal/get-guru/' + mataPelajaranId,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        var guruOptions = '<option value="">Pilih Guru</option>';
                        $.each(response.guru, function(index, guru) {
                            guruOptions += '<option value="' + guru.id + '">' + guru.nama + '</option>';
                        });
                        $('#guru').html(guruOptions);
                    }
                }
            });
        }
    });
</script>
