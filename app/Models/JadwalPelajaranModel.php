<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalPelajaranModel extends Model
{
    protected $table = 'jadwal_pelajaran';
    protected $primaryKey = 'id';
    protected $returnType       = 'object'; // Ubah ke 'object' jika ingin mengembalikan objek
    protected $allowedFields = ['guru_id', 'mata_pelajaran_id', 'hari', 'jam_mulai', 'jam_selesai'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Fungsi tambahan jika diperlukan
}
